<!-- Sidebar -->
<nav class="w-64 min-h-screen bg-pink-500 text-white flex flex-col p-6 space-y-4">
    <div class="flex flex-col items-center mb-6" x-data="{ open: false }">
        <img src="{{ asset('assets/image/layananBasic1.jpg') }}" class="w-24 h-24 rounded-full object-cover mb-2">

        <div class="relative w-full text-center">
            <button @click="open = !open" class="w-full flex items-center justify-center gap-2 font-semibold hover:text-pink-200 focus:outline-none">
                {{ Auth::user()->name }}
                <svg class="w-4 h-4 transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute left-1/2 -translate-x-1/2 mt-2 w-44 bg-white text-pink-700 rounded shadow z-10">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-pink-100">Edit Profil</a>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Dashboard</a>
    <a href="{{ route('perusahaan.edit') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Profil Perusahaan</a>
    <a href="{{ route('users.index') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Data User</a>
    <a href="{{ route('karyawan.index') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Data Karyawan</a>
    <a href="{{ route('jadwal.index') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Jadwal Karyawan</a>
    <a href="{{ route('layanan.index') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Layanan</a>
    <a href="{{ route('booking.index') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Booking</a>
    <a href="{{ route('booking.laporan') }}" class="hover:bg-pink-600 px-4 py-2 rounded transition">Laporan</a>

    <form method="POST" action="{{ route('logout') }}" class="mt-auto">
        @csrf
        <button type="submit" class="w-full text-left hover:bg-pink-600 px-4 py-2 rounded transition">
            {{ __('Log Out') }}
        </button>
    </form>
</nav>
