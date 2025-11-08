<?php

namespace App\Http\Controllers;

use App\Models\Payment; // <-- Model Payment lokal
use App\Models\Mahasiswa; // <-- Model Mahasiswa lokal
use Midtrans\Notification; // <-- Library Midtrans
use Midtrans\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        Log::info('=== WEBHOOK MULAI ===');
        Log::info('Raw Request:', $request->all());

        $order_id = $request->order_id;
        $transaction_status = $request->transaction_status;
        $fraud_status = $request->fraud_status ?? 'accept';
        $status_code = $request->status_code;
        $gross_amount = $request->gross_amount;
        $signature_key = $request->signature_key;

        Log::info('Data Parsed:', [
            'order_id' => $order_id,
            'transaction_status' => $transaction_status,
            'fraud_status' => $fraud_status,
            'status_code' => $status_code
        ]);

        // Validasi signature
        $calculated_signature = hash('sha512', $order_id . $status_code . $gross_amount . Config::$serverKey);

        if ($signature_key != $calculated_signature) {
            Log::warning('❌ Signature tidak valid!', [
                'expected' => $calculated_signature,
                'received' => $signature_key
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        Log::info('✅ Signature valid');

        // Cari payment
        $payment = Payment::where('order_id', $order_id)->first();

        if (!$payment) {
            Log::error('❌ Payment tidak ditemukan: ' . $order_id);
            return response()->json(['message' => 'Order not found'], 404);
        }

        Log::info('✅ Payment ditemukan:', [
            'id' => $payment->id,
            'current_status' => $payment->status,
            'new_status' => $transaction_status
        ]);

        // Cek status final
        if (in_array($payment->status, ['success', 'failed'])) {
            Log::info('⚠️ Status sudah final, skip update');
            return response()->json(['message' => 'Already processed'], 200);
        }

        // Update status berdasarkan transaction_status
        if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
            if ($fraud_status == 'accept') {
                $payment->status = 'success';

                // Update mahasiswa
                $mahasiswa = $payment->mahasiswa;
                if ($mahasiswa) {
                    $mahasiswa->status_kkn = 'Sudah Daftar';
                    $mahasiswa->save();
                    Log::info('✅ Mahasiswa updated:', [
                        'id' => $mahasiswa->id,
                        'status_kkn' => $mahasiswa->status_kkn
                    ]);
                }

                Log::info('✅ Payment SUCCESS: ' . $order_id);
            }
        } elseif (in_array($transaction_status, ['cancel', 'deny', 'expire'])) {
            $payment->status = 'failed';
            Log::info('❌ Payment FAILED: ' . $order_id);
        } elseif ($transaction_status == 'pending') {
            $payment->status = 'pending';
            Log::info('⏳ Payment PENDING: ' . $order_id);
        }

        $payment->save();

        Log::info('=== WEBHOOK SELESAI ===', [
            'order_id' => $order_id,
            'final_status' => $payment->status
        ]);

        return response()->json(['message' => 'OK'], 200);
    }
}
