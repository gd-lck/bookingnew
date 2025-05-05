@extends('layouts.app')

@section('title', 'Laporan Booking')

@section('content')
<div class="py-10">
    <h2 class="text-2xl font-bold text-pink-600 mb-6">Laporan Booking</h2>

    <!-- Filter Bulan dan Download PDF -->
    <form method="GET" action="{{ route('booking.laporan') }}" class="flex flex-col md:flex-row md:items-end gap-4 mb-6">
        <div>
            <label for="bulan" class="block mb-1 text-sm text-gray-700">Filter Bulan</label>
            <input type="month" name="bulan" id="bulan" value="{{ request('bulan') }}"
                class="border px-3 py-2 rounded w-full md:w-64">
        </div>
        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Tampilkan
            </button>
        </div>
        <div>
            <a href="{{ route('booking.export.pdf', ['bulan' => request('bulan')]) }}"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded inline-block">
                Download PDF
            </a>
        </div>
    </form>

    <!-- Tabel Booking -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm text-gray-700 border border-gray-200 rounded shadow">
            <thead class="bg-pink-100 text-pink-700">
                <tr>
                    <th class="py-2 px-4 text-left">Nama Customer</th>
                    <th class="py-2 px-4 text-left">Layanan</th>
                    <th class="py-2 px-4 text-left">Tanggal Layanan</th>
                    <th class="py-2 px-4 text-left">Total (Rp)</th>
                    <th class="py-2 px-4 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ $booking->user->name }}</td>
                    <td class="py-2 px-4">{{ $booking->layanan->nama_layanan }}</td>
                    <td class="py-2 px-4">{{ \Carbon\Carbon::parse($booking->booking_time)->format('d-m-Y H:i') }}</td>
                    <td class="py-2 px-4">{{ number_format($booking->payment->amount ?? 0, 0, ',', '.') }}</td>
                    <td class="py-2 px-4">
                        <span class="px-2 py-1 rounded text-white text-xs
                            @if($booking->status == 'booked') bg-green-500
                            @elseif($booking->status == 'pending') bg-yellow-500
                            @elseif($booking->status == 'completed') bg-blue-500
                            @else bg-red-500 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 text-center text-gray-500">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
