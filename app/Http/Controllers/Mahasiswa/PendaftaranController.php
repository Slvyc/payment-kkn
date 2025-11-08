<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Payment;
use Midtrans\Snap;

class PendaftaranController extends Controller
{
    public function index()
    {
        // 1. Ambil HANYA ID mahasiswa dari session
        $mahasiswaId = Session::get('mahasiswa_data')['id'];
        // 2. Cari mahasiswa itu di tabel lokal menggunakan ID-nya
        $mahasiswa = Mahasiswa::find($mahasiswaId);

        // Jika bukan mahasiswa direct 
        if (!$mahasiswaId) {
            return redirect()->route('login')->withErrors('Sesi habis.');
        }

        // panggil Api endpoinst jenis kkn 
        $siakadApiUrl = 'http://127.0.0.1:8000/api/kkn/jenis';
        // $secretKeySiakad = env('SYSTEM_API_KEY');
        $secretKeySiakad = 'starkey-aespo';
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
            // ...
        }

        // 3. Kirim OBJEK mahasiswa ke view
        return view('pembayaran', [
            'mahasiswa' => $mahasiswa,
            'jenisKknList' => $jenisKknList // <-- Kirim data dropdown
        ]);
    }

    public function createTransaction(Request $request)
    {
        // 1. Validasi input dari JS
        $request->validate(['jenis_kkn_id' => 'required|integer']);
        $jenisKknIdDipilih = $request->jenis_kkn_id;

        // 2. Validasi ke API Siakad
        $siakadToken = Session::get('siakad_token');
        $siakadApiUrl = 'http://127.0.0.1:8000/api/kkn/syarat';

        $validasiResponse = Http::withToken($siakadToken)
            ->post($siakadApiUrl, ['jenis_kkn_id' => $jenisKknIdDipilih]);

        // 3. Handle jika GAGAL (SKS kurang, jadwal tutup, dll)
        if ($validasiResponse->failed()) {
            return response()->json($validasiResponse->json(), $validasiResponse->status());
        }

        // 4. Handle jika SUKSES
        $dataFromSiakad = $validasiResponse->json()['data'];
        $biayaKkn = $dataFromSiakad['biaya'];

        // 5. Buat Tagihan Lokal (DB KKN Payment)
        $mahasiswaData = Session::get('mahasiswa_data');
        $orderId = 'KKN-' . $mahasiswaData['id'] . '-' . time();

        $payment = Payment::create([
            'order_id' => $orderId,
            'mahasiswa_id' => $mahasiswaData['id'],
            'jenis_kkn_id' => $jenisKknIdDipilih,
            'jenis_kkn' => $dataFromSiakad['jenis_kkn'],
            'amount' => $biayaKkn,
            'status' => 'pending',
        ]);

        // 6. Siapkan data & Panggil Midtrans
        $midtransParams = [
            'transaction_details' => [
                'order_id' => $payment->order_id, // Ambil dari payment yg baru dibuat
                'gross_amount' => $biayaKkn
            ],
            'item_details' => [[
                // --- PERBAIKAN 1 ---
                'id' => (string) $jenisKknIdDipilih, // Cast ke string
                'price' => $biayaKkn,
                'quantity' => 1,
                'name' => 'KKN ' . $dataFromSiakad['jenis_kkn']
            ]],
            'customer_details' => [
                // --- PERBAIKAN 2 ---
                // Pastikan 'nama' dan 'email' tidak null/kosong
                'first_name' => $mahasiswaData['name'],
                'email' => $mahasiswaData['email'] ?? $mahasiswaData['nim'] . '@example.com',
            ],
        ];

        $snapToken = Snap::getSnapToken($midtransParams);

        // 7. Simpan snap token & kirim ke JS
        $payment->snap_token = $snapToken;
        $payment->save();

        return response()->json(['snap_token' => $snapToken]);
    }

    public function riwayatTransaksi()
    {

        $mahasiswaId = Session::get('mahasiswa_data');

        // ambil payment sesuai mahasiswa id
        $payments = Payment::where('mahasiswa_id', $mahasiswaId['id'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('riwayat-transaksi', [
            'payments' => $payments
        ]);
    }
}
