<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Booking</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Booking {{ $bulan ? 'Bulan ' . \Carbon\Carbon::parse($bulan)->format('F Y') : '' }}</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Customer</th>
                <th>Layanan</th>
                <th>Tanggal Layanan</th>
                <th>Total (Rp)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->layanan->nama_layanan }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_time)->format('d-m-Y H:i') }}</td>
                    <td>{{ number_format($booking->payment->amount ?? 0, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
