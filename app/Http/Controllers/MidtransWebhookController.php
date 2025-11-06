<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Validasi notifikasi dari Midtrans
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        // 2. Cari payment di DB kita
        $payment = Payment::where('order_id', $order_id)->first();
        if (!$payment) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        // 3. Update status jika sukses
        if ($transaction == 'capture' || $transaction == 'settlement') {
            if ($fraud == 'accept') {
                // Update DB KKN Payment
                $payment->status = 'success';
                $payment->mahasiswa->status_kkn = 'sudah_daftar';
                $payment->mahasiswa->save();
                $payment->save();
            }
        }
        // Handle status lain (expire, deny, etc.)
        else if (in_array($transaction, ['expire', 'cancel', 'deny'])) {
            $payment->status = 'failed';
            $payment->save();
        }

        return response()->json(['message' => 'Notification processed.'], 200);
    }
}
