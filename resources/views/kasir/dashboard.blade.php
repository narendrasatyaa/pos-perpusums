<x-app-layout :title="'Dashboard Kasir'">
    <div class="flex flex-col h-screen bg-slate-50 font-sans selection:bg-accent selection:text-primary">
        <x-sidebar />

        <main class="flex-1 flex flex-col overflow-hidden">
            {{-- Content --}}
            <div class="flex-1 overflow-y-auto p-8 lg:p-10 space-y-8 pb-12">

                {{-- Welcome Card --}}
                <div
                    class="relative bg-gradient-to-r from-primary to-secondary rounded-[28px] p-8 text-white overflow-hidden shadow-sm">
                    <div class="relative z-10 max-w-xl">
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                            Selamat Datang, {{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}!
                        </h2>
                        <p class="text-white/80 text-sm mt-2 font-medium leading-relaxed">
                            Ringkasan aktivitas operasional Library Cafe hari ini. Kelola stok bahan, pantau riwayat
                            transaksi, dan layani pelanggan dengan cepat dalam satu platform.
                        </p>
                    </div>
                </div>

                {{-- Stats Grid (Gradients & Premium Cards with Hovers) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Transaksi --}}
                    <div
                        class="bg-gradient-to-br from-primary to-secondary rounded-[24px] p-6 text-white shadow-sm flex justify-between items-center relative overflow-hidden group hover:shadow-md transition-all duration-300">
                        <div class="z-10">
                            <p class="text-white/70 text-xs font-semibold uppercase tracking-wider mb-2">TRANSAKSI HARI
                                INI</p>
                            <h3 class="text-4xl font-extrabold text-white">{{ $transactionCount }}</h3>
                        </div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-white backdrop-blur-sm z-10">
                            <i class="fa-solid fa-receipt text-lg"></i>
                        </div>
                        <div class="absolute -left-6 -bottom-6 w-20 h-20 rounded-full bg-white/5 blur-xl"></div>
                    </div>

                    {{-- Penjualan --}}
                    <div
                        class="bg-gradient-to-br from-primary to-secondary rounded-[24px] p-6 text-white shadow-sm flex justify-between items-center relative overflow-hidden group hover:shadow-md transition-all duration-300">
                        <div class="z-10">
                            <p class="text-white/70 text-xs uppercase font-semibold tracking-wider mb-2">Total Penjualan Hari Ini</p>
                            <h3 class="text-3xl sm:text-4xl font-extrabold text-white">Rp
                                {{ number_format($totalSales, 0, ',', '.') }}</h3>
                        </div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-white backdrop-blur-sm z-10">
                            <i class="fa-solid fa-money-bill-wave text-lg"></i>
                        </div>
                        <div class="absolute -left-6 -bottom-6 w-20 h-20 rounded-full bg-white/5 blur-xl"></div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                    {{-- Lihat Stok --}}
                    <a href="{{ route('kasir.stok') }}"
                        class="bg-white border border-slate-100 rounded-[24px] p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300 group shadow-sm">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all duration-300">
                                <i
                                    class="fa-solid fa-box text-lg transition-transform duration-500 group-hover:rotate-[360deg]"></i>
                            </div>
                            <i
                                class="fa-solid fa-arrow-right text-slate-300 group-hover:text-primary group-hover:translate-x-1.5 transition-all"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-base">Lihat Stok Bahan</p>
                            <p class="text-slate-400 text-xs mt-1 leading-relaxed">Input kondisi bahan baku harian.</p>
                        </div>
                    </a>

                    {{-- Lihat Riwayat --}}
                    <a href="{{ route('kasir.histori') }}"
                        class="bg-white border border-slate-100 rounded-[24px] p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300 group shadow-sm">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-accent/10 flex items-center justify-center text-accent group-hover:bg-accent group-hover:text-white transition-all duration-300">
                                <i
                                    class="fa-solid fa-clock-rotate-left text-lg transition-transform duration-500 group-hover:rotate-[360deg]"></i>
                            </div>
                            <i
                                class="fa-solid fa-arrow-right text-slate-300 group-hover:text-accent group-hover:translate-x-1.5 transition-all"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-base">Riwayat Transaksi</p>
                            <p class="text-slate-400 text-xs mt-1 leading-relaxed">Lihat riwayat transaksi sebelumnya.
                            </p>
                        </div>
                    </a>

                    {{-- Buka POS --}}
                    <a href="{{ route('kasir.order') }}"
                        class="bg-white border border-slate-100 rounded-[24px] p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300 group shadow-sm">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-tertiary/10 flex items-center justify-center text-tertiary group-hover:bg-tertiary group-hover:text-white transition-all duration-300">
                                <i
                                    class="fa-solid fa-cart-shopping text-lg transition-transform duration-500 group-hover:rotate-[360deg]"></i>
                            </div>
                            <i
                                class="fa-solid fa-arrow-right text-slate-300 group-hover:text-tertiary group-hover:translate-x-1.5 transition-all"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 text-base">Buka POS</p>
                            <p class="text-slate-400 text-xs mt-1 leading-relaxed">Buka POS untuk transaksi kasir.</p>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timeElement = document.getElementById('current-time');
        const dateElement = document.getElementById('current-date');
        const updateTime = () => {
            const now = new Date();
            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('id-ID', options);
            const formattedTime = now.toLocaleTimeString('id-ID');

            if (dateElement) dateElement.textContent = formattedDate;
            if (timeElement) timeElement.textContent = `${formattedTime} WIB`;
        };
        updateTime();
        setInterval(updateTime, 1000);
    });
</script>
