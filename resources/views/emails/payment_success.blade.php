<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Berhasil</title>
</head>
<body style="background-color: #fef2f2; color: #831843; font-family: sans-serif; padding: 20px;">
    <div style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 24px;">
        <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 16px; color: #be185d;">
            Halo {{ $booking->user->name }},
        </h2>
        <p style="margin-bottom: 12px; font-size: 16px;">
            Pembayaran untuk booking layanan <strong>{{ $booking->layanan->nama_layanan }}</strong> 
            pada tanggal <strong>{{ \Carbon\Carbon::parse($booking->booking_time)->translatedFormat('l, d F Y H:i') }}</strong> 
            telah berhasil.
        </p>
        <p style="margin-bottom: 12px; font-size: 16px;">
            Jumlah yang dibayarkan: <strong>Rp{{ number_format($booking->layanan->harga, 0, ',', '.') }}</strong>
        </p>
        <p style="margin-top: 20px; font-size: 16px; font-weight: 600; color: #db2777;">
            Terima kasih telah menggunakan layanan kami!
        </p>
    </div>
</body>
</html>
