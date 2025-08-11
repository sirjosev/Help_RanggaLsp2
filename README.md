# Dokumentasi Proyek LSP-DKS

Repository ini berisi kode sumber untuk situs web Lembaga Sertifikasi Profesi - Digital Kreatif Solusi (LSP-DKS).

## Tentang Proyek

Proyek ini adalah portal web yang berfungsi sebagai pusat informasi untuk LSP-DKS. Situs ini menyediakan informasi mengenai skema sertifikasi yang ditawarkan, profil lembaga, serta artikel dan berita terkait. Pengguna dapat melihat detail setiap skema sertifikasi, dan administrator dapat mengelola konten situs melalui halaman admin.

## Stack Teknologi

Berikut adalah teknologi yang digunakan dalam pengembangan proyek ini:

- **Backend:** PHP 8.x (Native) dengan koneksi database menggunakan PDO.
- **Frontend:**
  - HTML5
  - CSS3
  - JavaScript (ES6+)
  - [Bootstrap 5](https://getbootstrap.com/) - Framework CSS untuk desain responsif.
  - [Font Awesome](https://fontawesome.com/) - Ikonografi.
- **Database:** MySQL / MariaDB.
- **Web Server:** Apache atau Nginx dengan dukungan PHP.

## Struktur Database

Database `dks` terdiri dari beberapa tabel utama yang saling berelasi untuk mengelola data skema, blog, dan pengguna.

- `skema`: Menyimpan informasi detail tentang setiap skema sertifikasi yang ditawarkan.
- `unit_kompetensi`: Menyimpan unit-unit kompetensi yang terkait dengan setiap skema.
- `persyaratan`: Menyimpan persyaratan umum untuk setiap skema.
- `dokumen_persyaratan`: Menyimpan daftar dokumen yang diperlukan untuk pendaftaran skema.
- `metode_asesmen`: Menyimpan metode asesmen yang digunakan dalam sertifikasi.
- `blog`: Menyimpan artikel dan berita yang ditampilkan di halaman blog.
- `users`: Menyimpan data pengguna, termasuk admin, untuk otentikasi dan otorisasi.

File `.sql` yang berisi struktur lengkap dan beberapa data contoh dapat ditemukan di root direktori (`skema.sql`, `blog.sql`).

## Alur Kerja Program

Aplikasi ini memiliki dua alur kerja utama, yaitu untuk pengunjung umum dan administrator.

### Alur Pengunjung
1.  **Halaman Utama (`index.php`):** Pengunjung akan disambut dengan halaman utama yang menampilkan profil singkat LSP-DKS, visi & misi, 6 skema sertifikasi unggulan, dan 3 artikel terbaru.
2.  **Melihat Sertifikasi (`sertifikasi.php`):** Pengunjung dapat melihat daftar lengkap semua skema sertifikasi yang tersedia.
3.  **Detail Skema (`skema.php`):** Dengan mengklik salah satu skema, pengunjung akan diarahkan ke halaman detail yang berisi informasi lengkap tentang skema tersebut, termasuk unit kompetensi, persyaratan, dan biaya.
4.  **Membaca Blog (`blog.php`):** Halaman ini menampilkan semua artikel dan berita. Pengunjung dapat membaca artikel secara lengkap di halaman detail blog (`blog_detail.php`).
5.  **Registrasi & Login (`register.php`, `login.php`):** Pengunjung dapat mendaftar sebagai pengguna atau masuk jika sudah memiliki akun.

### Alur Administrator
1.  **Login:** Administrator masuk melalui halaman `login.php` dengan menggunakan kredensial admin.
2.  **Dashboard Admin (`admin.php`):** Setelah berhasil login, admin akan diarahkan ke dashboard utama admin.
3.  **Manajemen Skema (`admin_skema.php`):** Admin dapat melakukan operasi CRUD (Create, Read, Update, Delete) untuk semua data yang terkait dengan skema sertifikasi.
4.  **Manajemen Blog (`admin_blog.php`):** Admin dapat menambah, mengedit, dan menghapus artikel atau berita.
5.  **Logout (`logout.php`):** Admin dapat keluar dari sesi mereka.

## Cara Instalasi dan Deployment

Berikut adalah langkah-langkah untuk menginstal dan menjalankan proyek ini di lingkungan lokal atau server.

### Prasyarat
- Web server (contoh: Apache, Nginx)
- PHP versi 8.0 atau lebih baru
- MySQL atau MariaDB
- Git (opsional, untuk kloning repositori)

### Langkah-langkah Instalasi
1.  **Kloning Repositori:**
    ```bash
    git clone https://github.com/username/repository-name.git
    cd repository-name
    ```
    Atau, unduh file ZIP dan ekstrak ke direktori root web server Anda (misalnya, `htdocs` untuk XAMPP, `www` untuk WampServer).

2.  **Buat Database:**
    - Buat database baru di MySQL/MariaDB dengan nama `dks`.
    - Impor struktur dan data dari file `skema.sql` dan `blog.sql` ke dalam database `dks` yang baru dibuat. Anda dapat menggunakan phpMyAdmin atau command line.
      ```bash
      mysql -u username -p dks < skema.sql
      mysql -u username -p dks < blog.sql
      ```
    - (Opsional) Impor data dummy untuk blog dari `dummy_blogs.sql`.

3.  **Konfigurasi Koneksi Database:**
    - Buka file `config.php`.
    - Sesuaikan pengaturan berikut dengan konfigurasi database lokal Anda:
      ```php
      $host = 'localhost';
      $dbname = 'dks';
      $username = 'root'; // Ganti dengan username database Anda
      $password = '';     // Ganti dengan password database Anda
      ```

4.  **Jalankan Aplikasi:**
    - Buka browser dan arahkan ke URL proyek Anda (misalnya, `http://localhost/repository-name`).

## Petunjuk Penggunaan

### Untuk Pengunjung
- Jelajahi situs untuk melihat informasi tentang LSP-DKS.
- Klik menu **Sertifikasi** untuk melihat semua skema yang tersedia.
- Klik pada gambar atau nama skema untuk melihat detailnya.
- Kunjungi halaman **Blog** untuk membaca artikel terbaru.

### Untuk Administrator
- Akses halaman login di `login.php`.
- Gunakan kredensial admin untuk masuk.
- Setelah login, gunakan menu di halaman admin untuk mengelola skema sertifikasi dan konten blog.
- Pastikan untuk selalu **Logout** setelah selesai menggunakan panel admin untuk menjaga keamanan.
