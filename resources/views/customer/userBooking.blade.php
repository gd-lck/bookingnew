@extends('layouts.app')

@section('title', 'Booking Saya')

@section('content')
<div class="container mx-auto py-10 pt-20">
    <h1 class="text-2xl font-semibold mb-6">Daftar Booking Saya</h1>

    @if ($bookings->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded">
            Anda belum melakukan booking apa pun.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm">
                        <th class="py-3 px-4">Layanan</th>
                        <th class="py-3 px-4">Karyawan</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Jam</th>
                        <th class="py-3 px-4">Durasi</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $booking->layanan->nama_layanan }}</td>
                            <td class="py-3 px-4">{{ $booking->karyawan->nama }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($booking->booking_time)->format('d-m-Y') }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</td>
                            <td class="py-3 px-4">{{ $booking->layanan->durasi }} menit</td>
                            <td class="py-3 px-4">
                                @php
                                    $statusColor = match($booking->status) {
                                        'pending' => 'bg-yellow-200 text-yellow-800',
                                        'confirmed' => 'bg-green-200 text-green-800',
                                        'cancelled' => 'bg-red-200 text-red-800',
                                        default => 'bg-gray-200 text-gray-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $statusColor }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 space-y-1">
                                @if ($booking->status == 'pending' && (!$booking->payment || $booking->payment->payment_status == 'unpaid'))
                                <a href="{{ route('customer.payBooking', $booking->id) }}"
                                   class="text-blue-500 hover:underline block">
                                    Bayar Sekarang
                                </a>
                                @elseif ($booking->payment->payment_status == 'paid')
                                    <span class="text-green-600 font-semibold block">Sudah Dibayar</span>
                                @endif

                                <!-- Tombol Reschedule -->
                                <button onclick="openModal({{ $booking->id }})" class="text-indigo-600 hover:underline">
                                    Reschedule
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
            <div class="">
                {{ $bookings->links() }}
            </div>
        </div>
        

        @foreach ($bookings as $booking )
        <div id="rescheduleModal-{{ $booking->id }}" class="fixed hidden inset-0 z-50 items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded w-full max-w-md">
                <h2 class="text-lg font-bold mb-4">Reschedule Booking</h2>
                <form id="rescheduleForm-{{ $booking->id }}" action="{{ route('booking.reschedule', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="layanan_id" id="layanan_id_{{ $booking->id }}" value="{{ $booking->layanan_id }}">
                    <div class="mb-4">
                        <label for="booking_date" class="block font-medium">Tanggal</label>
                        <input type="date" name="booking_date" id="booking_date_{{ $booking->id }}" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="booking_time" class="block font-medium">Jam</label>
                        <input type="time" name="booking_time" id="booking_time_{{ $booking->id }}" class="w-full border rounded px-3 py-2" required>
                        <p id="timeError_{{ $booking->id }}" class="text-red-500 text-sm hidden">Jam booking harus antara 08:00 - 21:59</p>
                    </div>
                    <div class="mb-4">
                        <label for="karyawan_id" class="block font-medium">Karyawan</label>
                        <select name="karyawan_id" id="karyawan_id_{{ $booking->id }}" class="w-full border rounded px-3 py-2" required>
                            <option value="">-- Pilih Karyawan --</option>
                        </select>
                        <p id="hasil-karyawan_{{ $booking->id }}" class="text-sm mt-1 text-gray-600"></p>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal({{ $booking->id }})" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection

@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById('rescheduleModal-' + id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(id) {
        const modal = document.getElementById('rescheduleModal-' + id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($bookings as $booking)
            const form{{ $booking->id }} = document.getElementById('rescheduleForm-{{ $booking->id }}');
            const date{{ $booking->id }} = document.getElementById('booking_date_{{ $booking->id }}');
            const time{{ $booking->id }} = document.getElementById('booking_time_{{ $booking->id }}');
            const layanan{{ $booking->id }} = document.getElementById('layanan_id_{{ $booking->id }}');
            const karyawanSelect{{ $booking->id }} = document.getElementById('karyawan_id_{{ $booking->id }}');
            const hasilKaryawan{{ $booking->id }} = document.getElementById('hasil-karyawan_{{ $booking->id }}');
            const timeError{{ $booking->id }} = document.getElementById('timeError_{{ $booking->id }}');

            form{{ $booking->id }}.addEventListener('submit', function (e) {
                const [hour] = time{{ $booking->id }}.value.split(':');
                const h = parseInt(hour);
                if (h < 8 || h >= 22) {
                    e.preventDefault();
                    timeError{{ $booking->id }}.classList.remove('hidden');
                    time{{ $booking->id }}.focus();
                } else {
                    timeError{{ $booking->id }}.classList.add('hidden');
                }
            });

            [date{{ $booking->id }}, time{{ $booking->id }}].forEach(field => {
                field.addEventListener('change', () => {
                    const tanggal = date{{ $booking->id }}.value;
                    const jam = time{{ $booking->id }}.value;
                    const layanan = layanan{{ $booking->id }}.value;

                    if (tanggal && jam && layanan) {
                        $.ajax({
                            url: '{{ route("cek.karyawan") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                tanggal: tanggal,
                                jam: jam,
                                layanan_id: layanan
                            },
                            success: function (res) {
                                karyawanSelect{{ $booking->id }}.innerHTML = '';
                                if (res.length > 0) {
                                    karyawanSelect{{ $booking->id }}.innerHTML += '<option value="">-- Pilih Karyawan --</option>';
                                    res.forEach(karyawan => {
                                        karyawanSelect{{ $booking->id }}.innerHTML += `<option value="${karyawan.id}">${karyawan.nama}</option>`;
                                    });
                                    hasilKaryawan{{ $booking->id }}.textContent = 'Silakan pilih salah satu karyawan.';
                                } else {
                                    karyawanSelect{{ $booking->id }}.innerHTML = '<option value="">-- Tidak ada karyawan tersedia --</option>';
                                    hasilKaryawan{{ $booking->id }}.textContent = 'Tidak ada karyawan tersedia di waktu ini.';
                                }
                            },
                            error: function () {
                                karyawanSelect{{ $booking->id }}.innerHTML = '<option value="">-- Gagal memuat --</option>';
                                hasilKaryawan{{ $booking->id }}.textContent = 'Terjadi kesalahan saat memuat.';
                            }
                        });
                    }
                });
            });
        @endforeach
    });
</script>
@endpush

