<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$clientKey = config('midtrans.client_key');
    }

    public function createTransaction(Booking $booking)
    {
        // Menyusun data transaksi
        $transaction_details = [
            'order_id' => $booking->id,
            'gross_amount' => $booking->layanans->harga,  // Harga layanan
        ];

        $customer_details = [
            'first_name'    => Auth::user()->name,
            'email'         => Auth::user()->email,
        ];

        // Membuat transaksi
        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        try {
            // Mendapatkan token pembayaran dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Simpan transaksi pembayaran ke tabel payments
            $payment = new Payment();
            $payment->booking_id = $booking->id;
            $payment->amount = $booking->layanans->harga;
            $payment->payment_method = 'bank_transfer';
            $payment->payment_status = 'pending';
            $payment->payment_reference = null;  
            $payment->payment_date = null;
            $payment->save();

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function paymentCallback(Request $request)
    {
        // Menangani callback dari Midtrans
        $payment_status = $request->input('transaction_status');
        $payment_reference = $request->input('order_id');

        $payment = Payment::where('booking_id', $payment_reference)->first();

        if ($payment) {
            if ($payment_status == 'capture') {
                $payment->payment_status = 'completed';
            } elseif ($payment_status == 'cancel' || $payment_status == 'failed') {
                $payment->payment_status = 'failed';
            }
            $payment->payment_reference = $request->input('transaction_id');
            $payment->payment_date = now();
            $payment->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Payment status updated successfully',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Payment record not found',
        ]);
    }
}
