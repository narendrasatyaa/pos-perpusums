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

                    {{-- 1. Cara Login --}}
                    <div id="cara-login">
                        <p class="text-xs font-bold tracking-widest text-primary uppercase mb-3">01</p>
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Cara Akses & Login</h2>
                        <p class="text-gray-500 mb-8 max-w-2xl">Langkah pertama sebelum menggunakan fitur adalah login menggunakan rute yang sesuai dengan jabatan Anda.</p>
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <h3 class="text-base font-bold text-gray-900"><i class="fa-solid fa-desktop text-primary mr-2"></i> Akses Kasir</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed mb-3">
                                    Untuk melayani pelanggan sehari-hari:
                                </p>
                                <ol class="space-y-1 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Buka URL <code class="bg-gray-200 text-gray-700 rounded px-1 text-xs">/login</code></li>
                                    <li>Ketik Email & Password Kasir</li>
                                    <li>Klik tombol <strong>Masuk</strong></li>
                                </ol>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <h3 class="text-base font-bold text-gray-900"><i class="fa-solid fa-user-shield text-primary mr-2"></i> Akses Admin</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed mb-3">
                                    Untuk mengelola data di Filament:
                                </p>
                                <ol class="space-y-1 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Buka URL <code class="bg-gray-200 text-gray-700 rounded px-1 text-xs">/admin/login</code></li>
                                    <li>Ketik kredensial Administrator</li>
                                    <li>Klik tombol <strong>Sign In</strong></li>
                                </ol>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <h3 class="text-base font-bold text-gray-900"><i class="fa-solid fa-file-invoice-dollar text-primary mr-2"></i> Akses Finance</h3>
                                <p class="mt-2 text-sm text-gray-500 leading-relaxed mb-3">
                                    Untuk melihat laporan keuangan pusat:
                                </p>
                                <ol class="space-y-1 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Buka URL <code class="bg-gray-200 text-gray-700 rounded px-1 text-xs">/finance/login</code></li>
                                    <li>Ketik akun Finance</li>
                                    <li>Klik tombol <strong>Sign In</strong></li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-gray-100"></div>

                    {{-- 2. Panduan Admin --}}
                    <div id="panduan-admin">
                        <p class="text-xs font-bold tracking-widest text-primary uppercase mb-3">02</p>
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Panduan Penggunaan Admin</h2>
                        <p class="text-gray-500 mb-8 max-w-2xl">Langkah-langkah mengelola data toko melalui Panel Admin (Filament).</p>
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-boxes-stacked"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Cara Menambah Produk Baru</h3>
                                <ol class="mt-2 space-y-2 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Buka menu <strong>Products</strong> di sidebar kiri.</li>
                                    <li>Klik tombol <strong>New Product</strong>.</li>
                                    <li>Isi data produk seperti Nama, Harga dasar, dan Stok awal. Anda juga bisa mengunggah foto.</li>
                                    <li>Pilih kategori yang sesuai.</li>
                                    <li>Klik tombol <strong>Create</strong> atau <strong>Save</strong>.</li>
                                </ol>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Cara Menambah Kasir Baru</h3>
                                <ol class="mt-2 space-y-2 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Buka menu <strong>Users</strong>.</li>
                                    <li>Klik tombol <strong>New User</strong>.</li>
                                    <li>Masukkan Nama lengkap, Email (untuk login), dan password standar.</li>
                                    <li>Pilih Role pengguna tersebut menjadi "Kasir" atau "Admin".</li>
                                    <li>Klik <strong>Create</strong>. Berikan kredensial ke pegawai Anda.</li>
                                </ol>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-ticket"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Cara Membuat Promo (Voucher)</h3>
                                <ol class="mt-2 space-y-2 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Buka menu <strong>Vouchers</strong>.</li>
                                    <li>Klik tombol <strong>New Voucher</strong>.</li>
                                    <li>Isi kolom Kode Voucher (misal: "CAFE50").</li>
                                    <li>Atur tipe (persen / nominal) dan besaran nilainya.</li>
                                    <li>Tentukan batas minimum belanja jika ada. Klik <strong>Create</strong>.</li>
                                </ol>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Cara Audit Transaksi & QRIS</h3>
                                <ol class="mt-2 space-y-2 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Buka menu <strong>Transactions</strong>.</li>
                                    <li>Anda akan melihat tabel seluruh riwayat penjualan.</li>
                                    <li>Klik ikon 'View' pada pesanan berstatus QRIS.</li>
                                    <li>Cek gambar bukti transfer yang dilampirkan kasir untuk memastikan dana sudah valid.</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-gray-100"></div>

                    {{-- 3. Panduan Kasir --}}
                    <div id="panduan-kasir">
                        <p class="text-xs font-bold tracking-widest text-primary uppercase mb-3">03</p>
                        <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Panduan Penggunaan Kasir</h2>
                        <p class="text-gray-500 mb-8 max-w-2xl">Langkah-langkah bagi Kasir dalam melayani dan memproses pesanan sehari-hari.</p>
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50 lg:col-span-2">
                                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-cart-arrow-down"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Cara Menerima Pesanan & Bayar</h3>
                                <ol class="mt-2 space-y-2 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Masuk ke layar pesanan utama: <code class="bg-gray-200 text-gray-700 rounded px-1 text-xs">/kasir/order</code>.</li>
                                    <li>Ketuk gambar makanan/minuman yang dipesan pelanggan untuk memasukkannya ke kolom keranjang di kanan.</li>
                                    <li>Gunakan tombol <strong>+ / -</strong> di keranjang jika pelanggan menambah porsi.</li>
                                    <li>Setelah sesuai, klik <strong>Checkout / Proses Pembayaran</strong>.</li>
                                    <li>Jika pelanggan menggunakan tunai, masukkan nominal uang yang diberikan, sistem akan menampilkan sisa kembalian. Jika QRIS, foto bukti layarnya lalu klik unggah (upload).</li>
                                    <li>Klik <strong>Konfirmasi Pembayaran</strong>.</li>
                                </ol>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-arrows-split-up-and-left"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Cara Split Bill (Pisah Tagihan)</h3>
                                <ol class="mt-2 space-y-2 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Buka halaman <code class="bg-gray-200 text-gray-700 rounded px-1 text-xs">/kasir/split-bill</code>.</li>
                                    <li>Pilih nota pesanan pelanggan rombongan tersebut.</li>
                                    <li>Tandai item mana saja yang akan dibayar oleh pelanggan pertama, proses pembayarannya.</li>
                                    <li>Ulangi langkah untuk item sisa milik pelanggan kedua.</li>
                                </ol>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50">
                                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-toggle-on"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Cara Mematikan Menu Habis</h3>
                                <ol class="mt-2 space-y-2 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Jika dapur lapor bahwa es batu habis, segera buka halaman <code class="bg-gray-200 text-gray-700 rounded px-1 text-xs">/kasir/stok</code>.</li>
                                    <li>Cari menu berbahan es tersebut.</li>
                                    <li>Klik <strong>Tombol Sakelar (Toggle)</strong> menjadi OFF.</li>
                                    <li>Menu tersebut akan langsung hilang dari layar order agar kasir tidak sengaja menjualnya lagi.</li>
                                </ol>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-6 bg-gray-50 lg:col-span-2">
                                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary text-lg">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Cara Cetak Ulang Struk & Lihat Histori</h3>
                                <ol class="mt-2 space-y-2 text-sm text-gray-500 list-decimal list-inside">
                                    <li>Buka halaman <code class="bg-gray-200 text-gray-700 rounded px-1 text-xs">/kasir/histori</code>.</li>
                                    <li>Halaman ini memuat transaksi Anda pada hari ini.</li>
                                    <li>Klik salah satu transaksi untuk melihat detail pesanannya.</li>
                                    <li>Untuk mencetak ulang struk yang gagal ter-print, klik ikon Cetak. Anda dapat memilih cetak ke Printer Thermal (format PDF kecil) atau menampilkan struk QR (untuk pelanggan yang tidak ingin cetak kertas).</li>
                                </ol>
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
