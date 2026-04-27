<x-app-layout :title="'Dokumentasi Library Cafe'">
    <div class="min-h-screen bg-white font-sans selection:bg-primary selection:text-white">
        <x-navbar />
        <main>

            {{-- Hero --}}
            <section class="relative overflow-hidden min-h-screen flex items-center justify-center">
                <img src="{{ asset('img/bg-doc-1.png') }}" alt="Library Background"
                    class="absolute inset-0 h-full w-full object-cover object-bottom z-0">
                <div class="absolute inset-0 bg-secondary/100 mix-blend-multiply z-0"></div>

                <div class="relative z-10 mx-auto max-w-7xl px-5 sm:px-8 lg:px-12 w-full">
                    <div class="max-w-3xl">
                        <h1 class="text-5xl font-extrabold leading-tight tracking-tight text-white sm:text-6xl">
                            Dokumentasi Sistem POS Library Cafe.
                        </h1>
                        <p class="mt-6 text-xl text-white/70 max-w-xl leading-relaxed">
                            Panduan lengkap untuk staf, kasir, dan admin UPT Perpustakaan UMS dalam menggunakan sistem
                            ini.
                        </p>
                        <div class="mt-10 flex flex-wrap items-center gap-4">
                            <a href="#panduan"
                                class="inline-flex items-center justify-center rounded-full bg-accent px-8 py-3.5 font-bold text-primary transition hover:opacity-90">
                                Baca Panduan &nbsp;<i class="fa-solid fa-arrow-down text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Konten --}}
            <section id="panduan" class="bg-white py-16 lg:py-24">
                <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12 space-y-20">

                    {{-- 1. Hak Akses --}}
                    <div id="hak-akses">
                        <p class="text-xs font-bold tracking-widest text-primary uppercase mb-3">01</p>
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Hak Akses (Role)</h2>
                        <p class="text-gray-500 mb-8 max-w-2xl">Sistem memiliki dua level akses yang terpisah
                            berdasarkan fungsi masing-masing pengguna.</p>
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-user-shield"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Admin / Pimpinan</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                    Akses penuh ke seluruh sistem: manajemen menu, kategori, stok gudang, laporan harian
                                    & bulanan, serta pengaturan akun kasir. Login via halaman <code
                                        class="bg-gray-200 text-gray-700 rounded px-1 py-0.5 text-xs">/admin</code>.
                                </p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-user-pen"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Kasir</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                    Akses terbatas ke Terminal Kasir (POS) saja: input pesanan, terima pembayaran, dan
                                    lihat riwayat transaksi shift. Tidak bisa mengakses laporan keuangan atau mengubah
                                    data produk.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-gray-100"></div>

                    {{-- 2. Login --}}
                    <div id="login">
                        <p class="text-xs font-bold tracking-widest text-primary uppercase mb-3">02</p>
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Cara Login ke Sistem</h2>
                        <p class="text-gray-500 mb-8 max-w-2xl">Prosedur masuk berbeda tergantung role pengguna.</p>
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <h3 class="text-base font-bold text-gray-900 mb-4">
                                    <i class="fa-solid fa-desktop text-primary mr-2"></i> Login sebagai Kasir
                                </h3>
                                <ol class="space-y-3 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Buka halaman <a href="{{ route('access') }}"
                                            class="text-primary font-semibold hover:underline">Akses Sistem</a>.</li>
                                    <li>Masukkan email dan password yang diberikan oleh Admin.</li>
                                    <li>Tekan <strong class="text-gray-700">Masuk</strong> — sistem mengarahkan ke
                                        Terminal Kasir.</li>
                                </ol>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <h3 class="text-base font-bold text-gray-900 mb-4">
                                    <i class="fa-solid fa-shield-halved text-primary mr-2"></i> Login sebagai Admin
                                </h3>
                                <ol class="space-y-3 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Buka <code
                                            class="bg-gray-200 text-gray-700 rounded px-1 py-0.5 text-xs">/admin</code>
                                        (Filament Admin Panel).</li>
                                    <li>Masukkan email dan password akun Admin.</li>
                                    <li>Tekan <strong class="text-gray-700">Sign In</strong> — sistem mengarahkan ke
                                        Dashboard Admin.</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-gray-100"></div>

                    {{-- 3. Terminal Kasir --}}
                    <div id="kasir">
                        <p class="text-xs font-bold tracking-widest text-primary uppercase mb-3">03</p>
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Menggunakan Terminal Kasir (POS)</h2>
                        <p class="text-gray-500 mb-8 max-w-2xl">Alur standar transaksi harian di kafe.</p>
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-list"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Pilih Produk</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">Klik produk dari daftar menu.
                                    Gunakan filter kategori atau pencarian untuk menemukan produk lebih cepat.</p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Kelola Keranjang</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">Sesuaikan jumlah item di panel
                                    kanan. Klik hapus untuk membatalkan item sebelum checkout.</p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Proses Bayar</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">Klik <strong
                                        class="text-gray-700">Checkout</strong>, input nominal uang diterima — sistem
                                    otomatis hitung kembalian.</p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Cetak Nota</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">Klik <strong
                                        class="text-gray-700">Cetak Nota</strong> — nota ter-print format 80mm sesuai
                                    printer thermal kafe.</p>
                            </div>
                        </div>
                        <div class="mt-6 border border-gray-100 rounded-2xl p-5 bg-gray-50 flex items-start gap-3">
                            <i class="fa-solid fa-circle-info text-primary mt-0.5"></i>
                            <div class="text-sm text-gray-500 space-y-1">
								<p class="Strong"> Note </p>
                                <p>Produk habis stok tidak akan tampil di daftar kasir secara otomatis.</p>
                                <p>Jika ada kesalahan transaksi, hubungi Admin, kasir tidak bisa hapus riwayat
                                    transaksi.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-gray-100"></div>

                    {{-- 4. Stok & Produk --}}
                    <div id="stok">
                        <p class="text-xs font-bold tracking-widest text-primary uppercase mb-3">04</p>
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Manajemen Stok & Produk</h2>
                        <p class="text-gray-500 mb-8 max-w-2xl">Dikelola oleh Admin / Pimpinan melalui Dashboard
                            Filament.</p>
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-mug-hot"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Tambah / Edit Produk</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                    Masuk ke menu <strong class="text-gray-700">Produk</strong> di sidebar Admin. Klik
                                    <strong class="text-gray-700">Buat Produk</strong> untuk item baru. Isi nama,
                                    kategori, harga, dan stok awal.
                                </p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-boxes-stacked"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Kontrol Stok Gudang</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                    Buka menu <strong class="text-gray-700">Stok</strong> untuk restock bahan baku.
                                    Stok otomatis berkurang setiap ada transaksi di Terminal Kasir.
                                </p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-tags"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Kategori Produk</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                    Menu <strong class="text-gray-700">Kategori</strong> untuk mengelola pengelompokan
                                    (Minuman, Makanan, Snack). Kategori otomatis muncul sebagai filter di Terminal
                                    Kasir.
                                </p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Nonaktifkan Produk</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                    Ubah status produk menjadi <strong class="text-gray-700">Tidak Aktif</strong> jika
                                    sementara tidak tersedia. Data historis tetap tersimpan.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-gray-100"></div>

                    {{-- 5. Laporan --}}
                    <div id="laporan">
                        <p class="text-xs font-bold tracking-widest text-primary uppercase mb-3">05</p>
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Laporan Transaksi</h2>
                        <p class="text-gray-500 mb-8 max-w-2xl">Rekap pendapatan dan aktivitas kafe, khusus Admin /
                            Pimpinan.</p>
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-chart-line"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Laporan Harian</h3>
                                <p class="mt-2 text-sm text-gray-500">Rekap total transaksi hari ini. Bisa difilter per
                                    tanggal.</p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Laporan Bulanan</h3>
                                <p class="mt-2 text-sm text-gray-500">Akumulasi pendapatan per bulan untuk evaluasi dan
                                    rekap ke Kepala UPT.</p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Riwayat Transaksi</h3>
                                <p class="mt-2 text-sm text-gray-500">Daftar semua transaksi dengan detail item, kasir,
                                    dan waktu. Bisa dicari via ID atau tanggal.</p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-file-export"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Export Laporan</h3>
                                <p class="mt-2 text-sm text-gray-500">Unduh laporan PDF / Excel langsung dari halaman
                                    laporan untuk keperluan administratif.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-gray-100"></div>

                    {{-- 6. Pengelolaan User --}}
                    <div id="pengelolaan">
                        <p class="text-xs font-bold tracking-widest text-primary uppercase mb-3">06</p>
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Pengelolaan Akun User</h2>
                        <p class="text-gray-500 mb-8 max-w-2xl">Admin dapat membuat dan mengatur akun kasir dari
                            Dashboard Filament.</p>
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-user-plus"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Buat Akun Kasir Baru</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                    Buka menu <strong class="text-gray-700">Users</strong> di sidebar Admin → klik
                                    <strong class="text-gray-700">Buat User</strong>. Isi nama, email, password, set
                                    role <em>Kasir</em>. Distribusikan kredensial ke staf secara manual.
                                </p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-user-lock"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Reset Password & Nonaktifkan</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed">
                                    Jika kasir lupa password atau tidak lagi bertugas, Admin bisa reset password atau
                                    nonaktifkan akun dari halaman edit user. Riwayat transaksi tetap tersimpan.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            {{-- CTA --}}
            {{-- <section class="bg-primary py-20">
                <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-12">
                    <div class="grid gap-8 lg:grid-cols-[1fr_auto] items-center">
                        <div>
                            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Sudah siap menggunakan
                                sistemnya?</h2>
                            <p class="mt-3 text-white/60 text-lg max-w-xl">Masuk menggunakan akun yang telah diberikan
                                oleh Admin UPT Perpustakaan.</p>
                        </div>
                        <div>
                            <a href="{{ route('access') }}"
                                class="inline-flex items-center justify-center rounded-full bg-white px-8 py-3.5 font-bold text-primary transition hover:bg-accent">
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
