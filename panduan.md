# Panduan Lengkap Sistem Informasi POS Library Cafe (Perpus UMS)

Sistem Informasi POS ini dirancang dengan Laravel dan Filament untuk mengelola penjualan, inventaris, dan memberikan analitik komprehensif. Panduan ini disusun **berdasarkan fitur aktual yang ada pada kode sistem**.

---

## 1. Hak Akses dan Jalur Login
Sistem ini memiliki multi-otentikasi berdasarkan peran (Role):
- **Kasir**: Mengelola operasional penjualan harian. Login melalui `/login` atau halaman `/akses`.
- **Admin**: Mengelola master data dan memonitor seluruh aktivitas bisnis. Login melalui `/admin/login`.
- **Finance**: Panel khusus keuangan (akses melalui `/finance/login`).

---

## 2. Panduan Penggunaan - Role Admin (Panel Filament)

Admin memiliki akses ke dasbor manajemen pusat (Akses di `/admin`).

### A. Dasbor Analitik (Dashboard)
Saat Admin masuk, sistem menampilkan analitik terpusat yang meliputi:
- **Statistik Utama**: Total penjualan hari ini, jumlah transaksi, dll.
- **Grafik Penjualan**: Memantau tren pendapatan.
- **Produk Terlaris**: Menampilkan produk yang paling sering dibeli.
- **Peringatan Stok Menipis (Low Stock)**: Menampilkan daftar barang yang perlu segera di-*restock*.

### B. Kelola Katalog (Produk & Kategori)
- **Kategori**: Mengelompokkan produk (misal: Minuman, Makanan, Snack).
- **Produk**: Menambah barang baru, mengatur Harga, Stok awal, dan Kategori. Admin memegang kendali penuh atas stok gudang.

### C. Kelola Transaksi & Keuangan
- **Voucher**: Membuat kode promo diskon. Terdapat pengaturan *Tipe Diskon* (Nominal/Persentase), batas minimum belanja, dan masa berlaku.
- **Riwayat Transaksi**: Admin dapat melihat, memfilter, dan mengaudit semua transaksi dari seluruh Kasir. Termasuk memvalidasi bukti transfer untuk pembayaran QRIS.

### D. Manajemen Pengguna (Users)
- Menambahkan akun untuk pegawai baru (Kasir atau Admin lainnya).
- Melakukan reset password atau menonaktifkan akun pegawai yang sudah tidak aktif.

---

## 3. Panduan Penggunaan - Role Kasir (Antarmuka Kasir)

Kasir menggunakan antarmuka khusus yang dirancang untuk kecepatan transaksi (Akses di `/kasir`).

### A. Dashboard Kasir
Menampilkan rangkuman performa *shift* kasir hari ini, termasuk:
- Jumlah Transaksi Hari Ini.
- Total Pendapatan Kasir Hari Ini.
- Rangkuman total produk dan kategori yang aktif.

### B. Transaksi POS (Order & Pembayaran)
- **Halaman Pesanan (`/kasir/order`)**: Kasir dapat mencari produk menggunakan kotak pencarian atau memfilter berdasarkan kategori. Produk diklik untuk masuk ke keranjang.
- **Split Bill (`/kasir/split-bill`)**: Fitur untuk membagi tagihan jika pelanggan datang berkelompok dan ingin membayar secara terpisah.
- **Proses Pembayaran**:
  - **Voucher**: Kasir dapat memasukkan kode voucher pelanggan, sistem akan otomatis menghitung diskon.
  - **Metode Pembayaran**: Terdapat opsi pembayaran Tunai (sistem otomatis menghitung kembalian) atau QRIS Static.
  - Untuk QRIS, kasir wajib memeriksa dan bisa mengunggah foto bukti transfer dari pelanggan.

### C. Manajemen Ketersediaan Produk Kasir (`/kasir/stok`)
Fitur kontrol cepat bagi kasir. Jika ada menu yang bahan bakunya habis di bar/dapur, kasir dapat langsung menekan tombol *Toggle* Ketersediaan, sehingga menu tersebut otomatis hilang dari layar pemesanan tanpa harus menunggu Admin mengubahnya di sistem pusat.

### D. Riwayat Transaksi & Cetak Struk
- **Riwayat Historis (`/kasir/histori`)**: Kasir dapat mengecek ulang transaksi yang sudah mereka buat sebelumnya.
- **Cetak Struk**: Mendukung cetak *Receipt* dalam format thermal/PDF (`/process/receipt`) dan menyediakan Struk dengan QR Code (`/process/receipt-qr`) untuk pelanggan.

---

## 4. Pengaturan Akun (Profile)
Setiap pengguna (termasuk Kasir di `/kasir/profile`) dapat mengubah data profil dasar dan kata sandi mereka secara mandiri untuk menjaga keamanan akun.

---
*Dokumentasi ini dibuat selaras dengan fitur yang telah terprogram di sistem POS Library Cafe UMS.*