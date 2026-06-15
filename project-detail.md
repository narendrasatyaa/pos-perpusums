# Dokumentasi Proyek: Sistem Informasi POS & Analisis Inventori Library Cafe UPT Perpustakaan UMS

Dokumen ini berisi gambaran umum, arsitektur sistem, pembagian peran (*role*), rincian fitur, serta spesifikasi teknis dari sistem informasi Point of Sale (POS) Library Cafe UPT Perpustakaan UMS. Dokumen ini disusun untuk memudahkan presentasi dan detailisasi proyek kepada mentor/dosen pembimbing.

---

## 1. Gambaran Umum Proyek (Project Overview)

**Sistem Informasi POS & Analisis Inventori Library Cafe UPT Perpustakaan UMS** adalah sebuah platform berbasis web yang dirancang khusus untuk mendigitalisasi operasional transaksi penjualan, mengelola pasokan dan penyesuaian stok (inventarisasi), serta menyajikan analisis keuangan dan pergerakan stok yang komprehensif.

Sistem ini dikembangkan menggunakan framework **Laravel** dan panel administrasi **Filament v3**, dikombinasikan dengan halaman transaksi kasir (*front-end*) kustom yang responsif untuk menunjang kecepatan transaksi. Aplikasi ini mengimplementasikan keamanan tingkat tinggi dengan pembagian hak akses (*Role-Based Access Control*), pemisahan portal masuk (*multi-authentication*), serta fitur analitik mutakhir seperti **Analisis Klasifikasi ABC-XYZ**, penentuan **Status Gerak Barang** (Dead Stock/Slow Moving/Aktif), **Log Mutasi Stok** terpusat, serta kalkulasi otomatis **Bagi Hasil Konsinyasi** untuk produk titipan.

---

## 2. Arsitektur Pengguna & Akses (Multi-Role & Portal)

Sistem membagi pengguna ke dalam tiga peran (*roles*) dengan tanggung jawab dan portal akses yang berbeda guna menjaga keamanan serta akuntabilitas data operasional kafe:

| Peran (Role) | Portal Akses | Deskripsi & Tanggung Jawab |
| :--- | :--- | :--- |
| **Kasir** | `/login` atau `/akses` | Staf operasional yang mengoperasikan kasir harian, melayani transaksi belanja (Tunai/QRIS), melakukan *split bill*, dan mengelola ketersediaan menu secara cepat. |
| **Admin** | `/admin/login` | Administrator utama yang mengelola master data produk, kategori, pasokan stok masuk (*Stock Inbound*), penyesuaian stok (*Stock Adjustment*), log mutasi, manajemen voucher diskon, dan kredensial pengguna (*user management*). |
| **Finance** | `/finance/login` | Staf keuangan yang memantau arus kas (*cash flow*), laporan laba kotor & bersih, valuasi aset inventori, audit kasir, log mutasi, serta analisis klasifikasi stok. |

---

## 3. Fitur Utama Sistem Berdasarkan Modul

### A. Modul Kasir (Antarmuka Front-End POS)
Antarmuka kasir dirancang dengan mengutamakan kecepatan dan kemudahan akses (*user-friendly*) saat melayani pelanggan:
* **Dashboard Kasir**: Menampilkan indikator kinerja kasir hari ini (jumlah transaksi sukses dan total pendapatan rupiah).
* **Layar Transaksi POS (Point of Sale)**:
  * Pencarian produk cepat berdasarkan nama.
  * Filter produk berdasarkan kategori menu (makanan, minuman, snack, dll.).
  * Manajemen keranjang belanja (*shopping cart*) interaktif.
* **Split Bill (Pecah Tagihan)**: Fitur pembagian tagihan untuk memudahkan pelanggan dalam satu kelompok/meja yang ingin membayar pesanan mereka secara terpisah.
* **Metode Pembayaran Ganda**:
  * **Tunai (Cash)**: Sistem secara otomatis menghitung nominal kembalian berdasarkan uang yang diserahkan pelanggan.
  * **QRIS Statis**: Mendukung pembayaran non-tunai melalui kode QR, dengan validasi wajib mengunggah berkas/foto bukti transfer dari pelanggan untuk keperluan audit.
* **Toggle Ketersediaan Menu**: Kasir dapat langsung menyembunyikan produk dari layar pemesanan secara instan jika bahan baku produk tersebut habis di dapur/bar, tanpa perlu menunggu Admin memperbaruinya.
* **Riwayat Transaksi & Cetak Struk**:
  * Riwayat riil transaksi yang telah dilayani oleh kasir bersangkutan.
  * Cetak ulang struk belanja format thermal/PDF.
  * Penyediaan Struk dengan kode QR (*QR Code*) unik yang merujuk ke nota digital publik pelanggan.

### B. Modul Admin (Panel Manajemen & Master Data)
Digunakan oleh administrator untuk mengelola seluruh ekosistem data kafe melalui Filament Admin Panel:
* **Manajemen Produk (Catalog Management)**:
  * Pembuatan kode SKU (*Stock Keeping Unit*) otomatis berformat `PRD-XXXXXX`.
  * Pengaturan nama, kategori, harga modal, harga jual, stok minimum, dan satuan barang.
  * Pembedaan produk normal dan **produk konsinyasi** (titipan dari produsen luar).
* **Sistem Pasokan Stok Masuk (Stock Inbound)**:
  * Pencatatan stok baru yang masuk dari pemasok/supplier.
  * Otomatis meng-inkremen jumlah stok produk bersangkutan di gudang.
  * Otomatis memperbarui harga beli modal (HPP) produk non-konsinyasi berdasarkan harga pasokan terbaru.
* **Sistem Penyesuaian Stok (Stock Adjustment)**:
  * Memungkinkan admin mencatat penyesuaian manual terhadap stok fisik karena berbagai alasan seperti penyusutan/terbuang (*waste*), barang rusak (*damage*), koreksi tambah (+), atau koreksi kurang (-).
  * Otomatis meng-inkremen/dekremen stok produk terkait di database serta melacak tanggal penyesuaian dan petugas yang mencatat.
* **Log Mutasi Stok (Stock Mutation Audit Log)**:
  * Panel log audit pergerakan stok secara terpusat dan *read-only* (hanya bisa dibaca untuk mencegah manipulasi data).
  * Mencatat detail stok awal (*before*), perubahan jumlah (*change*), dan stok akhir (*after*) untuk setiap pergerakan stok (inbound, outbound penjualan POS, dan adjustment).
* **Manajemen Voucher & Kupon Promo**:
  * Pembuatan kode voucher diskon dengan tipe nominal tetap (Rp) maupun persentase (%).
  * Pengaturan masa berlaku voucher, batas minimal belanja, dan batas maksimal potongan diskon.
* **Manajemen Pengguna (User Management)**:
  * Pendaftaran akun staf baru, pengaturan password, serta penentuan *role* (Admin, Finance, Kasir).
* **Audit Transaksi Global & Ekspor**:
  * Monitoring riwayat transaksi kafe secara menyeluruh beserta dokumen bukti transfer pembayaran QRIS.
  * Fitur ekspor data transaksi ke spreadsheet Excel untuk keperluan dokumentasi fisik.

### C. Modul Finance (Panel Keuangan, Audit & Analitik)
Menyediakan laporan akuntansi dan analitik untuk memantau performa kesehatan bisnis kafe:
* **Pencatatan Arus Kas Non-POS (Cash Flow Ledger)**:
  * Pencatatan pemasukan di luar POS (seperti modal tambahan, penyewaan lapak, dll.).
  * Pencatatan pengeluaran operasional (seperti belanja bahan baku, pembayaran gaji karyawan, biaya listrik/air).
* **Laporan Arus Kas & Tren Finansial**:
  * Rangkuman total penjualan, kas masuk lainnya, pengeluaran kas, laba bersih, serta visualisasi bagan tren kas bulanan.
* **Laporan Margin Laba (Profit & Margin Report)**:
  * Perhitungan detail laba kotor dan laba bersih per transaksi.
  * Integrasi HPP otomatis untuk mendeteksi kontribusi keuntungan per menu.
* **Laporan Kinerja Akuntansi Kasir**:
  * Audit performa staf kasir meliputi jumlah transaksi yang ditangani, kontribusi omzet rupiah, rata-rata belanja per struk, serta rasio pembayaran tunai vs non-tunai.
* **Laporan Nilai Aset Gudang (Inventory Valuation)**:
  * Menghitung total nilai aset barang yang mengendap di gudang/kafe saat ini berdasarkan harga modal produk untuk memantau nilai aset fisik.
* **Log Mutasi Stok (Monitoring)**:
  * Memungkinkan staf finance memantau pergerakan masuk-keluar stok demi validitas valuasi aset dan audit selisih persediaan.

---

## 4. Fitur Unggulan Lanjutan (Advanced Features)

### A. Analisis Klasifikasi Stok ABC-XYZ
Fitur analitik inventori mutakhir untuk membantu mengoptimalkan manajemen rantai pasok kafe agar terhindar dari *out-of-stock* (kehabisan stok) maupun *dead-stock* (penumpukan barang tak laku). Fitur ini mengkombinasikan dua metode analisis:

1. **ABC Analysis** (Mengelompokkan produk berdasarkan kontribusi omzet/pendapatan):
   Produk diurutkan berdasarkan kontribusi pendapatan dari yang terbesar ke terkecil selama periode tertentu, lalu diklasifikasikan dengan ketentuan:
   * **Kelas A (Prioritas Utama)**: Produk yang menyumbang akumulasi omzet kumulatif **$\le$ 80%** dari total omzet kafe (sedikit jenis produk tapi bernilai tinggi).
   * **Kelas B (Prioritas Sedang)**: Produk berikutnya yang menyumbang akumulasi omzet kumulatif **80% s/d 95%** berikutnya.
   * **Kelas C (Prioritas Terendah)**: Produk-produk sisa yang menyumbang sisa akumulasi omzet **95% s/d 100%**, atau produk yang sama sekali tidak ada penjualan.

2. **XYZ Analysis** (Mengelompokkan produk berdasarkan kestabilan/volatilitas permintaan):
   Didasarkan pada perhitungan **Koefisien Variasi (CV)** kuantitas penjualan per interval waktu (harian jika rentang analisis $\le$ 14 hari, atau mingguan jika > 14 hari):
   $$\text{CV} = \frac{\text{Standar Deviasi penjualan}}{\text{Rata-rata penjualan}}$$
   Kategorinya diatur sebagai berikut:
   * **Kelas X (Stabil)**: Produk dengan nilai CV **$\le$ 0.20 (20%)**. Permintaan sangat stabil dan mudah diprediksi.
   * **Kelas Y (Fluktuatif)**: Produk dengan nilai CV antara **0.20 s/d 0.50 (50%)**. Permintaan berfluktuasi namun polanya masih dapat diprediksi (misalnya musiman).
   * **Kelas Z (Sangat Volatil/Sporadis)**: Produk dengan nilai CV **> 0.50 (50%)** atau tidak terjual sama sekali. Pola penjualan sangat acak dan sulit diprediksi.

3. **Matriks Kombinasi & Rekomendasi Kebijakan Otomatis**:
   Sistem menghasilkan matriks 3x3 (AX hingga CZ) beserta saran kebijakan stok bagi pengelola:
   * **AX / AY / BX**: Prioritas utama. Disarankan kontrol stok ketat, *safety stock* rendah hingga sedang, dan reorder otomatis.
   * **AZ / BZ**: Prioritas tinggi/sedang namun sporadis. Disarankan menyiapkan *safety stock* yang tinggi untuk mencegah kehabisan saat terjadi lonjakan permintaan mendadak.
   * **CX / CY**: Prioritas rendah. Disarankan order dalam jumlah banyak sekaligus guna meminimalkan ongkos kirim.
   * **CZ**: Prioritas terendah. Disarankan menggunakan skema *Just-In-Time* (hanya dibeli jika stok benar-benar habis atau ada pesanan khusus) untuk mengurangi modal mengendap.

### B. Status Gerak Barang (*Movement Status*)
Kategori perputaran barang untuk mempermudah monitoring kelayakan stok:
* **Dead Stock (Stok Mati)**: Produk yang tidak pernah terjual sama sekali **ATAU** penjualan terakhirnya tercatat lebih dari **60 hari yang lalu**.
* **Slow Moving (Lambat Berputar)**: Produk yang terjual **kurang dari 5 unit** dalam kurun waktu **30 hari terakhir**.
* **Aktif (Cepat Berputar)**: Produk yang terjual **5 unit atau lebih** dalam kurun waktu **30 hari terakhir** (dan memiliki transaksi dalam 60 hari terakhir).

### C. Skema Bagi Hasil Konsinyasi (Consignment Profit Sharing)
Sistem memiliki kalkulator bagi hasil internal yang andal untuk mengelola produk titipan (konsinyasi) dari pihak ketiga (consignor):
* **Tipe Bagi Hasil Dinamis**: Mendukung bagi hasil bertipe **Nominal Tetap** (misalnya, produsen mendapat Rp 5.000 per produk terjual) maupun **Persentase Komisi** (misalnya, produsen mendapat 70% dari harga jual, sedangkan kafe mendapat komisi 30%).
* **Kalkulasi Keuntungan Otomatis**: Saat kasir memproses transaksi produk konsinyasi melalui POS, sistem akan secara otomatis memecah pendapatan penjualan menjadi hak produsen dan laba bersih kafe secara *real-time* di latar belakang.

### D. Kalkulasi HPP & Ketahanan Data Historis
* **Produk Normal**: HPP diperoleh secara dinamis berdasarkan harga modal terakhir yang diinput melalui menu *Stock Inbound*.
* **Produk Konsinyasi**: HPP dihitung otomatis berdasarkan hak bayar produsen (baik secara nominal maupun persentase bagi hasil).
* **Ketahanan Data Historis**: Setiap transaksi POS yang berhasil akan menyimpan HPP dan harga jual historis di tabel detail transaksi (`transaction_items`). Hal ini menjamin laporan keuangan masa lalu tetap akurat walaupun di masa depan terjadi perubahan harga modal maupun harga jual produk di master data.

---

## 5. Spesifikasi Teknis & Model Database (Tech Stack)

### A. Teknologi Pendukung (Tech Stack)
* **Framework Back-End**: Laravel 10/11 (PHP)
* **Engine Panel**: Filament v3 (TET-oriented framework untuk antarmuka Admin & Finance yang dinamis, cepat, dan modern)
* **Front-End Kasir**: Tailwind CSS, HTML5, Alpine.js, Vanilla Javascript
* **Database**: MySQL (Relational Database)
* **Paket Tambahan (Packages)**:
  * `maatwebsite/excel`: Pemrosesan dan ekspor laporan ke format Excel (`.xlsx`).
  * `chillerlan/php-qrcode`: Render kode QR dinamis berformat SVG untuk struk digital.
  * `laravel/fortify`: Autentikasi pengguna secara aman.

### B. Relasi Database (Skema Model)
Sistem memiliki arsitektur data terstruktur dengan relasi model utama berikut:

1. **User**: Menyimpan data kredensial staf beserta *role*-nya (Admin, Finance, Kasir).
2. **Category**: Pengelompokan jenis produk.
3. **Product**: Menyimpan katalog menu, stok saat ini, batas stok minimal, harga jual, harga beli modal (HPP), status ketersediaan, serta konfigurasi konsinyasi.
4. **StockInbound**: Pencatatan riwayat stok masuk, berelasi dengan `Product` (produk yang di-restock) dan `User` (staf yang menginput).
5. **StockAdjustment**: Mencatat data penyesuaian manual (barang rusak, waste, koreksi opname) berelasi dengan `Product` dan `User`.
6. **StockMutation**: Log audit trail pergerakan stok (inbound, outbound, adjustment) dengan relasi polymorphic ke model referensi (`reference_id`, `reference_type`).
7. **Transaction**: Menyimpan kepala transaksi (kode order, total belanja, potongan voucher, nominal bayar, kembalian, metode pembayaran, bukti transfer, waktu bayar, dan status transaksi).
8. **TransactionItem**: Menyimpan rincian produk yang dibeli pada setiap transaksi, menyimpan harga jual historis dan harga modal historis (HPP) agar laporan profit masa lalu tidak berubah meskipun harga produk diubah di masa depan.
9. **Voucher**: Menyimpan data kode promo diskon beserta aturan validitasnya.
10. **CashFlow**: Pencatatan mutasi kas non-POS (jenis masuk/keluar, nominal, kategori, deskripsi, tanggal).

---
*Dokumen ini diperbarui selaras dengan kode program aktual pada sistem POS Library Cafe UPT Perpustakaan UMS.*