<x-app-layout title="Digital Receipt #{{ $transaction->order_code }}">
    <div class="min-h-screen bg-slate-50 flex flex-col items-center py-10 px-4">
        <!-- Receipt Container -->
        <div id="receipt-content"
            class="bg-white w-full max-w-[400px] rounded-[32px] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden relative">

            <!-- Side Cutouts (Receipt Aesthetic) -->
            <div class="absolute -left-3 top-1/2 w-6 h-6 rounded-full bg-slate-50 shadow-inner"></div>
            <div class="absolute -right-3 top-1/2 w-6 h-6 rounded-full bg-slate-50 shadow-inner"></div>

            <div class="p-8 sm:p-10">
                <!-- Header (Mirip Struk Fisik) -->
                <div class="text-center mb-6">
                    <img src="{{ asset('img/logo-perpus.webp') }}" alt="Logo"
                        class="h-16 mx-auto mb-4 grayscale opacity-90">
                    <h1 class="text-xl font-black text-slate-800 uppercase tracking-tighter">Library Cafe</h1>
                    <div class="text-[11px] text-slate-500 leading-relaxed mt-1 font-medium">
                        UPT Perpustakaan dan Layanan Digital<br>
                        Jl. A. Yani Tromol Pos I, Pabelan<br>
                        Surakarta 57102
                    </div>
                </div>

                <div class="border-t border-dashed border-slate-200 my-6"></div>

                <!-- Transaction Meta -->
                <div class="space-y-2 text-[12px]">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-bold tracking-widest">Penjualan</span>
                        <span class="text-slate-800 font-bold tracking-tight">{{ $transaction->order_code }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-bold tracking-widest">Tanggal</span>
                        <span
                            class="text-slate-800 font-bold tracking-tight">{{ $transaction->paid_at ? $transaction->paid_at->format('d/m/Y H:i') : $transaction->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-400 font-bold tracking-widest">Kasir</span>
                        <span
                            class="text-slate-800 font-bold tracking-tight">{{ $transaction->user->name ?? 'Kasir' }}</span>
                    </div>
                </div>

                <div class="border-t border-dashed border-slate-200 my-6"></div>

                <!-- Items List -->
                <div class="space-y-5">
                    @foreach ($transaction->items as $item)
                        <div class="flex justify-between items-start">
                            <div class="flex-1 pr-4">
                                <h4
                                    class="text-[13px] font-black text-slate-800 leading-tight uppercase tracking-tight">
                                    {{ $item->product_name }}</h4>
                                <p class="text-[11px] text-slate-500 font-bold mt-0.5">
                                    {{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <span class="text-[13px] font-black text-slate-800 tracking-tighter">
                                {{ number_format($item->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-dashed border-slate-200 my-6"></div>

                <!-- Summary -->
                <div class="space-y-2.5">
                    <div class="flex justify-between text-[13px] items-center">
                        <span class="text-slate-500 font-bold uppercase tracking-wider">Subtotal
                            ({{ $transaction->items->sum('quantity') }} item)</span>
                        <span
                            class="text-slate-800 font-bold tracking-tight">{{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                    </div>

                    @php $discount = $transaction->subtotal - $transaction->total; @endphp
                    @if ($discount > 0)
                        <div class="flex justify-between text-[13px] items-center text-red-500">
                            <span class="font-bold uppercase tracking-wider">Diskon</span>
                            <span class="font-bold tracking-tight">-{{ number_format($discount, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center pt-3 mt-3 border-t border-dashed border-slate-200">
                        <span class="text-base font-black text-slate-800 uppercase tracking-tighter">Total</span>
                        <span class="text-2xl font-black text-slate-900 tracking-tighter">
                            {{ number_format($transaction->total, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="pt-4 space-y-2">
                        <div class="flex justify-between text-[12px] items-center">
                            <span class="text-slate-400 font-bold uppercase tracking-widest">
                                {{ $transaction->payment_method ?? 'Tunai' }}
                            </span>
                            <span
                                class="text-slate-800 font-bold tracking-tight">{{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-[12px] items-center">
                            <span class="text-slate-400 font-bold uppercase tracking-widest">Kembalian</span>
                            <span
                                class="text-slate-800 font-bold tracking-tight">{{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-dashed border-slate-200 my-8"></div>

                <!-- Footer -->
                <div class="text-center">
                    <p class="text-[11px] font-bold text-slate-500 italic mb-4 leading-relaxed tracking-tighter">
                        "Makan, Minum, Baca, Santai"
                    </p>
                    <div class="space-y-1 text-[10px] font-bold text-slate-400 tracking-widest">
                        <p>Instagram: @perpusums</p>
                        <p>Wifi: UMS Wifi | Password: ums.wifi</p>
                    </div>
                    <div class="mt-6 text-[12px] font-black text-slate-800 tracking-[0.3em] opacity-30">
                        * TERIMA KASIH *
                    </div>
                </div>
            </div>
        </div>

        {{-- cetak nota --}}
        <div class="mt-8 flex gap-8 text-sm font-bold text-slate-400 justify-center">
            <a href="https://instagram.com/perpusums" target="_blank"
                class="mt-8 flex items-center gap-2 text-slate-400 hover:text-primary transition-colors text-xs font-black uppercase tracking-[0.2em]">
                <i class="fa-brands fa-instagram text-base"></i>
                Follow Us
            </a>
            <button id="download-pdf"
                class="mt-8 flex items-center gap-2 text-slate-400 hover:text-primary transition-colors text-xs font-black uppercase tracking-[0.2em] cursor-pointer">
                <i class="fa-solid fa-download text-base"></i>
                Unduh Nota Digital
            </button>
        </div>

    </div>

    <!-- Include dom-to-image and jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('download-pdf').addEventListener('click', function() {
                const element = document.getElementById('receipt-content');
                
                if (!element) {
                    alert('Elemen struk tidak ditemukan.');
                    return;
                }

                // Show a loading state on the button
                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin text-base"></i> Mengunduh...';
                btn.disabled = true;

                // Configure dom-to-image options
                // Multiply scale to improve resolution
                const scale = 2;
                const style = {
                    transform: 'scale('+scale+')',
                    transformOrigin: 'top left',
                    width: element.offsetWidth + 'px',
                    height: element.offsetHeight + 'px'
                };
                const param = {
                    height: element.offsetHeight * scale,
                    width: element.offsetWidth * scale,
                    quality: 0.98,
                    bgcolor: '#ffffff',
                    style: style
                };

                // Use dom-to-image to avoid html2canvas oklch parsing issues
                domtoimage.toJpeg(element, param)
                    .then(function (dataUrl) {
                        const { jsPDF } = window.jspdf;
                        
                        // We use a custom format tailored for thermal receipts or let it be scaled.
                        // Thermal receipt width is typically 80mm. 
                        const pdf = new jsPDF({
                            orientation: 'portrait',
                            unit: 'mm',
                            format: [80, (element.offsetHeight / element.offsetWidth) * 80]
                        });
                        
                        const pdfWidth = pdf.internal.pageSize.getWidth();
                        const pdfHeight = pdf.internal.pageSize.getHeight();
                        
                        pdf.addImage(dataUrl, 'JPEG', 0, 0, pdfWidth, pdfHeight);
                        pdf.save('nota_{{ $transaction->order_code }}.pdf');
                        
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    })
                    .catch(function (err) {
                        console.error('Error generating image:', err);
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                        alert('Gagal mengunduh nota: ' + (err.message || err));
                    });
            });
        });
    </script>
</x-app-layout>
