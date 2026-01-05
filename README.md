# Sistem Lelang Online (LelangKu)

Tugas Praktikum Pemrograman Web - Semester 5

Aplikasi ini adalah sistem lelang sederhana yang dibuat menggunakan framework Laravel 12. Di dalamnya sudah ada fitur untuk admin mengelola barang dan fitur untuk user (member) melakukan penawaran harga (bid).

## Fitur Lengkap Aplikasi:
1.  **Sistem Autentikasi**:
    *   Halaman **Login** dan **Registrasi** user baru.
    *   Sistem **Logout** yang aman.
    *   Pemisahan Role: **Admin** (pengelola) dan **User** (peserta lelang).
2.  **Dashboard Admin (Panel Pengelola)**:
    *   **Statistik**: Melihat jumlah total barang, user, dan bid secara ringkas.
    *   **Manajemen Barang**: Tambah, lihat, ubah, dan hapus barang lelang (CRUD).
    *   **Manajemen Kategori**: Mengatur kategori barang (Elektronik, Perabotan, dll).
    *   **Manajemen User**: Melihat daftar pendaftar dan mengatur peran (Role).
    *   **Penetapan Pemenang**: Admin bisa menentukan pemenang lelang secara manual berdasarkan bid tertinggi.
3.  **Halaman Lelang (User)**:
    *   **Daftar Barang**: Melihat semua barang yang sedang aktif dilelang.
    *   **Pencarian & Sortir**: Cari barang berdasarkan nama, kategori, atau urutkan berdasarkan harga dan waktu.
    *   **Detail Barang**: Melihat deskripsi lengkap, foto, dan riwayat penawaran orang lain.
    *   **Fitur Bidding**: Melakukan penawaran harga dengan validasi otomatis (harga harus lebih tinggi dari penawaran sebelumnya).
4.  **Dashboard User (Member)**:
    *   **Bid Saya**: Melihat daftar barang apa saja yang pernah kita tawar.
    *   **Lelang Dimenangkan**: Melihat barang yang berhasil kita menangkan.
    *   **Edit Profil**: Mengubah data diri dan foto profil.
5.  **Laporan & PDF**:
    *   Fitur **Cetak Laporan** otomatis dengan tampilan formal.
    *   Bisa disimpan langsung ke **PDF** untuk dokumentasi hasil lelang.
6.  **Desain & Teknis**:
    *   Tampilan **Dark Mode** modern dengan efek kaca (Glassmorphism).
    *   Sudah disesuaikan dengan waktu **WIB (Asia/Jakarta)**.
    *   Desain responsif (rapi dibuka di HP maupun Laptop).

## Cara Menjalankan di Laptop:
1. Download folder ini dan simpan di folder `htdocs` atau folder kerja Anda.
2. Buka terminal/cmd di folder ini.
3. Ketik `composer install` (tunggu sampai selesai).
4. Buat database baru di phpMyAdmin dengan nama `database_lelang`.
5. Edit file `.env`, sesuaikan nama database (`DB_DATABASE=database_lelang`).
6. Jalankan `php artisan key:generate`.
7. Jalankan `php artisan migrate --seed` (ini untuk buat tabel dan isi barang contohnya).
8. Terakhir, jalankan `php artisan serve`.
9. Buka browser dan ketik `http://127.0.0.1:8000`.

## Akun Demo:
* **Admin**: admin@lelangku.com (Password: password)
* **User**: user@lelangku.com (Password: password)

Dibuat oleh: [Nama Anda]
NIM: [NIM Anda]
