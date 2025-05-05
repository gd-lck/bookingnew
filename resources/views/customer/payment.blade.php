@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="h-screen w-screen flex flex-col justify-center items-center gap-10">
    <h2 class="text-pink-500 font-bold text-2xl">Silakan Lanjutkan Pembayaran</h2>
    <button id="pay-button" class="bg-pink-500 p-4 font-bold text-white rounded-lg hover:bg-pink-400 active:bg-pink-500">
        Bayar Sekarang
    </button>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Ql1OVDTBFRiPDQhG"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bookingId = "{{ $booking->id }}";
        console.log(bookingId)
        
        document.getElementById('pay-button').addEventListener('click', function () {
            snap.pay("{{ $snapToken }}", {
                onSuccess: function(result) {
                    // Redirect ke route payment.success dengan parameter booking ID
                    window.location.href = `/payment-success/${bookingId}`;
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran...");
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                    console.error(result);
                },
                onClose: function() {
                    alert("Kamu menutup popup tanpa menyelesaikan pembayaran");
                }
            });
        });
    });
</script>
@endpush
