@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-10">
    <h1 class="text-2xl font-bold text-pink-600 mb-6">Dashboard Booking</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Booking Harian -->
        <div class="bg-white border border-pink-200 text-pink-700 p-6 rounded-xl shadow text-center">
            <h2 class="text-base font-semibold mb-1">Booking Hari Ini</h2>
            <p class="text-3xl font-bold">{{ $bookingHarian }}</p>
        </div>

        <!-- Booking Mingguan -->
        <div class="bg-white border border-pink-200 text-pink-700 p-6 rounded-xl shadow text-center">
            <h2 class="text-base font-semibold mb-1">Booking Minggu Ini</h2>
            <p class="text-3xl font-bold">{{ $bookingMingguan }}</p>
        </div>

        <!-- Booking Bulanan -->
        <div class="bg-white border border-pink-200 text-pink-700 p-6 rounded-xl shadow text-center">
            <h2 class="text-base font-semibold mb-1">Booking Bulan Ini</h2>
            <p class="text-3xl font-bold">{{ $bookingBulanan }}</p>
        </div>
    </div>
</div>
@endsection
