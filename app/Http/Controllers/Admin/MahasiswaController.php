<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function index()
    {

        $mahasiswas = Mahasiswa::all();

        return view('admin.mahasiswa', compact('mahasiswas'));
    }
}
