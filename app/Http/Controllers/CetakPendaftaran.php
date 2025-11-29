<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Payment;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class CetakPendaftaran extends Controller
{
    public function cetakPendaftaran($id)
    {
        // Ambil ID mahasiswa dari session
        $mahasiswaId = Session::get('mahasiswa_data')['id'];

        $payment = Payment::with('mahasiswa')
            ->where('id', $id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'success')
            ->firstOrFail();

        $mahasiswa = Mahasiswa::where('id', $mahasiswaId)->first();

        $data = [
            'payment' => $payment,
            'mahasiswa' => $mahasiswa
        ];

        $pdf = Pdf::loadView('formulir-pendaftaran-pdf', $data);

        return $pdf->stream('formulir-pendaftaran-' . $mahasiswa->nama . '.pdf');
    }
}
