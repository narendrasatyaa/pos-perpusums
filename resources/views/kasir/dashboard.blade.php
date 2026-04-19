<x-app-layout :title="'Dashboard Kasir'">
    <div class="flex h-screen bg-slate-50 font-sans selection:bg-accent selection:text-primary">
        <x-sidebar />

        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            {{-- header --}}
            <header class="bg-white/80 backdrop-blur-md h-20 px-10 flex items-center justify-between shadow-sm z-20 border-b border-slate-100 flex-shrink-0 sticky top-0">

                <div class="flex items-center gap-4 justify-end w-full">
                    <div class="text-right mr-4 border-slate-200 pr-4 hidden md:block">
                        <p class="text-sm font-bold text-primary">{{ now()->translatedFormat('l, d F Y') }}</p>
                        <p class="text-xs text-secondary/60 font-medium clock-display">00:00:00 WIB</p>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto custom-scrollbar p-6 lg:p-8 space-y-8 pb-20">
                
                @php
                    $hour = now()->format('H');
                    $hari = $hour < 12 ? 'Pagi' : ($hour < 15 ? 'Siang' : ($hour < 18 ? 'Sore' : 'Malam'));
                @endphp

                <!-- Hero Section: Welcome & Quick Action -->
                <div class=" rounded-3xl bg-primary p-8 shadow-xl">
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="text-white space-y-2 max-w-xl">
                            <h2 class="text-3xl lg:text-4xl font-extrabold tracking-tight">
                                Selamat {{ $hari }}, <span class="text-accent">{{ explode(' ', Auth::user()->name)[0] }}</span>! 👋
                            </h2>
                            <p class="text-slate-200 text-sm leading-relaxed mt-2">
                                Cek stok hari ini atau langsung mulai terima pesanan pelanggan. Jangan lupa tersenyum!
                            </p>
                        </div>
                        
                        <div class="shrink-0 flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('kasir.order') }}" class="group relative flex items-center gap-3 bg-accent hover:bg-info text-white px-8 py-4 rounded-2xl font-bold">
                                <i class="fa-solid fa-cash-register text-xl"></i>
                                <span>Mulai Pesanan Baru</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Metrics & Quick Access Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Metric 1 -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute -right-6 -top-6 text-slate-50 text-8xl transition-transform"><i class="fa-solid fa-boxes-stacked"></i></div>
                        <div class="relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-tertiary/10 text-tertiary flex items-center justify-center text-xl mb-4">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <p class="text-secondary/60 text-sm font-bold mb-1">Total Produk Aktif</p>
                            <h3 class="text-3xl font-extrabold text-primary">{{ $products->count() }}</h3>
                            <a href="{{ route('kasir.stok') }}" class="text-xs text-tertiary font-bold hover:underline mt-4 inline-block">Kelola Stok &rarr;</a>
                        </div>
                    </div>

                    <!-- Metric 2 -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute -right-6 -top-6 text-slate-50 text-8xl transition-transform"><i class="fa-solid fa-tags"></i></div>
                        <div class="relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-info/10 text-info flex items-center justify-center text-xl mb-4">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                            <p class="text-secondary/60 text-sm font-bold mb-1">Kategori Menu</p>
                            <h3 class="text-3xl font-extrabold text-primary">{{ $categories->count() }}</h3>
                            <a href="{{ route('kasir.stok') }}" class="text-xs text-info font-bold hover:underline mt-4 inline-block">Lihat Kategori &rarr;</a>
                        </div>
                    </div>

                    <!-- Metric 3 (Placeholder / Mock) -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute -right-6 -top-6 text-slate-50 text-8xl transition-transform"><i class="fa-solid fa-chart-line"></i></div>
                        <div class="relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-green-500/10 text-green-500 flex items-center justify-center text-xl mb-4">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                            <p class="text-secondary/60 text-sm font-bold mb-1">Transaksi Hari Ini</p>
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-3xl font-extrabold text-primary">0</h3>
                                <span class="text-xs text-green-500 font-bold bg-green-50 px-2 py-0.5 rounded-full"><i class="fa-solid fa-arrow-up text-[10px]"></i> Baru</span>
                            </div>
                            <a href="{{ route('kasir.histori') }}" class="text-xs text-green-500 font-bold hover:underline mt-4 inline-block">Cek Riwayat &rarr;</a>
                        </div>
                    </div>

                    <!-- Metric 4 (Placeholder / Mock) -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute -right-6 -top-6 text-slate-50 text-8xl transition-transform"><i class="fa-solid fa-wallet"></i></div>
                        <div class="relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-accent/10 text-accent flex items-center justify-center text-xl mb-4">
                                <i class="fa-solid fa-coins"></i>
                            </div>
                            <p class="text-secondary/60 text-sm font-bold mb-1">Estimasi Pemasukan</p>
                            <h3 class="text-2xl font-extrabold text-primary">Rp 0</h3>
                            <a href="{{ route('kasir.histori') }}" class="text-xs text-accent font-bold hover:underline mt-4 inline-block">Lihat Laporan &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- script jam --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clockEl = document.querySelector('.clock-display');
            if(clockEl) {
                setInterval(() => {
                    const now = new Date();
                    clockEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
                }, 1000);
            }
        });
    </script>
</x-app-layout>
