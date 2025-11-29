<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\PendaftaranKkn;
use App\Models\Payment;
use Midtrans\Snap;
use Midtrans\Transaction;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\map;

class PendaftaranController extends Controller
{
    public function index()
    {

        // 1. Ambil HANYA ID mahasiswa dari session
        $mahasiswaId = Session::get('mahasiswa_data')['id'];
        // 2. Cari mahasiswa itu di tabel lokal menggunakan ID-nya
        $mahasiswa = Mahasiswa::find($mahasiswaId);

        // cek apa udah isi biodata apa ga? kalo ga direct ke halaman biodata   
        if (
            !$mahasiswa->no_hp ||
            !$mahasiswa->no_hp_darurat ||
            !$mahasiswa->jenis_kelamin ||
            !$mahasiswa->ukuran_jacket_rompi ||
            !$mahasiswa->keahlian
        ) {
            return redirect()->route('mahasiswa.biodata.index')
                ->with('warning', 'Lengkapi biodata terlebih dahulu sebelum memilih KKN.');
        }

        // Jika bukan mahasiswa direct 
        if (!$mahasiswaId) {
            return redirect()->route('login')->withErrors('Sesi habis.');
        }

        $pendingPayment = Payment::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'pending')
            ->first();

        // panggil Api endpoinst jenis kkn 
        $siakadApiUrl = 'https://mini-siakad.cloud/api/kkn/jenis';
        // $secretKeySiakad = env('SYSTEM_API_KEY');
        $secretKeySiakad = env('SYSTEM_API_KEY');
        $jenisKknList = [];

        try {
            // UBAH BAGIAN INI: Tambahkan withHeaders()
            $response = Http::withHeaders([
                'X-SYSTEM-KEY' => $secretKeySiakad,
                'Accept' => 'application/json'
            ])->get($siakadApiUrl);
            // AKHIR PERUBAHAN

            if ($response->successful()) {
                $jenisKknList = $response->json()['data'] ?? [];
            }
        } catch (\Exception $e) {
        }

        // 3. Kirim OBJEK mahasiswa ke view
        return view('pembayaran', [
            'mahasiswa' => $mahasiswa,
            'jenisKknList' => $jenisKknList, // <-- Kirim data dropdown
            'pendingPayment' => $pendingPayment
        ]);
    }

    public function createTransaction(Request $request)
    {
        $request->validate(['jenis_kkn_id' => 'required|integer']);
        $jenisKknIdDipilih = $request->jenis_kkn_id;

        $mahasiswaData = Session::get('mahasiswa_data');
        $mahasiswaId = $mahasiswaData['id'];

        // Cek apakah mahasiswa sudah pernah daftar KKN valid
        $pendaftaran = PendaftaranKkn::where('mahasiswa_id', $mahasiswaId)->first();
        if ($pendaftaran && $pendaftaran->status_pendaftaran === 'valid') {
            return response()->json([
                'message' => 'Anda sudah terdaftar KKN.',
                'status' => 'failed'
            ], 400);
        }

        // 1. Validasi Syarat ke SIAKAD
        $siakadToken = Session::get('siakad_token');
        $validasiResponse = Http::withToken($siakadToken)
            ->post('https://mini-siakad.cloud/api/kkn/syarat', [
                'jenis_kkn_id' => $jenisKknIdDipilih
            ]);

        if ($validasiResponse->failed()) {
            return response()->json($validasiResponse->json(), $validasiResponse->status());
        }

        $dataFromSiakad = $validasiResponse->json()['data'];
        $biayaKkn = $dataFromSiakad['biaya'];

        // 2. Buat ORDER ID
        $orderId = 'KKN-' . $jenisKknIdDipilih . '-' . $mahasiswaId . '-' . time();

        // 3. Buat Payment terlebih dahulu
        $payment = Payment::create([
            'order_id' => $orderId,
            'mahasiswa_id' => $mahasiswaId,
            'jenis_kkn_id' => $jenisKknIdDipilih,
            'jenis_kkn' => $dataFromSiakad['jenis_kkn'],
            'amount' => $biayaKkn,
            'status' => 'pending',
        ]);

        // 4. Jika belum punya pendaftaran → buat
        if (!$pendaftaran) {
            $pendaftaran = PendaftaranKkn::create([
                'mahasiswa_id' => $mahasiswaId,
                'jenis_kkn_id' => $jenisKknIdDipilih,
                'jenis_kkn' => $dataFromSiakad['jenis_kkn'],
                'status_pendaftaran' => 'pending',
                'payment_id' => $payment->id,
            ]);
        }

        // 5. Siapkan Midtrans
        $midtransParams = [
            'transaction_details' => [
                'order_id' => $payment->order_id,
                'gross_amount' => $biayaKkn
            ],
            'item_details' => [[
                'id' => (string) $jenisKknIdDipilih,
                'price' => $biayaKkn,
                'quantity' => 1,
                'name' => 'KKN ' . $dataFromSiakad['jenis_kkn']
            ]],
            'customer_details' => [
                'first_name' => $mahasiswaData['name'],
                'email' => $mahasiswaData['email'] ?? $mahasiswaData['nim'] . '@example.com',
            ],
        ];

        $snapToken = Snap::getSnapToken($midtransParams);

        // 6. Update payment
        $payment->update([
            'snap_token' => $snapToken
        ]);

        return response()->json([
            'snap_token' => $snapToken
        ]);
    }


    public function cancelTransaction($id)
    {
        $mahasiswaId = Session::get('mahasiswa_data')['id'];
        $mahasiswa = Mahasiswa::find($mahasiswaId);

        // Jika bukan mahasiswa direct 
        if (!$mahasiswaId) {
            return redirect()->route('login')->withErrors('Sesi habis.');
        }

        Log::info("Memulai proses pembatalan transaksi lokal", ['payment_id' => $id, 'mahasiswa_id' => $mahasiswaId]);

        // 1. Cari & Validasi Lokal
        $payment = Payment::find($id);

        if (!$payment) {
            Log::warning("Transaksi tidak ditemukan", ['payment_id' => $id]);
            return back()->withErrors('Transaksi tidak ditemukan.');
        }

        if ($payment->mahasiswa_id != $mahasiswaId) {
            Log::warning("Percobaan pembatalan tidak sah", [
                'user_id' => $mahasiswaId,
                'payment_owner' => $payment->mahasiswa_id
            ]);
            return back()->withErrors('Anda tidak berhak membatalkan transaksi ini.');
        }

        if ($payment->status != 'pending') {
            return back()->withErrors('Transaksi ini tidak bisa dibatalkan karena statusnya: ' . $payment->status);
        }

        // Hapus pendaftaran terkait
        $pendaftaran = PendaftaranKkn::where('payment_id', $payment->id)->first();
        if ($pendaftaran) {
            $pendaftaran->delete();
        }

        // 2. Batal Lokal Saja
        $payment->status = 'failed';
        $payment->save();

        Log::info("Transaksi dibatalkan secara lokal", [
            'order_id' => $payment->order_id
        ]);

        return redirect()->route('mahasiswa.riwayat')->with('success', 'Transaksi dibatalkan.');
    }

    public function riwayatTransaksi()
    {
        $mahasiswaId = Session::get('mahasiswa_data');

        // ambil payment sesuai mahasiswa id
        $payments = Payment::where('mahasiswa_id', $mahasiswaId['id'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $mahasiswa = Mahasiswa::where('id', $mahasiswaId)->first();

        return view('riwayat-transaksi', [
            'payments' => $payments,
            'mahasiswa' => $mahasiswa
        ]);
    }
}
