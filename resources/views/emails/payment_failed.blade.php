<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Gagal</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-pink-50 text-pink-900 font-sans">
    <div class="max-w-xl mx-auto my-10 bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4 text-pink-700">Halo {{ $booking->user->name }},</h2>
        <p class="mb-4 text-lg">
            Kami mohon maaf, pembayaran untuk booking layanan <strong>{{ $booking->layanan->nama_layanan }}</strong> 
            pada tanggal <strong>{{ \Carbon\Carbon::parse($booking->booking_time)->translatedFormat('l, d F Y H:i') }}</strong> 
            <span class="text-red-600 font-semibold">gagal diproses</span>.
        </p>
        <p class="mb-2 text-lg">Silakan coba kembali melakukan pembayaran melalui halaman riwayat booking Anda.</p>
        <p class="mt-4 text-lg font-semibold text-pink-600">Jika butuh bantuan, hubungi tim kami kapan saja.</p>
    </div>
</body>
</html>
