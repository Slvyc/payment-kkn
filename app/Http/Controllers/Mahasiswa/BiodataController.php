<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class BiodataController extends Controller
{
    public function index()
    {
        // Ambil dari session
        $mahasiswaSession = Session::get('mahasiswa_data');

        if (!$mahasiswaSession) {
            return redirect()->route('login')->withErrors('Sesi habis.');
        }

        // Ambil mahasiswa lokal
        $mahasiswa = Mahasiswa::find($mahasiswaSession['id']);

        return view('pendaftaran', [
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function biodata(Request $request)
    {
        // validasi apakah mahasiswa udah daftar apa belum, kalo udah gabisa edit lagi
        $mahasiswaId = Session::get('mahasiswa_data')['id'];
        // 2. Cari mahasiswa itu di tabel lokal menggunakan ID-nya
        $mahasiswa = Mahasiswa::find($mahasiswaId);

        if ($mahasiswa->status_kkn === 'Sudah Daftar') {
            return back()->withErrors('Anda tidak bisa lagi mengubah data diri');
        }

        $request->validate([
            'no_hp' => 'nullable|string|max:14',
            'no_hp_darurat' => 'nullable|string|max:14',
            'jenis_kelamin' => 'nullable|in:L,P',
            'ukuran_jacket_rompi' => 'nullable|in:S,M,L,XL,XXL,3XL',
            'punya_kendaraan' => 'nullable|in:Punya,Tidak',
            'tipe_kendaraan' => 'nullable|in:Mobil,Sepeda Motor',
            'punya_lisensi' => 'nullable|in:Tidak Ada,SIM A,SIM B,SIM C,Lainnya',
            'keahlian' => 'nullable|string|max:255',
        ]);

        $mahasiswaSession = Session::get('mahasiswa_data');

        if (!$mahasiswaSession) {
            return redirect()->route('login')->withErrors('Sesi habis.');
        }

        // Update mahasiswa
        $mahasiswa = Mahasiswa::find($mahasiswaSession['id']);
        $mahasiswa->update($request->all());

        return redirect()->route('mahasiswa.biodata.index')
            ->with('success', 'Biodata berhasil diperbarui.');
    }
}
