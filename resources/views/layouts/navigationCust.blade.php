<nav class="fixed w-screen top-0 left-0 right-0 flex flex-row h-15 px-8 pt-5 justify-between">
    {{-- Logo --}}
    <img src="{{ asset('storage/' . $perusahaan->logo) }}" class="size-20 flex-none">
    {{-- Menu Tengah --}}
    <div class="flex gap-5 justify-center">
        <a href="{{ url('/') }}#section1" class="bg-transparent hover:bg-transparent text-pink-500 hover:text-pink-600">Beranda</a>
        <a href="#section2" class="bg-transparent hover:bg-transparent text-pink-500 hover:text-pink-600">Tentang Kami</a>

        @auth
            <a href="{{ route('customer.layanan.display') }}" class="bg-transparent hover:bg-transparent text-pink-500 hover:text-pink-600">Layanan</a>
            <a href="{{ route('customer.userBooking') }}" class="bg-transparent hover:bg-transparent text-pink-500 hover:text-pink-600">Booking</a>
        @else
            <a href="{{ route('login') }}" class="bg-transparent hover:bg-transparent text-pink-500 hover:text-pink-600">Layanan</a>
            <a href="{{ route('login') }}" class="bg-transparent hover:bg-transparent text-pink-500 hover:text-pink-600">Booking</a>
        @endauth
    </div>

    {{-- Login / Dropdown --}}
    @auth
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-2 bg-pink-100 hover:bg-pink-200 text-pink-700 py-2 px-4 rounded-full">
                <span>{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- Dropdown --}}
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-48 bg-white border rounded shadow z-50">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-gray-700">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    @else
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-2 bg-pink-100 hover:bg-pink-200 text-pink-700 py-2 px-4 rounded-full">
                <span>Sign In</span>
                <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- Dropdown Login/Register --}}
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-2 w-48 bg-white border rounded shadow z-50">
                <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Login</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Register</a>
            </div>
        </div>
    @endauth
</nav>
