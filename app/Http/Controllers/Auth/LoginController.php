<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Mahasiswa;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'nim' => 'required',
            'password' => 'required',
        ]);

        $siakadApiUrl = 'https://mini-siakad.cloud/api/auth/login';

        // consume login API or check credentials here
        $response = Http::post($siakadApiUrl, [
            'nim' => $request->nim,
            'password' => $request->password,
        ]);

        // cek jika gagal
        if ($response->failed()) {
            return back()->withErrors([
                'nim' => 'NIM atau Password salah (data dari Siakad).',
            ]);
        }

        // 4. Jika Sukses (Respon 200 OK)
        $data = $response->json(); // Ambil data JSON (user & token)
        $userDataFromApi = $data['user']; // Data dari Siakad

        Mahasiswa::updateOrCreate(
            ['id' => $userDataFromApi['id']], // Kunci pencarian
            [
                'nim' => $userDataFromApi['nim'], // Data untuk di-update/create
                'nama' => $userDataFromApi['name'],
                'email' => $userDataFromApi['email'],
            ]
        );

        // Simpan data di Session (Simple)
        Session::put('mahasiswa_data', $userDataFromApi);
        Session::put('siakad_token', $data['token']);
        Session::regenerate();

        return redirect()->route('mahasiswa.dashboard');
    }

    public function logout()
    {
        // Hapus data user dari session
        session()->flush();
        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}
