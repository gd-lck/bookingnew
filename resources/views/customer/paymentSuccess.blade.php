@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="h-screen w-screen flex justify-center items-center">
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow-md">
        <h1 class="text-2xl font-semibold text-green-600 mb-4">Pembayaran Berhasil ✅</h1>

        <div class="border-t pt-4">
            <p class="text-gray-700"><strong>Nama Layanan:</strong> {{ $booking->layanan->nama_layanan }}</p>
            <p class="text-gray-700"><strong>Jumlah Dibayarkan:</strong> Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</p>
            <p class="text-gray-700"><strong>Tanggal Pembayaran:</strong> {{ \Carbon\Carbon::parse($booking->payment->payment_date)->format('d M Y H:i') }}</p>
            <p class="text-gray-700"><strong>Metode Pembayaran:</strong> {{ strtoupper($booking->payment->payment_method) }}</p>
            <p class="text-gray-700"><strong>Status Booking:</strong> <span class="text-green-600 font-bold">{{ ucfirst($booking->status) }}</span></p>
        </div>

        <div class="mt-6">
            <a href="{{ route('customer.userBooking') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Lihat Riwayat Booking</a>
        </div>
    </div>
</div>
@endsection
