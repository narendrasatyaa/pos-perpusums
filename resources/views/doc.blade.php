<x-app-layout :title="'Dokumentasi Library Cafe'">
    <div class="min-h-screen bg-slate-50/50 font-sans">
        <x-navbar />

        <main>
            {{-- Hero Section - Dipercantik --}}
            <section class="relative overflow-hidden min-h-screen flex items-center justify-center">
                <img src="{{ asset('img/bg-doc-1.png') }}" alt="Library Background"
                    class="absolute inset-0 h-full w-full object-cover object-bottom">

                <!-- Overlay lebih elegan -->
                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-secondary/90 to-secondary/95"></div>

                <div class="relative z-10 mx-auto max-w-7xl px-6 sm:px-8 lg:px-12 w-full">
                    <div class="max-w-3xl">
                        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold leading-[1.1] tracking-tighter text-white">
                            Kelola Library Cafe<br>Lebih Cepat & Mudah
                        </h1>
                        <p class="mt-6 text-xl sm:text-2xl text-white/80 max-w-xl leading-relaxed">
                            Sistem POS untuk mengatur pesanan, stok, dan keuangan Library Cafe UPT Perpustakaan UMS.
                        </p>
                        <div class="mt-10 flex flex-wrap gap-4">
                            <a href="{{ route('access') }}"
                                class="inline-flex items-center justify-center rounded-2xl bg-white px-8 py-4 font-semibold text-secondary hover:bg-accent hover:text-white transition-all duration-300 shadow-xl">
                                Akses Sistem
                                <i class="fa-solid fa-right-to-bracket ml-3"></i>
                            </a>
                            <a href="#panduan"
                                class="inline-flex items-center justify-center rounded-2xl border-2 border-white/80 px-8 py-4 font-semibold text-white hover:bg-white/10 transition-all duration-300">
                                Lihat Panduan
                                <i class="fa-solid fa-arrow-down ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Scroll indicator -->
                <div class="absolute bottom-12 left-1/2 -translate-x-1/2 text-white/70 animate-bounce">
                    <i class="fa-solid fa-chevron-down text-3xl"></i>
                </div>
            </section>

            <section id="panduan" class="bg-white py-20">
                <div class="mx-auto max-w-7xl px-6 sm:px-8 lg:px-12">
                    
                    {{-- Section Header --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-8 mb-16">
                        <div>
                            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                                Panduan Penggunaan Sistem POS Library Cafe
                            </h2>
                            <p class="mt-2 text-gray-600">
                                Dokumentasi komprehensif seluruh modul dan fitur untuk Kasir, Admin, dan Finance.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-24">
                        
                        {{-- 1. Akses & Login --}}
                        <div id="akses-login">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary/10 text-primary text-sm font-bold">01</span>
                                <h3 class="text-2xl font-bold text-gray-900">Portal Akses & Login</h3>
                            </div>
                            <p class="text-gray-600 mb-8">Sistem ini memisahkan portal login berdasarkan peran untuk menjaga keamanan dan meminimalkan kebocoran data operasional.</p>

                            <div class="grid md:grid-cols-3 gap-8">
                                <div class="bg-slate-50 border border-slate-100 rounded-3xl p-8 hover:border-primary/20 transition-all duration-300">
                                    <div class="flex items-center gap-3 mb-6">
                                        <span class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white text-2xl text-primary shadow-sm border border-slate-100">
                                            <i class="fa-solid fa-cash-register"></i>
                                        </span>
                                        <h4 class="font-bold text-xl text-gray-900">Portal Kasir</h4>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-6 leading-relaxed">Halaman antarmuka Point of Sale (POS) cepat untuk mencatat pembelian pelanggan di kasir.</p>
                                    <ul class="space-y-3 text-sm text-gray-600 list-inside list-disc">
                                        <li>Alamat: <a href="/login" class="text-primary font-bold hover:underline">/login</a></li>
                                        <li>Hak Akses: Staf Kasir</li>
                                        <li>Tujuan: Melayani transaksi tunai & QRIS</li>
                                    </ul>
                                </div>

                                <div class="bg-slate-50 border border-slate-100 rounded-3xl p-8 hover:border-primary/20 transition-all duration-300">
                                    <div class="flex items-center gap-3 mb-6">
                                        <span class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white text-2xl text-primary shadow-sm border border-slate-100">
                                            <i class="fa-solid fa-user-shield"></i>
                                        </span>
                                        <h4 class="font-bold text-xl text-gray-900">Portal Admin</h4>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-6 leading-relaxed">Halaman utama administrator untuk manajemen master data produk, user, dan analisis stok.</p>
                                    <ul class="space-y-3 text-sm text-gray-600 list-inside list-disc">
                                        <li>Alamat: <a href="/admin/login" class="text-primary font-bold hover:underline">/admin/login</a></li>
                                        <li>Hak Akses: Administrator Utama</li>
                                        <li>Tujuan: Mengatur stok, produk, voucher, & user</li>
                                    </ul>
                                </div>

                                <div class="bg-slate-50 border border-slate-100 rounded-3xl p-8 hover:border-primary/20 transition-all duration-300">
                                    <div class="flex items-center gap-3 mb-6">
                                        <span class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white text-2xl text-primary shadow-sm border border-slate-100">
                                            <i class="fa-solid fa-file-invoice-dollar"></i>
                                        </span>
                                        <h4 class="font-bold text-xl text-gray-900">Portal Finance</h4>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-6 leading-relaxed">Dashboard keuangan untuk mencatat cash flow operasional dan mengaudit kinerja kasir.</p>
                                    <ul class="space-y-3 text-sm text-gray-600 list-inside list-disc">
                                        <li>Alamat: <a href="/finance/login" class="text-primary font-bold hover:underline">/finance/login</a></li>
                                        <li>Hak Akses: Staff Keuangan (Finance)</li>
                                        <li>Tujuan: Mengelola pengeluaran, pemasukan kas, & profit</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Modul Kasir --}}
                        <div id="modul-kasir">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary/10 text-primary text-sm font-bold">02</span>
                                <h3 class="text-2xl font-bold text-gray-900">Fitur & Modul Kasir</h3>
                            </div>
                            <p class="text-gray-600 mb-10">Berikut adalah daftar lengkap fitur yang dapat digunakan oleh Staf Kasir untuk kelancaran transaksi di toko:</p>

                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-chart-pie"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Dashboard Kasir</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Menampilkan ringkasan data harian seperti jumlah transaksi sukses yang dilayani kasir aktif dan total omzet rupiah hari ini.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-cart-shopping"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Layar Point of Sale (POS)</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Antarmuka belanja untuk memilih produk, mengatur kuantitas item, mencari menu dengan cepat, dan menyaring menu berdasarkan kategori.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-arrows-split-up-and-left"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Split Bill (Pecah Tagihan)</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Fitur opsional untuk membagi pesanan kelompok (group order) menjadi beberapa struk pembayaran terpisah sesuai permintaan konsumen.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-credit-card"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Transaksi QRIS & Cash</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Mendukung pembayaran Tunai (sistem menghitung uang kembalian) dan QRIS Statis. Pembayaran QRIS mewajibkan unggah berkas bukti transfer.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-eye-slash"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Kelola Ketersediaan Menu</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Kasir dapat menyembunyikan/menonaktifkan menu produk tertentu dari halaman POS secara instan jika bahan baku produk tersebut habis.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-clock-rotate-left"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Histori & Cetak Struk</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Menyimpan daftar transaksi kasir bersangkutan. Kasir dapat membuka detail item transaksi serta mencetak kembali nota struk belanja thermal.</p>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Modul Admin --}}
                        <div id="modul-admin">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary/10 text-primary text-sm font-bold">03</span>
                                <h3 class="text-2xl font-bold text-gray-900">Fitur & Modul Admin</h3>
                            </div>
                            <p class="text-gray-600 mb-10">Berikut adalah daftar lengkap fitur yang dapat dikelola oleh Administrator di panel belakang admin:</p>

                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-box"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Manajemen Produk</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Mengelola seluruh data katalog produk, mencakup SKU, nama menu, kategori, harga modal, harga jual, status ketersediaan, serta stok minimal.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-handshake-angle"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Bagi Hasil Konsinyasi</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Pengaturan bagi hasil untuk produk titipan produsen luar. Admin dapat mengatur potongan berupa nominal rupiah tetap atau persentase komisi.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-dolly"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Pasokan Stok Masuk</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Modul masuknya pasokan inventori baru. Admin mencatat nama pemasok, jumlah item masuk, harga beli/inbound, tanggal beli, beserta catatan.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-ticket-simple"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Voucher & Kupon Belanja</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Membuat kode promosi belanja dengan limit pemakaian, tanggal kedaluwarsa, nilai minimal belanja, dan batas maksimal diskon.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-users"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Manajemen User (Pengguna)</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Menambahkan akun staff, mengganti password staff, serta menentukan tingkat kewenangan pengguna (Admin, Finance, Kasir).</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-file-excel"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Ekspor excel & Riwayat</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Melihat seluruh transaksi secara global dan mengekspor data transaksi terfilter ke format spreadsheet Excel untuk pembukuan fisik.</p>
                                </div>
                            </div>
                        </div>

                        {{-- 4. Modul Finance --}}
                        <div id="modul-finance">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary/10 text-primary text-sm font-bold">04</span>
                                <h3 class="text-2xl font-bold text-gray-900">Fitur & Modul Finance</h3>
                            </div>
                            <p class="text-gray-600 mb-10">Berikut adalah daftar lengkap fitur yang dapat dioperasikan oleh Staf Keuangan untuk memantau performa finansial:</p>

                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-scale-balanced"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Pencatatan Arus Kas</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Pencatatan keuangan di luar transaksi POS, mencakup pemasukan (modal, sewa) dan pengeluaran (operasional, gaji staff, belanja bahan baku).</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-calculator"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Laporan Arus Kas & Laba</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Visualisasi performa kas berupa chart garis pendapatan bulanan, perbandingan modal masuk vs belanja keluar, serta total laba bersih.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-percent"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Laporan Margin Laba</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Menampilkan kalkulasi laba kotor, HPP (Harga Pokok Penjualan), margin profitabilitas produk, dan total penjualan bersih secara harian.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-warehouse"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Laporan Aset Inventori</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Laporan nilai total barang tersimpan di gudang berdasarkan harga modal produk untuk memantau nilai aset kafe saat ini.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-user-group"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Kinerja Akuntansi Kasir</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Menganalisis performa kerja kasir, meliputi jumlah transaksi terlayani, total omzet per kasir, rata-rata nominal belanja, dan kontribusi tunai/non-tunai.</p>
                                </div>

                                <div class="bg-white border border-slate-100 hover:border-primary/30 rounded-3xl p-8 transition-all duration-300 hover:shadow-sm">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-primary/5 text-primary text-xl mb-4"><i class="fa-solid fa-diagram-project"></i></span>
                                    <h4 class="font-bold text-lg text-gray-900 mb-2">Analisis Stok ABC-XYZ</h4>
                                    <p class="text-sm text-gray-600 leading-relaxed">Pengelompokan stok otomatis untuk memilah produk dengan kontribusi omzet tinggi dan tingkat kestabilan penjualan yang stabil.</p>
                                </div>
                            </div>
                        </div>

                        {{-- 5. FAQ --}}
                        <div id="faq">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary/10 text-primary text-sm font-bold">05</span>
                                <h3 class="text-2xl font-bold text-gray-900">Pertanyaan yang Sering Diajukan (FAQ)</h3>
                            </div>
                            <p class="text-gray-600 mb-8">Temukan solusi atas kendala dan pertanyaan operasional yang sering ditanyakan staff cafe.</p>

                            <div class="space-y-4">
                                
                                <details class="group bg-slate-50 border border-slate-100 rounded-3xl p-6 [&_summary::-webkit-details-marker]:hidden">
                                    <summary class="flex justify-between items-center font-bold text-gray-900 cursor-pointer text-lg list-none">
                                        <span>Bagaimana jika kasir salah menginput nominal uang Tunai saat checkout?</span>
                                        <span class="transition group-open:rotate-180 text-secondary/40">
                                            <i class="fa-solid fa-chevron-down text-sm"></i>
                                        </span>
                                    </summary>
                                    <div class="mt-4 text-sm text-gray-600 leading-relaxed border-t border-slate-200/60 pt-4">
                                        Kembalian otomatis dihitung secara akurat oleh sistem saat kasir mengisi nominal tunai. Jika transaksi telah diselesaikan (klik Bayar), data akan terkunci di menu histori dan tidak dapat diubah oleh kasir demi keamanan data keuangan. Jika terjadi kesalahan fatal, kasir harus segera berkoordinasi dengan Admin untuk melakukan audit data secara manual.
                                    </div>
                                </details>

                                <details class="group bg-slate-50 border border-slate-100 rounded-3xl p-6 [&_summary::-webkit-details-marker]:hidden">
                                    <summary class="flex justify-between items-center font-bold text-gray-900 cursor-pointer text-lg list-none">
                                        <span>Apakah bukti transfer QRIS wajib diunggah oleh kasir?</span>
                                        <span class="transition group-open:rotate-180 text-secondary/40">
                                            <i class="fa-solid fa-chevron-down text-sm"></i>
                                        </span>
                                    </summary>
                                    <div class="mt-4 text-sm text-gray-600 leading-relaxed border-t border-slate-200/60 pt-4">
                                        Ya, wajib. Untuk setiap transaksi dengan metode pembayaran QRIS, sistem mewajibkan kasir melampirkan file gambar bukti transfer. File ini akan tersimpan di sistem dan dapat dilihat langsung oleh Admin / Finance untuk mencocokkan mutasi kas.
                                    </div>
                                </details>

                                <details class="group bg-slate-50 border border-slate-100 rounded-3xl p-6 [&_summary::-webkit-details-marker]:hidden">
                                    <summary class="flex justify-between items-center font-bold text-gray-900 cursor-pointer text-lg list-none">
                                        <span>Bagaimana cara kerja sistem bagi hasil untuk produk titipan (konsinyasi)?</span>
                                        <span class="transition group-open:rotate-180 text-secondary/40">
                                            <i class="fa-solid fa-chevron-down text-sm"></i>
                                        </span>
                                    </summary>
                                    <div class="mt-4 text-sm text-gray-600 leading-relaxed border-t border-slate-200/60 pt-4">
                                        Pada menu tambah/edit produk, Anda dapat menandai produk sebagai "Konsinyasi". Tentukan besaran bagi hasil untuk produsen, baik dalam bentuk <strong class="font-bold">Nominal Rupiah</strong> maupun <strong class="font-bold">Persentase</strong>. Setiap kali produk tersebut terjual melalui POS, sistem akan mencatat pembagian keuntungan secara otomatis di latar belakang.
                                    </div>
                                </details>

                                <details class="group bg-slate-50 border border-slate-100 rounded-3xl p-6 [&_summary::-webkit-details-marker]:hidden">
                                    <summary class="flex justify-between items-center font-bold text-gray-900 cursor-pointer text-lg list-none">
                                        <span>Bagaimana Laporan Laba Bersih (Net Profit) dihitung oleh sistem?</span>
                                        <span class="transition group-open:rotate-180 text-secondary/40">
                                            <i class="fa-solid fa-chevron-down text-sm"></i>
                                        </span>
                                    </summary>
                                    <div class="mt-4 text-sm text-gray-600 leading-relaxed border-t border-slate-200/60 pt-4">
                                        Laba bersih diperoleh dari kalkulasi formula berikut: <br>
                                        <code class="block bg-white border border-slate-100 rounded-xl p-3 my-2 text-primary font-bold">Laba Bersih = (Total Penjualan POS + Pemasukan Arus Kas Lain) - (HPP Penjualan + Total Pengeluaran Kas)</code>
                                        Data ini tersaji secara transparan pada menu Laporan Cash Flow yang dapat diakses oleh Admin dan Finance.
                                    </div>
                                </details>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </main>

        <x-footer />
    </div>
</x-app-layout>