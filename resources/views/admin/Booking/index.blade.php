@extends('layouts.app')

@section('title', 'Booking')

@section('content')
<div class="pt-6 pr-6 pb-10 overflow-x-auto min-h-screen bg-gray-50">
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
                        <div x-data="{ openModal: false, deleteModal: false, statusModal: false }">
                            <div class="flex flex-wrap gap-2">
                                <button @click="openModal = true" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Detail</button>
                                <button @click="statusModal = true" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Ubah Status</button>
                                <button @click="deleteModal = true" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                            </div>

                            <!-- Delete Modal -->
                            <div x-show="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                <div @click.outside="deleteModal = false" class="bg-white p-6 rounded shadow-md w-96">
                                    <h2 class="text-lg font-bold mb-4 text-red-600">Konfirmasi Hapus</h2>
                                    <p>Yakin ingin menghapus booking <strong>{{ 'Book-' . $booking->id }}</strong>?</p>
                                    <div class="flex justify-end gap-2 mt-4">
                                        <form action="{{ route('booking.destroy', $booking->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                                        </form>
                                        <button @click="deleteModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Modal -->
                            <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                <div @click.outside="openModal = false" class="bg-white p-6 rounded shadow-md w-[600px] max-h-[90vh] overflow-y-auto">
                                    <h2 class="text-lg font-bold mb-4 text-pink-600">Detail Booking</h2>
                                    <div class="mb-4">
                                        <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                                        <p><strong>Layanan:</strong> {{ $booking->layanan->nama_layanan }}</p>
                                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($booking->booking_time)->translatedFormat('d F Y') }}</p>
                                        <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                                    </div>

                                    <!-- Pembayaran -->
                                    <div class="mb-4">
                                        <h3 class="text-md font-semibold text-green-600 mb-2">Pembayaran</h3>
                                        @if ($booking->payment)
                                            <p><strong>Status:</strong> {{ ucfirst($booking->payment->payment_status) }}</p>
                                            <p><strong>Metode:</strong> {{ strtoupper($booking->payment->payment_method) }}</p>
                                            <p><strong>Jumlah:</strong> Rp{{ number_format($booking->payment->amount, 0, ',', '.') }}</p>
                                            <p><strong>Tanggal Bayar:</strong> 
                                                {{ $booking->payment->payment_date ? \Carbon\Carbon::parse($booking->payment->payment_date)->translatedFormat('d F Y H:i') : '-' }}
                                            </p>
                                        @else
                                            <p class="text-gray-500 italic">Belum ada data pembayaran.</p>
                                        @endif
                                    </div>

                                    <!-- Reschedule -->
                                    <div class="mb-4">
                                        <h3 class="text-md font-semibold text-blue-600 mb-2">Riwayat Reschedule</h3>
                                        @if ($booking->reschedules->count())
                                            <table class="w-full text-sm border border-gray-200">
                                                <thead class="bg-blue-100 text-blue-700">
                                                    <tr>
                                                        <th class="px-2 py-1 border">Jadwal Awal</th>
                                                        <th class="px-2 py-1 border">Jadwal Baru</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($booking->reschedules as $reschedule)
                                                        <tr>
                                                            <td class="px-2 py-1 border">{{ \Carbon\Carbon::parse($reschedule->jadwal_awal)->translatedFormat('d M Y H:i') }}</td>
                                                            <td class="px-2 py-1 border">{{ \Carbon\Carbon::parse($reschedule->jadwal_baru)->translatedFormat('d M Y H:i') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="text-gray-500 italic">Belum pernah di-reschedule.</p>
                                        @endif
                                    </div>

                                    <div class="text-right">
                                        <button @click="openModal = false" class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600">Tutup</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Modal -->
                            <div x-show="statusModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                <div @click.outside="statusModal = false" class="bg-white p-6 rounded shadow-md w-96">
                                    <h2 class="text-lg font-bold mb-4 text-blue-600">Ubah Status Booking</h2>
                                    <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label for="status" class="block text-sm font-medium mb-1">Status:</label>
                                            <select name="status" id="status" class="w-full border rounded px-3 py-2">
                                                <option value="booked" {{ $booking->status == 'booked' ? 'selected' : '' }}>Booked</option>
                                                <option value="canceled" {{ $booking->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
                                            <button type="button" @click="statusModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                        </div>
                                    </form>
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
