<x-app-layout :title="'Digital Receipt'">
    <div class="min-h-screen bg-slate-50 flex items-center justify-center p-4">
        <div
            class="bg-white p-8 rounded-3xl shadow-lg shadow-slate-200/50 flex flex-col items-center max-w-sm w-full border border-slate-100">
            <h2 class="text-xl font-bold text-primary mb-6">Nota Transaksi Digital</h2>
            <img id="receipt-qr-code" src="#" alt="QR Code" class="w-64 h-64 sm:w-64 sm:h-64 object-contain">
            <p class="text-sm text-slate-500 text-center mb-8">Scan QR code ini untuk melihat dan mengunduh nota digital
                transaksi Anda.</p>

            <div class="mt-8 flex gap-8 text-sm font-bold text-slate-400 justify-center">
                <a href="{{ route('kasir.order') }}"
                    class="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary/90 text-white font-bold py-3.5 rounded-xl transition-all">
                    <i class="fa-solid fa-plus"></i> Transaksi Baru
                </a>
                <a href="{{ route('kasir.dashboard') }}"
                    class="w-full flex items-center justify-center gap-2 bg-white hover:bg-white/90 text-slate-600 font-bold py-3.5 rounded-xl transition-all">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke dashboard
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const receiptQueryId = new URLSearchParams(window.location.search).get('id');
            const receiptQr = document.getElementById('receipt-qr-code');

            if (receiptQueryId) {
                const publicUrl = "{{ route('kasir.nota.publik', ['order_code' => '__CODE__']) }}".replace(
                    '__CODE__', receiptQueryId);
                const qrUrl = "{{ route('qr-code') }}?text=" + encodeURIComponent(publicUrl);
                if (receiptQr) receiptQr.src = qrUrl;
            } else {
                try {
                    const receipt = JSON.parse(localStorage.getItem('kasir-last-receipt') || 'null');
                    const orderCode = receipt?.order_code || receipt?.id;

                    if (orderCode) {
                        const publicUrl = "{{ route('kasir.nota.publik', ['order_code' => '__CODE__']) }}".replace(
                            '__CODE__', orderCode);
                        const qrUrl = "{{ route('qr-code') }}?text=" + encodeURIComponent(publicUrl);
                        if (receiptQr) receiptQr.src = qrUrl;
                    } else {
                        window.location.href = "{{ route('kasir.order') }}";
                    }
                } catch (error) {
                    window.location.href = "{{ route('kasir.order') }}";
                }
            }
        });
    </script>
</x-app-layout>
