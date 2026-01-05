# Sistem Lelang Online (LelangKu)

Tugas Besar Praktikum Pemrograman Web - Semester 5

Aplikasi ini adalah sistem lelang sederhana yang dibuat menggunakan framework Laravel 12.  
Di dalamnya terdapat fitur untuk **Admin** mengelola barang lelang dan **User (Member)** melakukan penawaran harga (bid).

---

## Fitur Lengkap Aplikasi

### 1. Sistem Autentikasi
- Halaman **Login** dan **Registrasi**
- Sistem **Logout**
- Pemisahan Role: **Admin** dan **User**

### 2. Dashboard Admin (Panel Pengelola)
- Statistik data barang, user, dan bid
- Manajemen Barang (CRUD)
- Manajemen Kategori
- Manajemen User
- Penetapan pemenang lelang berdasarkan bid tertinggi

### 3. Halaman Lelang (User)
- Daftar barang lelang aktif
- Pencarian dan sortir barang
- Detail barang dan riwayat bid
- Fitur bidding dengan validasi harga

### 4. Dashboard User
- Riwayat bid
- Daftar lelang yang dimenangkan
- Edit profil user

### 5. Laporan & PDF
- Cetak laporan hasil lelang
- Export laporan ke format PDF

### 6. Desain & Teknis
- Tampilan **Dark Mode** (Glassmorphism)
- Zona waktu **WIB (Asia/Jakarta)**
- Desain responsif (mobile & desktop)

---

## Cara Menjalankan Aplikasi
1. Clone / download project ini
2. Buka terminal di folder project
3. Jalankan `composer install`
4. Buat database dengan nama `database_lelang`
5. Atur database di file `.env`
6. Jalankan `php artisan key:generate`
7. Jalankan `php artisan migrate --seed`
8. Jalankan `php artisan serve`
9. Akses aplikasi di `http://127.0.0.1:8000`

---

## Akun Demo
- **Admin**: admin@lelangku.com | password
- **User**: user@lelangku.com | password

---
