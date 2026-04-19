<x-app-layout :title="'Library Cafe'">
    <div class="min-h-screen bg-primary font-sans text-white selection:bg-accent selection:text-primary">
        <x-navbar/>
        <main>
            {{-- hero page --}}
            <section class="relative overflow-hidden min-h-screen flex items-center justify-center"">
                {{-- gambar bg --}}
                <img src="{{ asset('img/bg-hero-1.webp') }}" alt="Library Background"
                    class="absolute inset-0 h-full w-full object-cover object-bottom z-0">
                {{-- atur kegelapan --}}
                <div class="absolute inset-0 bg-secondary/100 mix-blend-multiply z-0"></div>

                {{-- z indexing --}}
                <div class="relative z-10 mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
                    <div class="grid items-center gap-20 lg:grid-cols-2 lg:gap-12 pl-2">
                        <div class="max-w-2xl">
                            <h1
                                class="text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-[3.5rem]">
                                {{-- Aplikasi POS untuk Semua Kebutuhan operasional Library Cafe. --}}
                                Kelola Library Cafe Lebih Cepat & Mudah.
                            </h1>

                            <p class="mt-6 text-lg font-medium text-white/90 sm:text-xl">
                                Sistem POS cepat untuk mengatur pesanan, memantau stok, dan mencatat pengeluaran Library Cafe.
                            </p>
                            <div class="mt-10 flex flex-wrap items-center gap-4">
                                <a href="{{ route('access') }}"
                                    class="inline-flex justify-center rounded-full border-2 border-white px-8 py-3.5 font-bold text-white transition hover:bg-accent hover:text-primary hover:border-accent">
                                    Akses Sistem
                                </a>
                                <a href="#fitur"
                                    class="inline-flex items-center text-sm font-semibold text-white/80 transition hover:text-accent">
                                    Kenapa harus Library Cafe POS? &nbsp; <i class="fa-solid fa-arrow-down text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="fitur" class="relative py-24 bg-primary overflow-hidden">

                <!-- background glow -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-accent/10 blur-[120px]">
                </div>

                <div class="relative mx-auto max-w-7xl px-5 text-center">
                    <h2 class="text-3xl font-extrabold sm:text-4xl text-white">
                        Sistem Internal Library Cafe
                    </h2>
                    <p class="mt-4 text-white/60 max-w-xl mx-auto">
                        Aplikasi berbasis POS ini dirancang secara khusus untuk kelancaran operasional Library Cafe UPT
                        Perpustakaan UMS.
                    </p>
                    {{-- grid --}}
                    <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        <div
                            class="group rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 p-6 text-left transition duration-300 hover:bg-white/10 hover:shadow-xl hover:-translate-y-1">

                            <div
                                class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-accent/20 text-accent text-lg">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>

                            <h3 class="text-lg font-bold text-white">Laporan Transaksi</h3>
                            <p class="mt-2 text-sm text-white/60">
                                Pencatatan riwayat transaksi penjualan kafe secara otomatis untuk transparansi rekap
                                bulanan.
                            </p>
                        </div>
                        <div
                            class="group rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 p-6 text-left transition duration-300 hover:bg-white/10 hover:shadow-xl hover:-translate-y-1">

                            <div
                                class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-accent/20 text-accent text-lg">
                                <i class="fa-solid fa-mug-hot"></i>
                            </div>

                            <h3 class="text-lg font-bold text-white">Manajemen Menu</h3>
                            <p class="mt-2 text-sm text-white/60">
                                Kemudahan dalam mengatur daftar makanan/minuman, kategori, serta pembaruan harga secara
                                instan.
                            </p>
                        </div>
                        <div
                            class="group rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 p-6 text-left transition duration-300 hover:bg-white/10 hover:shadow-xl hover:-translate-y-1">

                            <div
                                class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-accent/20 text-accent text-lg">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>

                            <h3 class="text-lg font-bold text-white">Hak Akses Ketat</h3>
                            <p class="mt-2 text-sm text-white/60">
                                Pemisahan dashboard khusus untuk Pimpinan/Admin UPT Perpustakaan dengan akun Kasir.
                            </p>
                        </div>
                        <div
                            class="group rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 p-6 text-left transition duration-300 hover:bg-white/10 hover:shadow-xl hover:-translate-y-1">

                            <div
                                class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-accent/20 text-accent text-lg">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>

                            <h3 class="text-lg font-bold text-white">Kontrol Inventori</h3>
                            <p class="mt-2 text-sm text-white/60">
                                Manajemen stok gudang (seperti biji kopi/cup) untuk mengantisipasi kehabisan pasokan.
                            </p>
                        </div>

                    </div>
                </div>
            </section>

            {{-- cta --}}
            <section class="py-24 bg-primary overflow-hidden border-t border-white/10 text-center text-slate-900">
                <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
                    <div
                        class="rounded-3xl bg-primary px-6 py-12 text-left text-white ring-1 ring-white/20 w-full sm:px-10 lg:px-14 lg:py-14">
                        <div class="grid items-center gap-8 lg:grid-cols-[1fr_auto]">
                            <div>
                                <h2 class="text-3xl font-extrabold leading-tight sm:text-4xl">
                                    Siap transformasi operasional Library Cafe?
                                </h2>
                                <p class="mt-4 max-w-2xl text-base text-blue-100 sm:text-lg">
                                    Gunakan sistem POS internal untuk mempercepat transaksi, menjaga kontrol stok, dan
                                    memudahkan rekap laporan harian.
                                </p>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 sm:gap-4 lg:justify-end">
                                <a href="{{ route('access') }}"
                                    class="inline-flex items-center justify-center rounded-xl border-2 border-white px-8 py-3.5 font-bold text-white transition hover:bg-accent hover:text-primary hover:border-accent">
                                    Akses Sistem
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>

    <x-footer/>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('main-navbar');
            if (!navbar) {
                return;
            }

            const updateNavbarState = () => {
                if (window.scrollY > 24) {
                    navbar.classList.remove('bg-transparent', 'border-transparent');
                    navbar.classList.add('bg-slate-900/70', 'border-white/10', 'backdrop-blur-md', 'shadow-lg');
                } else {
                    navbar.classList.remove('bg-slate-900/70', 'border-white/10', 'backdrop-blur-md', 'shadow-lg');
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
