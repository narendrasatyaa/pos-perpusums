<x-app-layout :title="'Library Cafe'">
    <div class="min-h-screen bg-primary font-sans text-white selection:bg-accent selection:text-primary">
        <main>
            {{-- hero page --}}
            <section class="relative overflow-hidden py-20 lg:py-28">
                {{-- gambar bg --}}
                <img src="{{ asset('img/bg-hero.png') }}" alt="Library Background"
                    class="absolute inset-0 h-full w-full object-cover object-bottom z-0">
                {{-- atur kegelapan --}}
                <div class="absolute inset-0 bg-secondary/100 mix-blend-multiply z-0"></div>

                {{-- z indexing --}}
                <div class="relative z-10 mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
                    <div class="grid items-center gap-20 lg:grid-cols-2 lg:gap-12 pl-2">
                        <div class="max-w-2xl">
                            <h1
                                class="text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-[3.5rem]">
                                Aplikasi POS untuk Semua Kebutuhan operasional Library Cafe.
                            </h1>

                            <p class="mt-6 text-lg font-medium text-white/90 sm:text-xl">
                                Sistem POS cepat untuk mengatur pesanan, memantau stok, dan mencatat pengeluaran Library
                                Cafe.
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


            {{-- fitur unggulan --}}
            {{-- <section id="fitur" class="py-20 bg-primary">
                <div class="mx-auto max-w-7xl px-5 text-center">

                    <h2 class="text-3xl font-extrabold sm:text-4xl">
                        Fitur unggulan POS
                    </h2>

                    <div class="grid mt-16 gap-10 sm:grid-cols-2 lg:grid-cols-4">

                        <div>
                            <div class="mb-4 h-12 w-12 flex items-center justify-center bg-accent/20 text-accent rounded">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <h3 class="font-bold">Analisis</h3>
                            <p class="text-white/60">Laporan penjualan realtime</p>
                        </div>

                        <div>
                            <div class="mb-4 h-12 w-12 flex items-center justify-center bg-accent/20 text-accent rounded">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <h3 class="font-bold">Karyawan</h3>
                            <p class="text-white/60">Manajemen tim kasir</p>
                        </div>

                        <div>
                            <div class="mb-4 h-12 w-12 flex items-center justify-center bg-accent/20 text-accent rounded">
                                <i class="fa-solid fa-id-card"></i>
                            </div>
                            <h3 class="font-bold">Role</h3>
                            <p class="text-white/60">Multi akses user</p>
                        </div>

                        <div>
                            <div class="mb-4 h-12 w-12 flex items-center justify-center bg-accent/20 text-accent rounded">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <h3 class="font-bold">Security</h3>
                            <p class="text-white/60">Data aman</p>
                        </div>

                    </div>
                </div>
            </section> --}}

            <section id="fitur" class="relative py-24 bg-primary overflow-hidden">

                <!-- background glow -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-accent/10 blur-[120px]">
                </div>

                <div class="relative mx-auto max-w-7xl px-5 text-center">
                    <h2 class="text-3xl font-extrabold sm:text-4xl text-white">
                        Sistem Internal Library Cafe
                    </h2>
                    <p class="mt-4 text-white/60 max-w-xl mx-auto">
                        Aplikasi berbasis POS ini dirancang secara khusus untuk kelancaran operasional Library Cafe UPT Perpustakaan UMS.
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
                                Pencatatan riwayat transaksi penjualan kafe secara otomatis untuk transparansi rekap bulanan.
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
                                Kemudahan dalam mengatur daftar makanan/minuman, kategori, serta pembaruan harga secara instan.
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
            <section class="bg-secondary py-20 text-center">
                <div class="max-w-3xl mx-auto px-5">

                    <h2 class="text-3xl font-extrabold sm:text-4xl lg:text-5xl">
                        Siap untuk memulai?
                    </h2>
                    <p class="mt-4 text-white/70">
                        Silakan login menggunakan kredensial identitas yang telah didistribusikan oleh pengelola UPT Perpustakaan UMS.
                    </p>
                    <div class="mt-10">
                        <a href="{{ route('access') }}"
                            class="bg-accent rounded-full text-primary px-10 py-4 rounded font-bold transition hover:bg-info hover:shadow-lg inline-block">
                            Akses Sistem
                        </a>
                    </div>

                </div>
            </section>

        </main>

        {{-- footer --}}
        <footer class="border-t border-white/10 bg-secondary py-10 text-center text-white/60 text-sm">
            ©{{ date('Y') }} Library Cafe UPT Perpustakaan & Layanan Digital UM Surakarta. All rights reserved.
        </footer>

    </div>
</x-app-layout>
