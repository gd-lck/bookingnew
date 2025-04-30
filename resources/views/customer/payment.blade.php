<h2>Silakan Lanjutkan Pembayaran</h2>
<button id="pay-button">Bayar Sekarang</button>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
      snap.pay("{{ $snapToken }}", {
          onSuccess: function(result){
              alert("Pembayaran sukses!");
              window.location.href = "/booking/create"
          },
          onPending: function(result){
              alert("Menunggu pembayaran...");
          },
          onError: function(result){
              alert("Pembayaran gagal!");
          },
          onClose: function(){
              alert('Kamu menutup popup tanpa menyelesaikan pembayaran');
          }
      });
    });
</script>
