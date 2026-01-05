# 📄 Materi Presentasi: Sistem Informasi Pelelangan Online (LelangKu)

Dokumen ini disusun untuk membantu kebutuhan presentasi tugas akhir/praktikum semester 5.

---

## 1. Latar Belakang Masalah
*   **Keterbatasan Geografis**: Sistem lelang konvensional mengharuskan peserta datang ke lokasi fisik, membatasi jumlah partisipan.
*   **Efisiensi Waktu**: Proses manual memakan waktu lama dalam pencatatan penawaran dan penentuan pemenang.
*   **Transparansi Data**: Kesulitan dalam melacak riwayat penawaran (history bid) secara akurat jika dilakukan secara manual.
*   **Solusi**: Dibutuhkan sistem lelang berbasis web yang dapat diakses dari mana saja (online), real-time, dan transparan.

## 2. Tujuan Sistem
1.  **Digitalisasi Proses**: Mengubah proses lelang manual menjadi sistem terkomputerisasi.
2.  **Jangkauan Luas**: Memungkinkan user dari berbagai lokasi untuk mengikuti lelang.
3.  **Transparansi Harga**: Menampilkan riwayat penawaran secara terbuka sehingga fair bagi semua peserta.
4.  **Otomatisasi Laporan**: Mempermudah admin dalam merekap hasil lelang menjadi laporan siap cetak.

## 3. Teknologi yang Digunakan
*   **Bahasa Pemrograman**: PHP 8.2+
*   **Framework Backend**: Laravel 12 (Versi Terbaru)
    *   *Alasan*: Keamanan tinggi, struktur rapi, dan fitur lengkap (Auth, ORM, Migration).
*   **Database**: MySQL
    *   *Alasan*: Relasional, stabil, dan umum digunakan dalam industri.
*   **Frontend**: Blade Templating Engine + Vanilla CSS
    *   *Style*: Custom **Glassmorphism Design** (Efek kaca, Dark Mode, Modern UI).
    *   *Icons*: Font Awesome 6.
*   **Server Environment**: XAMPP / Laragon (Apache Server).

## 4. Arsitektur Sistem (Konsep MVC)
Sistem ini dibangun menggunakan pola **Model-View-Controller (MVC)**:

### A. Model (Pengelola Data)
Berhubungan langsung dengan database.
*   `User`: Mengelola data admin dan member.
*   `AuctionItem`: Mengelola data barang lelang, harga awal, dan waktu mulai/selesai.
*   `Bid`: Mencatat setiap penawaran yang masuk dari user.
*   `Category`: Mengelompokkan jenis barang (Elektronik, Properti, dll).

### B. View (Tampilan Antarmuka)
Apa yang dilihat oleh pengguna di browser.
*   `resources/views/admin`: Folder tampilan khusus Dashboard Admin.
*   `resources/views/auctions`: Tampilan daftar lelang untuk user.
*   `resources/views/layouts`: Kerangka desain utama (Sidebar, Navbar, Footer).

### C. Controller (Logika Bisnis)
Penghubung antara Model dan View.
*   `AuthController`: Menangani Login, Register, dan Logout.
*   `AuctionItemController`: Logika CRUD barang (Tambah, Edit, Hapus).
*   `BidController`: **[LOGIKA PENTING]** Memvalidasi agar bid baru harus lebih tinggi dari harga saat ini + kelipatan minimal.

## 5. Manajemen Aktor (Role & Hak Akses)
Sistem membedakan dua hak akses menggunakan **Middleware**:

### 1. Admin (Administrator)
*   Login ke Panel Admin.
*   Mengelola Data Master (Kategori, Barang).
*   Memvalidasi/Menentukan Pemenang Lelang.
*   Mencetak Laporan Operasional.
*   Mengelola User (Banned/Hapus user).

### 2. User (Peserta/Member)
*   Registrasi akun baru.
*   Melihat katalog barang lelang.
*   Melakukan penawaran (Bidding).
*   Melihat riwayat bid sendiri dan status kemenangan.
*   Mengubah profil pribadi.

## 6. Alur Kerja Sistem (Flowchart)

### Alur Admin:
1.  **Login** -> Dashboard Admin.
2.  **Input Data**: Admin memasukkan barang lelang, menetapkan Harga Awal (Open Price) dan Waktu Selesai (Deadline).
3.  **Monitoring**: Barang tayang di halaman depan (status: Active).
4.  **Finalisasi**: Setelah waktu habis, Admin mengecek penawar tertinggi -> Klik "Tetapkan Pemenang".
5.  **Reporting**: Admin mencetak laporan hasil lelang ke PDF.

### Alur User:
1.  **Registrasi** -> Login.
2.  **Browsing**: Mencari barang yang diminati.
3.  **Bidding**:
    *   User input harga penawaran.
    *   *Sistem Cek*: Apakah Harga > (Harga Sekarang + Min. Increment)?
    *   *Jika Ya*: Simpan bid, update harga barang.
    *   *Jika Tidak*: Tolak dan tampilkan pesan error.
4.  **Hasil**: Jika menang, barang muncul di menu "Lelang Dimenangkan".

## 7. Relasi Database (ERD)
1.  **Users -> Bids** (One-to-Many): Satu user bisa melakukan banyak penawaran.
2.  **AuctionItems -> Bids** (One-to-Many): Satu barang bisa memiliki banyak penawaran dari user berbeda.
3.  **Categories -> AuctionItems** (One-to-Many): Satu kategori (misal: Elektronik) punya banyak barang.
4.  **Users -> AuctionItems** (One-to-Many):
    *   User sebagai pembuat (Admin).
    *   User sebagai pemenang (Winner).

## 8. Keunggulan Sistem (Selling Points)
1.  **Modern User Interface**: Menggunakan desain *Glassmorphism* dan *Dark Mode* yang sesuai tren UI/UX masa kini, berbeda dengan desain kaku pada umumnya.
2.  **Real-Time Validation Logic**: Sistem mencegah kecurangan atau kesalahan input harga bid secara otomatis di sisi server (Backend Validation).
3.  **Timezone Awareness**: Sistem otomatis mengenali status barang (Aktif/Selesai) berdasarkan waktu server (WIB), sehingga penutupan lelang presisi.
4.  **Security First**: Password terenkripsi (Bcrytp), proteksi CSRF pada setiap form, dan pembatasan akses halaman admin menggunakan Middleware.
5.  **Easy Reporting**: Fitur cetak laporan sekali klik yang memudahkan administrasi.

---
*Materi ini disusun untuk mendukung presentasi Tugas Akhir Mata Kuliah Pemrograman Web.*
