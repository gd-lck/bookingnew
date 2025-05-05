<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Tambahkan link ke CSS atau JavaScript di sini jika diperlukan -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/landing_page.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }} ">     
</head>
<body class="p-0 m-0">
    @guest
        @include('layouts.navigationCust')
        <main class="content">
            @yield('content')
        </main>
        @include('layouts.footer')
    @else
        @role('admin')
            <div class="flex min-h-screen">
                @include('layouts.navigationAdmin') {{-- Sidebar --}}
                <main class="flex-1 p-4"> {{-- Konten admin --}}
                    @yield('content')
                </main>
            </div>
        @else
            @include('layouts.navigationCust')
            <main class="content">
                @yield('content')
            </main>
        @endrole
    @endguest

    @role('customer')
        @include('layouts.footer')
    @endrole
    @yield('scripts')
    @stack('scripts')
</body>

</html>