@extends('layouts.app')

@section('title', 'Booking')

@section('content')
<div class="pt-6 pl-72 pr-6 pb-10 overflow-x-auto min-h-screen bg-gray-50">
    <h1 class="text-2xl font-bold mb-6 text-pink-600">Daftar Booking</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full text-sm text-gray-700">
            <thead>
                <tr class="bg-pink-100 text-pink-700 text-left">
                    <th class="py-3 px-4">#</th>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Layanan</th>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4">Waktu</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-2 px-4">{{ ($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration }}</td>
                    <td class="py-2 px-4">{{ 'Book-' . $booking->id }}</td>
                    <td class="py-2 px-4">{{ $booking->user->email ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $booking->layanan->nama_layanan ?? '-' }}</td>
                    <td class="py-2 px-4">{{ \Carbon\Carbon::parse($booking->booking_time)->translatedFormat('d F Y') }}</td>
                    <td class="py-2 px-4">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</td>
                    <td class="py-2 px-4">{{ ucfirst($booking->status) }}</td>
                    <td class="py-2 px-4">
                        <div class="flex gap-2">
                            <button @click="openModal_{{ $booking->id }} = true" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Detail</button>
                            <button @click="deleteModal_{{ $booking->id }} = true" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                        </div>

                        <!-- Detail Modal -->
                        <div x-data="{ openModal_{{ $booking->id }}: false }">
                            <div x-show="openModal_{{ $booking->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                <div class="bg-white p-6 rounded shadow-md w-96">
                                    <h2 class="text-lg font-bold mb-4 text-pink-600">Detail Booking</h2>
                                    <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                                    <p><strong>Layanan:</strong> {{ $booking->layanan->nama_layanan }}</p>
                                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($booking->booking_time)->translatedFormat('d F Y') }}</p>
                                    <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</p>
                                    <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                                    <div class="text-right mt-4">
                                        <button @click="openModal_{{ $booking->id }} = false" class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div x-data="{ deleteModal_{{ $booking->id }}: false }">
                            <div x-show="deleteModal_{{ $booking->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                <div class="bg-white p-6 rounded shadow-md w-96">
                                    <h2 class="text-lg font-bold mb-4 text-red-600">Konfirmasi Hapus</h2>
                                    <p>Yakin ingin menghapus booking <strong>{{ 'Book-' . $booking->id }}</strong>?</p>
                                    <div class="flex justify-end gap-2 mt-4">
                                        <form action="#" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                                        </form>
                                        <button @click="deleteModal_{{ $booking->id }} = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
