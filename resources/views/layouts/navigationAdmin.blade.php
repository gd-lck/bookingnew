<!-- Sidebar -->
<nav class="w-64 min-h-screen bg-pink-500 text-white flex flex-col p-6 space-y-4">
    <div class="flex flex-col items-center mb-8">
        <img src="{{ asset('assets/image/layananBasic1.jpg') }}" class="w-24 h-24 rounded-full object-cover mb-2">
        <h4 class="text-lg font-semibold">Admin</h4>
    </div>

    <a href="#" class="hover:bg-pink-600 px-4 py-2 rounded transition">Dashboard</a>
    <a href="#" class="hover:bg-pink-600 px-4 py-2 rounded transition">Profil Perusahaan</a>
    <a href="#" class="hover:bg-pink-600 px-4 py-2 rounded transition">Data User</a>
    <a href="{{ route('karyawan.index') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Data Karyawan</a>
    <a href="{{ route('jadwal.index') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Jadwal Karyawan</a>
    <a href="{{ route('layanan.index') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Layanan</a>
    <a href="{{ route('booking.index') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Booking</a>
    <a href="#" class="hover:bg-pink-600 px-4 py-2 rounded transition">Laporan</a>

    <form method="POST" action="{{ route('logout') }}" class="mt-auto">
        @csrf
        <button type="submit" class="w-full text-left hover:bg-pink-600 px-4 py-2 rounded transition">
            {{ __('Log Out') }}
        </button>
    </form>
</nav>
