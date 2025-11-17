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

        // --- PERBAIKAN: BACA REQUEST SEBAGAI JSON ---
        // Ambil payload mentah
        $payload = $request->getContent();
        // Decode JSON menjadi array
        $data = json_decode($payload, true);

        // Cek jika JSON valid
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('❌ Payload JSON tidak valid.', ['payload' => $payload]);
            return response()->json(['message' => 'Invalid JSON payload.'], 400);
        }

        Log::info('Raw Request (sudah di-decode):', $data);

        // Ambil data dari array $data, bukan $request
        $order_id = $data['order_id'] ?? null;
        $transaction_status = $data['transaction_status'] ?? null;
        $fraud_status = $data['fraud_status'] ?? 'accept';
        $status_code = $data['status_code'] ?? null;
        $gross_amount = $data['gross_amount'] ?? null;
        $signature_key = $data['signature_key'] ?? null;
        // --- AKHIR PERBAIKAN ---

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

        // --- Sisa kode Anda (sudah benar) ---
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

        if (in_array($payment->status, ['success', 'failed'])) {
            Log::info('⚠️ Status sudah final, skip update');
            return response()->json(['message' => 'Already processed'], 200);
        }

        if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
            if ($fraud_status == 'accept') {
                $payment->status = 'success';
                if ($payment->mahasiswa) {
                    $payment->mahasiswa->status_kkn = 'Sudah Daftar';
                    $payment->mahasiswa->save();
                    Log::info('✅ Mahasiswa updated:', ['id' => $payment->mahasiswa->id]);
                }
                Log::info('✅ Payment SUCCESS: ' . $order_id);
            }
        }
        // Logika 'expire' Anda akan berjalan sekarang
        elseif (in_array($transaction_status, ['cancel', 'deny', 'expire'])) {
            $payment->status = 'failed';
            Log::info('❌ Payment FAILED/EXPIRED: ' . $order_id);
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
