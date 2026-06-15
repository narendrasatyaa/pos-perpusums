# Panduan Penggunaan Sistem POS & Analisis Inventori Library Cafe UPT Perpustakaan UMS

Dokumen ini berisi panduan operasional langkah-demi-langkah (*user guide*) untuk setiap fitur dalam aplikasi berdasarkan peran pengguna (**Kasir**, **Admin**, dan **Finance**).

---

# 1. PANDUAN MODUL KASIR
Halaman utama kasir diakses melalui URL: `/login` (menggunakan akun ber-role **Kasir**).

## A. Dashboard Kasir
* **Tujuan Fitur**: Memberikan ringkasan pencapaian penjualan kasir yang sedang bertugas hari ini.
* **Lokasi Halaman**: Halaman utama setelah login kasir (`/` atau `/dashboard`).
* **Cara Penggunaan**:
  1. Setelah login, kasir akan langsung melihat dua kartu indikator utama:
     * **Jumlah Transaksi**: Total pesanan yang berhasil dilayani hari ini.
     * **Total Pendapatan**: Total omzet rupiah dari transaksi yang ditangani hari ini.
  2. Data ini di-reset otomatis setiap hari dan hanya menampilkan kinerja kasir yang sedang aktif (*personal log*).

## B. Layar POS & Pemesanan (Transaksi Baru)
* **Tujuan Fitur**: Membuat pesanan, memasukkan menu ke keranjang belanja, dan memproses transaksi pelanggan.
* **Lokasi Halaman**: Menu **Transaksi POS** (`/kasir/transaksi`).
* **Cara Penggunaan**:
  1. Gunakan kotak **Pencarian Produk** di bagian atas untuk mengetikkan nama menu (misal: "Kopi Susu").
  2. Gunakan **Filter Kategori** (Makanan, Minuman, Snack) untuk mempersempit daftar menu.
  3. Klik pada kartu produk untuk menambahkannya ke **Keranjang Belanja** (*Shopping Cart*) di sebelah kanan layar.
  4. Di dalam keranjang, Anda dapat menambah/mengurangi jumlah produk dengan tombol `+` atau `-`, atau menghapus item dengan ikon tempat sampah.

## C. Split Bill (Pecah Tagihan)
* **Tujuan Fitur**: Membagi pesanan dari satu meja ke dalam beberapa struk pembayaran yang berbeda secara fleksibel.
* **Lokasi Halaman**: Tombol **Split Bill** di dalam keranjang belanja pada layar POS.
* **Cara Penggunaan**:
  1. Klik tombol **Split Bill** setelah semua menu yang dipesan meja tersebut dimasukkan ke dalam keranjang.
  2. Sistem akan membuka modal *Split Bill*.
  3. Klik menu mana saja yang akan dipisah ke struk pertama (Struk A), dan tentukan jumlah kuantitasnya.
  4. Klik tombol **Proses Pembayaran A** untuk membayar bagian tagihan pertama.
  5. Setelah selesai, bayar sisa menu yang tertinggal di keranjang utama (Struk B), atau lakukan split kembali jika ingin dipecah ke struk C.

## D. Proses Pembayaran (Tunai & QRIS Statis)
* **Tujuan Fitur**: Menyelesaikan transaksi pembayaran pelanggan dengan opsi metode pembayaran Tunai atau non-tunai (QRIS).
* **Lokasi Halaman**: Tombol **Bayar / Checkout** di keranjang belanja POS.
* **Cara Penggunaan**:
  1. Klik tombol **Bayar**.
  2. Jika pelanggan membawa voucher diskon, ketikkan kode kupon di input **Kode Voucher** lalu klik **Terapkan**.
  3. Pilih metode pembayaran:
     * **Tunai**: Masukkan nominal uang yang diserahkan pelanggan. Sistem secara otomatis menghitung uang kembalian di bawahnya.
     * **QRIS Statis**: Tunjukkan kode QR statis kafe di meja kasir. Pelanggan memindai dan melakukan transfer. Kasir wajib mengambil foto bukti transfer sukses dan mengunggahnya pada kolom **Unggah Bukti Transfer**.
  4. Klik **Simpan & Cetak Struk**.

## E. Toggle Ketersediaan Menu
* **Tujuan Fitur**: Menyembunyikan menu makanan/minuman dari layar POS secara instan apabila bahan baku di dapur/bar habis.
* **Lokasi Halaman**: Menu **Ketersediaan Menu** (`/kasir/menu-status`).
* **Cara Penggunaan**:
  1. Cari nama produk yang ingin dinonaktifkan.
  2. Klik tombol *switch* / sakelar ketersediaan dari posisi **Tersedia (Hijau)** ke **Habis (Merah)**.
  3. Menu tersebut akan otomatis menghilang dari daftar pemesanan kasir, sehingga pelanggan tidak dapat memesannya sementara waktu. Aktifkan kembali sakelar jika bahan baku sudah siap.

## F. Riwayat Transaksi Kasir & Cetak Ulang Struk
* **Tujuan Fitur**: Melihat transaksi yang pernah dilayani hari ini dan mencetak kembali struk pembayaran jika dibutuhkan.
* **Lokasi Halaman**: Menu **Riwayat Transaksi** (`/kasir/riwayat`).
* **Cara Penggunaan**:
  1. Cari transaksi berdasarkan **Kode Order** (`ORD-XXXXXX`) atau nama produk.
  2. Klik tombol **Detail** untuk melihat daftar item yang dibeli, diskon voucher, dan metode pembayaran.
  3. Klik **Cetak Struk** untuk mengirim perintah cetak ke printer termal, atau unduh sebagai PDF.
  4. Di struk tersebut terdapat **QR Code Nota Digital**. Pelanggan dapat memindai QR tersebut dengan ponsel mereka untuk melihat nota versi digital publik di web tanpa perlu login.

---

# 2. PANDUAN MODUL ADMIN
Halaman utama diakses melalui URL: `/admin/login` (menggunakan akun ber-role **Admin**).

## A. Manajemen Produk (Catalog Management)
* **Tujuan Fitur**: Mengelola master produk, harga jual, HPP, tipe produk konsinyasi, dan batas stok minimum.
* **Lokasi Halaman**: Sidebar menu **Manajemen Produk** $\rightarrow$ **Produk** (`/admin/products`).
* **Cara Penggunaan**:
  1. Klik **Buat Produk Baru** (*Create Product*).
  2. Isi kolom data produk:
     * **Nama Produk**, **Kategori**, **Harga Jual**, **Stok Awal**, dan **Satuan** (contoh: Pcs, Botol).
     * **Batas Stok Minimum**: Berfungsi untuk memicu indikator peringatan stok menipis.
  3. Tentukan jenis produk:
     * **Normal**: Masukkan nilai Harga Beli (HPP) awal.
     * **Konsinyasi**: Aktifkan centang konsinyasi, pilih tipe bagi hasil (*Nominal* atau *Persentase*) dan masukkan nominal hak produsen (misal: 7000 untuk bagi hasil Rp 7.000 per pcs, atau 70 untuk komisi bagi hasil 70% produsen - 30% kafe).
  4. Klik **Simpan**. Kode SKU (`PRD-XXXXXX`) akan digenerate otomatis oleh sistem.

### Fitur Impor Produk via Excel
* **Tujuan Fitur**: Memasukkan data produk dalam jumlah besar secara cepat dari dokumen spreadsheet Excel.
* **Langkah-langkah Penggunaan**:
  1. Klik tombol **Template Excel** di bagian atas halaman daftar produk untuk mengunduh template spreadsheet `.xlsx` resmi.
  2. Buka berkas template tersebut, lalu isi data katalog produk kamu pada kolom yang disediakan.
  3. > [!IMPORTANT]
     > **Aturan Kategori:** Pastikan nama kategori yang ditulis di kolom **Kategori** pada Excel **sudah terdaftar terlebih dahulu** di master data kategori sistem (Sidebar: **Manajemen Produk** $\rightarrow$ **Kategori**). Sistem tidak membuat kategori baru secara otomatis. Jika ada nama kategori baru yang belum dibuat di sistem, proses impor Excel akan dibatalkan/ditolak dengan pesan eror.
  4. Simpan dokumen Excel yang sudah kamu isi.
  5. Klik tombol **Import Excel** di halaman daftar produk, unggah berkas Excel tersebut pada form yang disediakan, lalu klik **Upload**.
  6. Sistem akan otomatis memvalidasi dan menyimpan seluruh produk ke dalam katalog database.

## B. Stok Masuk (Stock Inbound)
* **Tujuan Fitur**: Mencatat pasokan barang yang masuk dari supplier untuk menaikkan stok produk dan memperbarui HPP secara otomatis.
* **Lokasi Halaman**: Sidebar menu **Manajemen Stok** $\rightarrow$ **Stok Masuk** (`/admin/stock-inbounds`).
* **Cara Penggunaan**:
  1. Klik **Tambah Stok Masuk** (*Create Stock Inbound*).
  2. Pilih **Nama Produk** yang dipasok. Sistem otomatis memuat HPP terakhir produk tersebut di kolom Harga Modal.
  3. Masukkan **Jumlah Masuk** (Kuantitas) dan perbarui kolom **Harga Modal / Unit (Supplier)** jika terdapat kenaikan/penurunan harga dari supplier.
  4. Masukkan **Nama Supplier** dan **Tanggal Terima**.
  5. Tambahkan **Catatan** jika ada (misal: "Barang promo beli 10 gratis 1").
  6. Klik **Simpan**. Sistem otomatis menambah stok produk terkait di katalog dan mengubah HPP master produk normal ke harga beli masuk terbaru.

## C. Penyesuaian Stok (Stock Adjustment)
* **Tujuan Fitur**: Melakukan koreksi stok secara manual apabila terjadi selisih jumlah barang di lapangan atau kerusakan barang.
* **Lokasi Halaman**: Sidebar menu **Manajemen Stok** $\rightarrow$ **Penyesuaian Stok** (`/admin/stock-adjustments`).
* **Cara Penggunaan**:
  1. Klik **Tambah Penyesuaian Stok** (*Create Stock Adjustment*).
  2. Pilih **Produk** yang akan disesuaikan.
  3. Pilih **Tipe Penyesuaian**:
     * *Waste*: Penyusutan bahan baku/terbuang (stok produk akan berkurang).
     * *Damage*: Barang rusak/pecah (stok produk akan berkurang).
     * *Koreksi Tambah*: Menambah stok karena selisih lebih saat opname (stok produk akan bertambah).
     * *Koreksi Kurang*: Mengurangi stok karena selisih kurang saat opname (stok produk akan berkurang).
  4. Masukkan **Jumlah / Qty** penyesuaian (selalu isi dengan angka positif, sistem akan mengurus operasi tambah/kurangnya secara otomatis berdasarkan tipe yang dipilih).
  5. Isi **Tanggal** dan tulis alasan detail pada kolom **Catatan / Keterangan** (contoh: "1 botol sirup pecah disenggol karyawan").
  6. Klik **Simpan**.

## D. Log Mutasi Stok (Audit Trail)
* **Tujuan Fitur**: Memeriksa riwayat lengkap seluruh pergerakan keluar-masuk stok barang demi keamanan data log persediaan.
* **Lokasi Halaman**: Sidebar menu **Manajemen Stok** $\rightarrow$ **Log Mutasi Stok** (`/admin/stock-mutations`).
* **Cara Penggunaan**:
  1. Halaman ini bersifat **Read-Only** (hanya dibaca, tidak ada tombol buat/ubah/hapus) untuk memastikan integritas data.
  2. Anda dapat melihat mutasi kronologis berdasarkan waktu (`Tanggal & Waktu`).
  3. Perhatikan kolom:
     * **Jenis Gerak**: Menunjukkan sumber mutasi (`Stok Masuk`, `Penjualan POS`, atau `Penyesuaian`).
     * **Perubahan**: Angka dengan tanda plus/minus (misal: `+15` untuk inbound, `-2` untuk penjualan/waste).
     * **Stok Awal & Akhir**: Menunjukkan posisi stok sebelum dan sesudah mutasi terjadi.
  4. Gunakan filter di sebelah kanan untuk menyaring mutasi per produk atau berdasarkan rentang tanggal tertentu.

## E. Manajemen Voucher & Promo
* **Tujuan Fitur**: Membuat kode diskon belanja yang dapat digunakan kasir untuk memotong total belanja pelanggan.
* **Lokasi Halaman**: Sidebar menu **Manajemen Produk** $\rightarrow$ **Voucher** (`/admin/vouchers`).
* **Cara Penggunaan**:
  1. Klik **Buat Voucher Baru**.
  2. Masukkan **Kode Voucher** (contoh: `DISKONKOPI`), **Nama Promo**, dan **Tipe Diskon** (Nominal Rupiah atau Persentase).
  3. Masukkan **Nilai Diskon** (misal: `5000` untuk diskon Rp 5.000 atau `10` untuk diskon 10%).
  4. Tentukan **Batas Diskon Maksimal** (jika menggunakan tipe persentase) dan **Batas Minimal Belanja** (syarat nominal belanja agar voucher aktif).
  5. Isi tanggal masa berlaku (**Mulai Tanggal** dan **Sampai Tanggal**).
  6. Klik **Simpan**.

## F. Audit Transaksi Global
* **Tujuan Fitur**: Memantau seluruh transaksi penjualan kafe secara komprehensif dan mengekspor datanya ke laporan Excel.
* **Lokasi Halaman**: Sidebar menu **Laporan Penjualan** $\rightarrow$ **Transaksi** (`/admin/transactions`).
* **Cara Penggunaan**:
  1. Admin dapat memantau status pembayaran (`Paid` / `Unpaid`).
  2. Untuk transaksi QRIS, klik tombol **Lihat** untuk memeriksa keabsahan foto bukti transfer yang diunggah kasir.
  3. Untuk mengekspor laporan penjualan ke Excel, gunakan fitur filter tanggal (jika ada), lalu pilih opsi **Ekspor Excel** di bagian atas tabel.

---

# 3. PANDUAN MODUL FINANCE
Halaman utama diakses melalui URL: `/finance/login` (menggunakan akun ber-role **Finance**).

## A. Pencatatan Arus Kas Non-POS (Cash Flow Ledger)
* **Tujuan Fitur**: Mencatat mutasi kas operasional kafe di luar transaksi POS penjualan untuk memantau neraca keuangan kafe secara riil.
* **Lokasi Halaman**: Sidebar menu **Keuangan & Kas** $\rightarrow$ **Arus Kas** (`/finance/cash-flows`).
* **Cara Penggunaan**:
  1. Klik **Tambah Arus Kas** (*Create Cash Flow*).
  2. Pilih **Tipe Transaksi**:
     * **Pemasukan**: Uang masuk di luar POS (misal: sewa meja luar oleh mitra, modal tambahan).
     * **Pengeluaran**: Operasional belanja bahan mentah, bayar listrik, gaji barista, sewa tempat, dll.
  3. Masukkan **Kategori**, **Nominal (Rupiah)**, **Tanggal Transaksi**, dan **Keterangan**.
  4. Klik **Simpan**. Data ini akan otomatis diolah ke dalam grafik tren arus kas bulanan.

## B. Laporan Finansial & Margin Laba
* **Tujuan Fitur**: Menganalisis keuntungan kotor dan keuntungan bersih kafe per produk maupun per transaksi berdasarkan HPP historis.
* **Lokasi Halaman**: Menu **Laporan Margin Laba** atau Dashboard Finance.
* **Cara Penggunaan**:
  1. Dashboard Finance akan menyajikan visualisasi ringkasan margin HPP vs penjualan.
  2. Sistem otomatis mengurangi pendapatan kotor (harga jual $\times$ quantity) dengan modal (HPP $\times$ quantity) dan potongan voucher untuk menghasilkan angka laba bersih secara *real-time*.

## C. Laporan Nilai Aset Gudang (Inventory Valuation)
* **Tujuan Fitur**: Mengetahui valuasi nominal (rupiah) aset barang/menu yang saat ini masih tersimpan di dalam kafe.
* **Lokasi Halaman**: Widget **Valuasi Aset Gudang** di Dashboard Finance.
* **Cara Penggunaan**:
  1. Sistem otomatis mengalikan stok akhir setiap produk yang ada di gudang dengan Harga Pokok Penjualan (HPP) terakhir produk tersebut.
  2. Hasil total nilai seluruh aset rupiah ditampilkan secara langsung di kartu metrik dashboard sebagai acuan laporan nilai kekayaan fisik persediaan kafe.

## D. Analisis Klasifikasi ABC-XYZ
* **Tujuan Fitur**: Menganalisis prioritas pengelolaan stok produk berdasarkan omzet (ABC) dan stabilitas penjualan (XYZ).
* **Lokasi Halaman**: Sidebar menu **Manajemen Stok** $\rightarrow$ **Analisis & Klasifikasi** (`/finance/analisis-stok` atau `/admin/analisis-stok`).
* **Cara Penggunaan**:
  1. Tentukan **Jangka Waktu Analisis** (pilihan default: 30 Hari, 60 Hari, 90 Hari, atau Rentang Kustom). Sistem akan menghitung omzet penjualan dan menghitung standar deviasi kuantitas penjualan per interval waktu.
  2. Di bagian atas halaman terdapat **Grid Matriks ABC-XYZ (AX hingga CZ)** yang menunjukkan jumlah produk dalam setiap kelas.
  3. **Cara Membaca Filter Grid**: Klik pada salah satu kotak matriks (misal kotak **AX**). Tabel di bawahnya otomatis hanya akan menampilkan produk-produk yang masuk klasifikasi AX.
  4. Baca kolom **Rekomendasi Kebijakan**:
     * Jika produk masuk kategori **AX/AY/BX** (Prioritas Utama): Segera lakukan pemesanan ulang karena produk ini menyumbang omzet tinggi dengan penjualan stabil.
     * Jika produk masuk kategori **CZ** (Prioritas Terendah): Jangan menimbun produk ini. Terapkan skema order *Just-In-Time* hanya jika ada pesanan khusus agar modal tidak mengendap di barang mati.
  5. Klik tombol **Ekspor Excel** untuk mengunduh laporan analisis ABC-XYZ lengkap dalam format dokumen lembar kerja `.xlsx`.

---

# 4. PANDUAN LOG AKTIVITAS (AUDIT TRAIL)
Halaman utama diakses melalui URL: `/admin/activity-logs` (menggunakan akun ber-role **Admin**).

## A. Pemantauan Log Aktivitas
* **Tujuan Fitur**: Memeriksa rekaman lengkap jejak aktivitas pengguna di dalam sistem demi keamanan, akuntabilitas, dan pencegahan manipulasi data.
* **Lokasi Halaman**: Sidebar menu **Log Aktivitas** $\rightarrow$ **Log Aktivitas** (`/admin/activity-logs`).
* **Data yang Dilacak (What is Tracked)**:
  Sistem secara otomatis merekam setiap perubahan data pada model-model berikut:
  1. **User (Pengguna)**: Pendaftaran akun baru, penyuntingan data staf/role, atau penghapusan staf.
  2. **Product (Master Produk)**: Penambahan menu baru, penyuntingan harga jual/beli, status ketersediaan, atau penghapusan produk.
  3. **Stock Inbound (Stok Masuk)**: Penginputan pasokan barang masuk dari supplier.
  4. **Stock Adjustment (Penyesuaian Stok)**: Penginputan koreksi persediaan manual (waste, damage, koreksi +/-).
  5. **Transaction (Transaksi Penjualan)**: Pembuatan pesanan POS harian dan pembayaran tagihan.

  Setiap baris log mencatat informasi mendetail sebagai berikut:
  * **Pengguna**: Nama staf yang melakukan perubahan (jika otomatis, tercatat sebagai `System`).
  * **Aktivitas**: Jenis aksi (`create`, `update`, `delete`).
  * **Modul**: Nama tabel/model yang mengalami perubahan.
  * **Deskripsi**: Ringkasan aktivitas dalam bahasa manusia (contoh: *"Mengubah data Product: 'Kopi Susu'"*).
  * **Alamat IP**: IP Address perangkat yang digunakan saat mengakses sistem.
  * **Waktu**: Tanggal dan jam presisi terjadinya aktivitas.
  * **Detail Nilai Sebelum & Sesudah**: Perbandingan detail data sebelum diubah dan setelah diubah.

* **Cara Penggunaan**:
  1. Buka halaman **Log Aktivitas**. Halaman ini bersifat **Read-Only** (tidak ada opsi tambah/ubah/hapus) untuk memastikan data log tidak dapat dimanipulasi.
  2. Gunakan **Filter Pengguna** untuk melihat log aktivitas khusus dari staf tertentu.
  3. Gunakan **Filter Modul** untuk memantau perubahan data pada modul tertentu (misalnya, hanya melihat perubahan master produk).
  4. Gunakan **Filter Rentang Tanggal** (Dari Tanggal s/d Sampai Tanggal) untuk membatasi rentang pencarian log.
  5. Klik tombol **Lihat Detail** pada baris log yang ingin diperiksa. Sistem akan menampilkan jendela modal berisi detail informasi log beserta perbandingan **Nilai Sebelum Perubahan** (Data Lama) dan **Nilai Sesudah Perubahan** (Data Baru) dalam format pasangan kunci-nilai (*key-value*).
