<x-app-layout :title="'Payment Success'">
    <div class="min-h-screen bg-slate-50 font-sans flex flex-col items-center justify-center p-4">
        
        <div class="bg-white w-full max-w-[400px] rounded-3xl shadow-xl shadow-slate-200/50 p-8 text-center relative border border-slate-100">

            <div class="flex items-center gap-2 text-slate-400 font-bold text-sm justify-center">
                <img src="{{ asset('img/logo-perpus.webp') }}" alt="" class="h-15">
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold text-primary mb-2">Pembayaran Berhasil!</h1>
            <p class="text-[13px] text-slate-500 leading-relaxed mb-6">
                Transaksi telah diproses dengan sukses. Detail pesanan telah dicatat dalam sistem Library Cafe POS.
            </p>

            <!-- Total Block -->
            <div class="bg-slate-50 rounded-2xl p-5 mb-3 border border-slate-100 flex items-center justify-between text-left">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 tracking-wider mb-1">TOTAL BAYAR</p>
                    <p class="text-2xl font-bold text-primary tracking-tight" data-receipt-total>Rp 0</p>
                </div>
                <div class="bg-white border border-slate-200 px-3 py-1.5 rounded-lg shadow-sm">
                    <span class="text-[11px] font-bold text-tertiary tracking-wider">LUNAS</span>
                </div>
            </div>

            <!-- Meta Block -->
            <div class="bg-slate-50 rounded-2xl p-5 mb-6 border border-slate-100 grid grid-cols-2 gap-4 text-left">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 tracking-wider mb-1">METODE</p>
                    <div class="flex items-center gap-2">
                        <span class="text-[13px] font-bold text-primary" data-receipt-method>QRIS</span>
                    </div>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 tracking-wider mb-1">ID TRANSAKSI</p>
                    <p class="text-[13px] font-bold text-primary" data-receipt-number>#LC-000000</p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="space-y-3">
                <a href="{{ route('kasir.order') }}" class="block w-full bg-primary hover:bg-primary/90 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-primary/20 transition-all text-sm">
                    <i class="fa-solid fa-cart-shopping mr-2"></i> Transaksi Baru
                </a>
                
                <div class="flex gap-3">
                    <a href="{{ route('kasir.histori') }}" class="flex-1 bg-white hover:bg-slate-50 text-slate-600 font-bold py-3 rounded-xl border border-slate-200 transition-all text-[13px] shadow-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left"></i> Lihat Riwayat
                    </a>
                    {{-- Ganti URL ke route receipt yang sudah kita buat sebelumnya --}}
                    <a href="{{ route('kasir.receipt') }}" class="flex-1 bg-white hover:bg-slate-50 text-slate-600 font-bold py-3 rounded-xl border border-slate-200 transition-all text-[13px] shadow-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-print"></i> Cetak Struk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const receipt = JSON.parse(localStorage.getItem('kasir-last-receipt') || 'null');
            
            if (!receipt || !receipt.items) {
                // Opsional: Redirect ke halaman POS jika tidak ada data receipt
                return;
            }

            const formatCurrency = (v) => `Rp ${new Intl.NumberFormat('id-ID').format(v)}`;
            
            document.querySelector('[data-receipt-total]').textContent = formatCurrency(receipt.totalPrice || 0);
            document.querySelector('[data-receipt-number]').textContent = receipt.id || '-';
            
            const paymentMethod = receipt.payment_method || 'cash';
            const isCash = paymentMethod === 'cash';
            const methodStr = isCash ? 'Cash' : (paymentMethod === 'transfer' ? 'Bank Transfer' : 'QRIS');
            document.querySelector('[data-receipt-method]').textContent = methodStr;
            
            // Icon handling
            const icon = document.querySelector('[data-receipt-method]').previousElementSibling;
            if (icon) {
                icon.className = isCash ? 'fa-solid fa-money-bill-wave text-primary' : (paymentMethod === 'transfer' ? 'fa-solid fa-building-columns text-primary' : 'fa-solid fa-qrcode text-primary');
            }
        });
    </script>
</x-app-layout>
