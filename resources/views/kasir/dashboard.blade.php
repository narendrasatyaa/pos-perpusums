<x-app-layout :title="'Dashboard Kasir'">
    <div class="flex h-screen bg-[#f8f9fa] font-sans selection:bg-accent selection:text-primary">
        <x-sidebar />

        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            {{-- Header --}}
            <header
                class="bg-white/80 backdrop-blur-md h-[72px] px-8 flex items-center justify-end shadow-sm z-20 border-b border-slate-100 flex-shrink-0 sticky top-0">
                <div class="flex items-center gap-5">
                    <div class="text-right leading-tight">
                        <p id="current-date" class="text-sm font-bold text-primary">{{ now()->translatedFormat('l, d F Y') }}</p>
                        <p id="current-time" class="text-primary font-bold">{{ date('H:i:s') }} WIB</p>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <div class="flex-1 overflow-y-auto p-8 lg:p-10 space-y-8 pb-12">

                {{-- Welcome & Buka POS --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-primary font-medium text-xl">
                            Selamat Datang, {{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}
                        </h2>
                        <p class="text-secondary/60 text-sm mt-1">Ringkasan aktivitas operasional Library Cafe hari ini.
                        </p>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Transaksi --}}
                    <div class="bg-primary rounded-xl p-6 text-white shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-white/60 text-xs font-medium uppercase tracking-wider mb-1">TRANSAKSI HARI INI</p>
                            <h3 class="text-3xl font-medium text-white">{{ $transactionCount }}</h3>
                        </div>
                    </div>

                    {{-- Penjualan --}}
                    <div class="bg-primary rounded-xl p-6 text-white shadow-sm flex flex-col justify-between">
                        <div>
                            <p class="text-white/60 text-xs font-medium uppercase tracking-wider mb-1">TOTAL
                                PENJUALAN HARI INI</p>
                            <h3 class="text-3xl font-medium text-white">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="grid grid-cols-3 gap-6 pt-2">
                    <a href="{{ route('kasir.stok') }}"
                        class="bg-primary text-white rounded-xl p-6 flex items-center gap-5 transition-all group shadow-sm">
                        <div class="flex-1">
                            <p class="font-medium text-base">Lihat Stok Bahan</p>
                            <p class="text-white/60 text-xs mt-1">Input kondisi bahan baku harian.</p>
                        </div>
                        <i
                            class="fa-solid fa-arrow-right text-white/50 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('kasir.histori') }}"
                        class="bg-accent rounded-xl p-6 flex items-center gap-5 shadow-sm transition-all group">
                        <div class="flex-1">
                            <p class="font-medium text-base text-secondary">Lihat Riwayat Transaksi</p>
                            <p class="text-secondary/70 text-xs mt-1">Lihat riwayat transaksi sebelumnya.</p>
                        </div>
                        <i
                            class="fa-solid fa-arrow-right text-secondary/40 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="{{ route('kasir.order') }}"
                        class="bg-primary text-white rounded-xl p-6 flex items-center gap-5 shadow-sm transition-all group">
                        <div class="flex-1">
                            <p class="font-medium text-base text-base">Buka POS</p>
                            <p class="text-white/60 text-xs mt-1">Buka POS untuk transaksi.</p>
                        </div>
                        <i
                            class="fa-solid fa-arrow-right text-white/50 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const timeElement = document.getElementById('current-time');
        const dateElement = document.getElementById('current-date');
        const updateTime = () => {
            const now = new Date();
            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            const formattedDate = now.toLocaleDateString('id-ID', options);
            const formattedTime = now.toLocaleTimeString('id-ID');

            if (dateElement) dateElement.textContent = formattedDate;
            if (timeElement) timeElement.textContent = `${formattedTime} WIB`;
        };
        updateTime();
        setInterval(updateTime, 1000);
    });
</script>
