<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        // Log semua request dari Midtrans
        Log::info('Midtrans callback received', [
            'request_data' => $request->all()
        ]);

        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;
        $transactionId = $notification->transaction_id;
        $paymentTime = $notification->transaction_time;
        $vaNumbers = $notification->va_numbers ?? [];

        $bookingId = str_replace('BOOK-', '', $orderId);
        $booking = Booking::find($bookingId);

        if (!$booking) {
            Log::warning("Booking not found for order ID: $orderId");
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $payment = Payment::firstOrNew(['booking_id' => $booking->id]);
        $payment->payment_method = $paymentType;
        if (isset($notification->va_numbers)) {
            $vaNumber = $notification->va_numbers[0]->va_number ?? $transactionId;
        } else {
            $vaNumber = $transactionId;
        }
        $payment->payment_reference = $vaNumber;        
        $payment->payment_date = $paymentTime;

        // Log status transaksi
        Log::info("Processing transaction: $transactionStatus", [
            'booking_id' => $booking->id,
            'payment_type' => $paymentType,
            'transaction_id' => $transactionId,
        ]);

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            $payment->payment_status = 'paid';
            $booking->status = 'booked';
        } elseif ($transactionStatus === 'pending') {
            $payment->payment_status = 'pending';
        } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
            $payment->payment_status = 'failed';
            $booking->status = 'canceled';
        }

        $payment->save();
        $booking->save();

        Log::info("Callback processed successfully for booking #{$booking->id}");

        return response()->json(['message' => 'Callback processed']);
    }
}
