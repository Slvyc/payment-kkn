<?php

namespace App\Http\Controllers;

use App\Models\Payment; // <-- Model Payment lokal
use App\Models\PendaftaranKkn;
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

        Log::info('=== MIDTRANS WEBHOOK MASUK ===');

        // Payload mentah
        $payload = $request->getContent();
        $data = json_decode($payload, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON Payload Invalid', ['payload' => $payload]);
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Ambil data
        $order_id = $data['order_id'] ?? null;
        $status_code = $data['status_code'] ?? null;
        $gross_amount = $data['gross_amount'] ?? null;
        $transaction_status = $data['transaction_status'] ?? null;
        $fraud_status = $data['fraud_status'] ?? 'accept';
        $signature_key = $data['signature_key'] ?? null;

        Log::info("Webhook data parsed", $data);

        // Validasi signature
        $expectedSignature = hash('sha512', $order_id . $status_code . $gross_amount . Config::$serverKey);

        if ($signature_key !== $expectedSignature) {
            Log::warning("❌ Signature tidak valid!", [
                'expected' => $expectedSignature,
                'received' => $signature_key
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        Log::info("✅ Signature valid");

        // Cari payment berdasarkan order ID
        $payment = Payment::where('order_id', $order_id)->first();

        if (!$payment) {
            Log::error("Order tidak ditemukan", ['order_id' => $order_id]);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // Cari pendaftaran
        $pendaftaran = PendaftaranKkn::where('payment_id', $payment->id)->first();

        Log::info("Payment ditemukan", [
            'payment_id' => $payment->id,
            'status' => $payment->status
        ]);

        // Jika sudah final, jangan update lagi
        if (in_array($payment->status, ['success', 'failed'])) {
            Log::info("Status final — tidak diupdate");
            return response()->json(['message' => 'Already processed'], 200);
        }

        // ==============================
        // LOGIKA STATUS MIDTRANS
        // ==============================

        if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
            if ($fraud_status == 'accept') {

                // UPDATE PAYMENT
                $payment->status = 'success';
                $payment->save();

                // UPDATE PENDAFTARAN
                if ($pendaftaran) {
                    $pendaftaran->status_pendaftaran = 'valid';
                    $pendaftaran->save();
                }

                // UPDATE MAHASISWA
                if ($payment->mahasiswa) {
                    $payment->mahasiswa->status_kkn = 'Sudah Daftar';
                    $payment->mahasiswa->save();
                }

                Log::info("✅ PEMBAYARAN BERHASIL", ['order_id' => $order_id]);
            }
        } elseif (in_array($transaction_status, ['cancel', 'deny', 'expire'])) {

            // PAYMENT GAGAL
            $payment->status = 'failed';
            $payment->save();

            // PENDAFTARAN GAGAL
            if ($pendaftaran) {
                $pendaftaran->status_pendaftaran = 'failed';
                $pendaftaran->save();
            }

            Log::info("❌ PEMBAYARAN GAGAL/EXPIRE", ['order_id' => $order_id]);
        } elseif ($transaction_status == 'pending') {

            // PAYMENT MENUNGGU
            $payment->status = 'pending';
            $payment->save();

            if ($pendaftaran) {
                $pendaftaran->status_pendaftaran = 'pending';
                $pendaftaran->save();
            }

            Log::info("⏳ PEMBAYARAN PENDING", ['order_id' => $order_id]);
        }

        Log::info("=== WEBHOOK SELESAI ===", [
            'payment_status' => $payment->status,
            'pendaftaran_status' => $pendaftaran->status_pendaftaran ?? null
        ]);

        return response()->json(['message' => 'OK'], 200);
    }
}
