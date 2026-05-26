<x-app-layout :title="'Library Cafe UM Surakarta'">
    <div class="min-h-screen bg-white font-sans selection:bg-accent selection:text-primary">
        <x-navbar />
        <main>

            {{-- Hero --}}
            <section class="relative overflow-hidden min-h-screen flex items-center justify-center">
                <img src="{{ asset('img/bg-hero-1.webp') }}" alt="Library Background"
                    class="absolute inset-0 h-full w-full object-cover object-bottom z-0">
                <div class="absolute inset-0 bg-secondary/100 mix-blend-multiply z-0"></div>

                <div class="relative z-10 mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
                    <div class="grid items-center gap-20 lg:grid-cols-2 lg:gap-12 pl-2">
                        <div class="max-w-2xl">
                            <h1
                                class="text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-[3.5rem] text-white">
                                Kelola Library Cafe Lebih Cepat & Mudah.
                            </h1>

                            <p class="mt-6 text-lg font-medium text-white/90 sm:text-xl">
                                Sistem POS cepat untuk mengatur pesanan, memantau stok, dan mencatat pengeluaran Library
                                Cafe.
                            </p>
                            <div class="mt-10 flex flex-wrap items-center gap-4">
                                <a href="{{ route('access') }}"
                                    class="inline-flex items-center justify-center rounded-full border-2 border-white bg-transparent px-8 py-3.5 font-bold text-white shadow-lg transition-all duration-300 hover:bg-accent hover:text-primary hover:border-accent hover:shadow-xl">
                                    Akses Sistem
                                    <i class="fa-solid fa-right-to-bracket ml-2"></i>
                                </a>
                                <a href="#fitur"
                                    class="inline-flex items-center text-sm font-semibold text-white/80 transition hover:text-accent">
                                    Kenapa harus Library Cafe POS? &nbsp; <i class="fa-solid fa-arrow-down text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
            </section>

            {{-- Fitur Section – Light Background --}}
            <section id="fitur" class="bg-white py-24 lg:py-32">
                <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
                    <div class="max-w-2xl mb-16">
                        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl leading-tight">
                            Semua yang dibutuhkan operasional Library Cafe
                        </h2>
                        <p class="mt-4 text-gray-500 text-lg">
                            Dirancang khusus untuk keperluan internal kafe UPT Perpustakaan UMS tidak untuk penggunaan
                            publik
                        </p>
                    </div>

                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                            <div
                                class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                <i class="fa-solid fa-desktop"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-900">Terminal Kasir</h3>
                            <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                Antarmuka cepat untuk input pesanan dan terima pembayaran dari pelanggan kafe.
                            </p>
                        </div>

                        <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                            <div
                                class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-900">Manajemen Stok</h3>
                            <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                Pantau dan kelola bahan baku serta menu secara real-time agar tidak kehabisan stok.
                            </p>
                        </div>

                        <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                            <div
                                class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-900">Laporan Transaksi</h3>
                            <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                Rekap pendapatan harian dan bulanan secara otomatis untuk keperluan pelaporan UPT.
                            </p>
                        </div>

                        <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                            <div
                                class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                <i class="fa-solid fa-users-gear"></i>
                            </div>
                            <h3 class="text-base font-bold text-gray-900">Manajemen User</h3>
                            <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                Kelola akun kasir dan admin dengan pembagian hak akses yang jelas dan aman.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Highlight Section – Slightly Off-white --}}
            <section class="bg-gray-50 border-t border-gray-100 py-24">
                <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
                    <div class="grid gap-12 lg:grid-cols-2 items-center">
                        <div>
                            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl leading-tight">
                                Dibangun khusus bukan <br>solusi generik
                            </h2>
                            <p class="mt-5 text-gray-500 text-lg leading-relaxed">
                                POS Library Cafe dirancang dari awal untuk kebutuhan spesifik kafe di dalam UPT
                                Perpustakaan UMS, dari alur transaksi, pembagian role, hingga format laporan yang sesuai
                                standar institusi.
                            </p>
                            <ul class="mt-8 space-y-4">
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary text-xs">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <span class="text-gray-600 text-sm">Transaksi kasir selesai dalam hitungan
                                        detik</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary text-xs">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <span class="text-gray-600 text-sm">Role kasir & admin terpisah dengan akses
                                        terkontrol</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary text-xs">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <span class="text-gray-600 text-sm">Laporan otomatis siap dicetak setiap akhir
                                        hari</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="mt-1 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary text-xs">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <span class="text-gray-600 text-sm">Stok terupdate otomatis setiap transaksi
                                        berlangsung</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Kolom kanan: gambar --}}
                        <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm bg-gray-50 aspect-[4/3] flex items-center justify-center">
                            <img src="{{ asset('img/pos-preview.png') }}" alt="Preview Sistem POS Library Cafe"
                                class="w-full h-full object-cover object-top">
                        </div>

                    </div>
                </div>
            </section>

            {{-- CTA --}}
            {{-- <section class="bg-primary py-24">
                <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
                    <div class="grid gap-8 lg:grid-cols-[1fr_auto] items-center">
                        <div>
                            <h2 class="text-3xl font-extrabold text-white sm:text-4xl leading-tight">
                                Siap menggunakan sistem?
                            </h2>
                            <p class="mt-3 text-white/60 text-lg max-w-xl">
                                Masuk menggunakan akun yang telah diberikan oleh Admin UPT Perpustakaan.
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('access') }}"
                                class="inline-flex items-center justify-center rounded-full bg-white px-8 py-3.5 font-bold text-primary transition hover:bg-accent hover:text-primary">
                                <i class="fa-solid fa-right-to-bracket mr-2"></i> Akses Sistem
                            </a>
                        </div>
                    </div>
                </div>
            </section> --}}

        </main>
        <x-footer />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('main-navbar');
            if (!navbar) return;
            const updateNavbarState = () => {
                if (window.scrollY > 24) {
                    navbar.classList.remove('bg-transparent', 'border-transparent');
                    navbar.classList.add('bg-slate-900/70', 'border-white/10', 'backdrop-blur-md', 'shadow-lg');
                } else {
                    navbar.classList.remove('bg-slate-900/70', 'border-white/10', 'backdrop-blur-md',
                        'shadow-lg');
                    navbar.classList.add('bg-transparent', 'border-transparent');
                }
            };
            updateNavbarState();
            window.addEventListener('scroll', updateNavbarState, {
                passive: true
            });
        });
    </script>
</x-app-layout>
