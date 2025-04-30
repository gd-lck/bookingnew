@extends('layouts.app')

@section('title', 'Form Booking')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8 pt-20">
    <h2 class="text-2xl font-bold mb-6">Form Booking</h2>

    <form id="bookingForm" action="{{ route('booking.store') }}" method="POST">
        @csrf

        {{-- Pilih Layanan --}}
        <div class="mb-4">
            <label for="layanan_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Layanan</label>
            <select name="layanan_id" id="layanan_id" class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="">-- Pilih Layanan --</option>
                @foreach ($layanans as $layanan)
                    <option value="{{ $layanan->id }}" @if(isset($layananTerpilih) && $layananTerpilih->id == $layanan->id) selected @endif>
                        {!! $layanan->nama_layanan !!} (
                        <span class="font-semibold">Rp. {{ number_format($layanan->harga,0,',','.') }}</span> 
                        {{ number_format($layanan->durasi,0,',','.') }} menit)
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal Booking --}}
        <div class="mb-4">
            <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Booking</label>
            <input type="date" name="booking_date" id="booking_date" min="{{ date('Y-m-d') }}" required
                   class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
        </div>

        {{-- Jam Booking --}}
        <div class="mb-4">
            <label for="booking_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Booking</label>
            <input type="time" name="booking_time" id="booking_time" min="08:00" max="22:00" required
                   class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            <p id="timeError" class="text-red-500 text-sm mt-1 hidden">
                Jam booking hanya diperbolehkan antara 08:00 sampai 22:00.
            </p>
        </div>

        {{-- Karyawan Tersedia --}}
        <div class="mb-4">
            <label for="karyawan_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Karyawan</label>
            <select name="karyawan_id" id="karyawan_id" class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="">-- Pilih karyawan yang tersedia --</option>
            </select>
            <p id="hasil-karyawan" class="text-gray-500 text-sm mt-1">
                Pilih tanggal & jam untuk melihat karyawan yang tersedia.
            </p>
        </div>

        {{-- Submit --}}
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition">
            Booking Sekarang
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        const bookingDate = $('#booking_date');
        const bookingTime = $('#booking_time');
        const layananId = $('#layanan_id');
        const karyawanSelect = $('#karyawan_id');
        const hasilKaryawan = $('#hasil-karyawan');
        const timeError = $('#timeError');

        // Validasi jam booking
        $('#bookingForm').on('submit', function (e) {
            const timeValue = bookingTime.val();
            const [hour] = timeValue.split(':');
            const h = parseInt(hour);

            if (h < 8 || h >= 22) {
                e.preventDefault();
                timeError.removeClass('hidden');
                bookingTime.focus();
            } else {
                timeError.addClass('hidden');
            }
        });

        // Cek karyawan saat tanggal, jam, atau layanan berubah
        bookingDate.on('change', fetchKaryawan);
        bookingTime.on('change', fetchKaryawan);
        layananId.on('change', fetchKaryawan);

        function fetchKaryawan() {
            let tanggal = bookingDate.val();
            let jam = bookingTime.val();
            let layanan = layananId.val();

            if (tanggal && jam && layanan) {
                $.ajax({
                    url: '{{ route("cek.karyawan") }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        tanggal: tanggal,
                        jam: jam,
                        layanan_id: layanan
                    },
                    success: function (res) {
                        karyawanSelect.empty();
                        if (res.length > 0) {
                            karyawanSelect.append('<option value="">-- Pilih karyawan yang tersedia --</option>');
                            res.forEach(karyawan => {
                                karyawanSelect.append(`<option value="${karyawan.id}">${karyawan.nama}</option>`);
                            });
                            hasilKaryawan.text('Silakan pilih salah satu karyawan dari daftar.');
                        } else {
                            karyawanSelect.append('<option value="">-- Tidak ada karyawan yang tersedia --</option>');
                            hasilKaryawan.text('Tidak ada karyawan yang tersedia di waktu tersebut.');
                        }
                    },
                    error: function () {
                        karyawanSelect.empty();
                        karyawanSelect.append('<option value="">-- Gagal memuat karyawan --</option>');
                        hasilKaryawan.text('Terjadi kesalahan saat memuat data.');
                    }
                });
            }
        }
    });
</script>
@endsection
