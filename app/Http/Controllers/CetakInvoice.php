<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class CetakInvoice extends Controller
{
    public function cetakTransaksi($id)
    {
        // Ambil ID mahasiswa dari session
        $mahasiswaId = Session::get('mahasiswa_data')['id'];

        $payment = Payment::with('mahasiswa')
            ->where('id', $id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->where('status', 'success')
            ->firstOrFail();

        $data = [
            'payment' => $payment
        ];

        $pdf = Pdf::loadView('bukti-pembayaran-pdf', $data);

        return $pdf->stream('bukti-pembayaran-' . $payment->order_id . '.pdf');
    }
}
