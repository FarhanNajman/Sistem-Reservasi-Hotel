---
marp: true
theme: default
paginate: true
---

# 🏨 Sistem Reservasi Hotel
**Penjelasan Rinci Arsitektur dan Alur Aplikasi**

---

## 📋 Gambaran Umum

- **Platform:** Web Application
- **Framework:** PHP Laravel
- **Tujuan Utama:** 
  - Memfasilitasi tamu untuk mencari & memesan kamar hotel.
  - Memudahkan administrator mengelola data hotel & laporan.
- **Fitur Khusus:** Autentikasi, Upload File (Foto/Bukti Bayar), dan Export Laporan/Invoice PDF.

---

## 👥 Role Pengguna & Hak Akses

Sistem menggunakan Middleware untuk membagi pengguna menjadi dua _role_:

1. **User / Tamu 👤**
   - Mendaftar via halaman Register.
   - Akses: Pencarian kamar, pemesanan, unggah bukti bayar, dan melihat riwayat/invoice sendiri.
2. **Administrator 🛡️**
   - Dilindungi oleh `RoleMiddleware`.
   - Akses: Kontrol penuh data master (Kamar), manajemen validasi transaksi (Reservasi), pengguna, dan statistik.

---

## 🌟 Fitur Untuk Tamu (1/2)

- **Landing Page & Pencarian Cerdas 🔍**
  - Melihat kamar terbaru & semua kamar.
  - Filter pencarian: Tanggal In/Out, Kapasitas, Tipe, & Lantai.
  - *Availability Check*: Kamar otomatis berstatus "Penuh" jika ada persinggungan tanggal dengan reservasi aktif.
- **Detail Kamar 🛏️**
  - Menampilkan foto ruangan, denah kamar, harga, fasilitas (array/list), dan deskripsi lengkap.

---

## 🌟 Fitur Untuk Tamu (2/2)

- **Proses Pemesanan (Booking) 📅**
  - Kalkulasi otomatis: `total_harga` (Selisih Hari x Harga).
  - *Auto-Generate* `kode_booking` unik (e.g., `RSV-LT1N01-260713`).
- **Pembayaran 💳**
  - Upload gambar Bukti Pembayaran (status berubah menjadi "pending").
- **Riwayat & Invoice 📄**
  - Menu "Reservasi Saya" untuk riwayat pemesanan.
  - Download Invoice elektronik dalam format **PDF**.

---

## 🛠️ Fitur Untuk Administrator (1/2)

- **Manajemen Kamar (CRUD) 🚪**
  - Create, Read, Update, Delete data kamar.
  - Upload "Foto Kamar" dan "Denah Kamar".
  - *Validasi Cerdas*: Nomor kamar unik di lantai yang sama & fungsi auto-normalisasi (misal lantai 2 -> kamar 201).
- **Validasi Pembayaran ✅**
  - Mengecek bukti bayar tamu.
  - Konfirmasi pembayaran mengubah status menjadi "Dikonfirmasi" (Lunas).

---

## 🛠️ Fitur Untuk Administrator (2/2)

- **Daftar Pengguna 👥**
  - Memantau user yang terdaftar dalam sistem.
- **Laporan Statistik Reservasi 📈**
  - Menampilkan grafik jumlah reservasi sukses (dikonfirmasi/check-in/check-out) per bulan.
  - Cetak Laporan Hunian Bulanan ke **PDF**.

---

## 🗄️ Struktur Database (Model)

1. **`users`**
   - Kredensial: nama, email, password, role.
2. **`rooms`**
   - Data Master: nomor_kamar, lantai, tipe_kamar, harga_per_malam, fasilitas (array), dsb.
3. **`reservations`**
   - Data Transaksi: Berelasi (*BelongsTo*) dengan `rooms`. Menyimpan tanggal in/out, kode booking, bukti bayar, dan status transaksi.

---

## ⚙️ Teknologi & Library Tambahan

- **`Barryvdh\DomPDF`** 📄
  - Mengonversi HTML/Blade menjadi file PDF (Invoice & Laporan).
- **File Storage (Disk `public`)** 📁
  - Menyimpan aset upload pengguna secara lokal (foto kamar, denah, bukti transfer).
- **Blade Templating** 🎨
  - Merender tata letak (layout) UI aplikasi web secara efisien.

---

## 📁 Fungsi File-File Utama (1/2)

- **`routes/web.php`** 🛤️
  - *Fungsi*: Pengendali jalur navigasi (Routing).
  - *Logika Kunci*: Logika *Availability Check* kamar via Query Builder, penghitungan total harga (menggunakan selisih hari *Carbon*), auto-generate *Kode Booking* unik, dan proteksi jalur Middleware.
- **`AuthController.php`** 🔐
  - *Fungsi*: Pengelola Autentikasi (Login, Register, Logout).
  - *Logika Kunci*: Validasi keamanan ketat untuk menolak tamu yang login via rute login/mode *Admin* (`ValidationException`).

---

## 📁 Fungsi File-File Utama (2/2)

- **`RoleMiddleware.php`** 🚧
  - *Fungsi*: Penjaga gawang akses (*Security Gate*).
  - *Logika Kunci*: Mencegat user yang tak berwenang mengakses halaman khusus (melempar *Redirect* atau *Abort 403 Forbidden*).
- **`Models\Room.php` & `Reservation.php`** 📦
  - *Fungsi*: Representasi Tabel Database (Eloquent ORM).
  - *Logika Kunci*: *Casting* kolom fasilitas jadi `array` (JSON), fungsi Statis `normalizeNomorKamar` untuk normalisasi nama kamar ke lantainya, dan pendaftaran relasi (*One-to-Many* / *BelongsTo*).

---

## 📁 Fungsi File-File Utama (3/3)

- **`DatabaseSeeder.php`** 🌱
  - *Fungsi*: Injeksi Data Awal (*Dummy Data*).
  - *Logika Kunci*: Pembuatan otomatis akun Admin utama, input katalog kamar, dan contoh transaksi reservasi untuk simulasi instan.
- **`layouts/app.blade.php`** 🖼️
  - *Fungsi*: Master Layout Antarmuka Web (UI).
  - *Logika Kunci*: Render *Navbar* dinamis sesuai *Role*, pemanggilan Lucide Icons, dan penanganan notifikasi pop-up (*Toasts*) ber-timer JavaScript.
- **`Room & Reservation Controller`** ⚙️
  - *Catatan Arsitektur*: File *Resource Controller* yang dibiarkan kosong, dikarenakan mayoritas *business logic* sengaja dipusatkan (*bypass*) di dalam *Closure* `web.php` untuk fleksibilitas *routing* cepat.

---

# 🎉 Terima Kasih
Sistem ini siap di-deploy dan digunakan untuk mempermudah operasional reservasi hotel.
