# Aplikasi FotoStudio Prewedding

Aplikasi manajemen jasa fotografi prewedding yang dibuat dengan PHP Native menggunakan pola MVC.

## Deskripsi

Aplikasi ini dibuat untuk manajemen bisnis fotografi prewedding, termasuk pengelolaan paket layanan, pemesanan, pembayaran, dan laporan. Aplikasi memiliki dua level pengguna, yaitu admin dan pelanggan, dengan fitur yang berbeda untuk masing-masing level.

## Fitur

### Fitur Umum

- Registrasi & Login pengguna
- Melihat paket layanan
- Halaman informasi tentang bisnis

### Fitur Pelanggan

- Dashboard pelanggan
- Pemesanan paket fotografi
- Pembayaran pemesanan
- Melihat status pemesanan
- Mengelola profil

### Fitur Admin

- Dashboard admin
- Manajemen pengguna
- Manajemen paket layanan
- Manajemen pemesanan
- Manajemen pembayaran
- Melihat dan menghasilkan laporan

## Teknologi yang Digunakan

- PHP 7.4+ Native
- MySQL Database
- HTML, CSS, JavaScript
- Bootstrap 5
- FontAwesome
- DataTables
- Chart.js

## Persyaratan Sistem

- PHP 7.4 atau lebih baru
- MySQL 5.7 atau lebih baru
- Web server (Apache/Nginx)
- Browser modern (Chrome, Firefox, Safari, Edge)

## Instalasi

1. Clone repositori ini ke direktori web server Anda

   ```
   git clone <url-repositori> fotostudio
   ```

2. Buat database MySQL baru

   ```
   CREATE DATABASE db_fotostudio;
   ```

3. Import struktur database dari file `app/database/db_fotostudio.sql`

   ```
   mysql -u username -p db_fotostudio < app/database/db_fotostudio.sql
   ```

4. Konfigurasi koneksi database di file `app/config/config.php`

   ```php
   // Konfigurasi Database
   define('DB_HOST', 'localhost');
   define('DB_USER', 'username_anda');
   define('DB_PASS', 'password_anda');
   define('DB_NAME', 'db_fotostudio');

   // Konfigurasi URL
   define('BASE_URL', 'http://localhost/fotostudio');
   ```

5. Pastikan direktori `app/public/uploads` memiliki izin tulis

6. Akses aplikasi melalui browser
   ```
   http://localhost/fotostudio
   ```

## Struktur Aplikasi

```
/app
  /config       - File konfigurasi
  /controllers  - Controller untuk menangani logika bisnis
  /models       - Model untuk interaksi dengan database
  /views        - View untuk tampilan user interface
  /database     - File SQL untuk struktur database
  /lib          - Library dan class utilitas
  /public       - File-file publik (css, js, images)
```

## Informasi Login Default

### Admin

- Username: admin
- Password: admin123

## Kontribusi

Silakan membuat Pull Request untuk kontribusi ke proyek ini. Pastikan kode Anda mengikuti standar coding yang digunakan dalam proyek.

## Lisensi

Proyek ini menggunakan lisensi MIT. Silakan lihat file LICENSE untuk informasi lebih lanjut.
