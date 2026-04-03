<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# SIM Lab — Sistem Informasi Manajemen Laboratorium

Sistem informasi berbasis web untuk mengelola inventaris barang di lingkungan laboratorium. Dibangun menggunakan Laravel 12 dengan tampilan yang bersih dan responsif.

---

## Tentang Sistem Ini

SIM Lab adalah aplikasi manajemen inventaris yang saya buat untuk memudahkan pengelolaan barang, stok, dan pengguna di laboratorium. Sistem ini mendukung dua level akses: **Admin** dan **User**, dengan fitur yang disesuaikan masing-masing.

---


## Teknologi yang Digunakan

| Komponen | Detail |
|----------|--------|
| Backend | PHP 8.2, Laravel 12 |
| Frontend | Blade Templating, CSS murni |
| Build Tool | Vite |
| Database | MySQL (XAMPP) |
| Storage | Laravel Storage |
| Auth | Laravel Auth Middleware |

---

## Cara Menjalankan

```bash
# 1. Clone repo
git clone https://github.com/kinsa24/SIM-Lab.git
cd SIM-Lab

# 2. Install dependencies
composer install
npm install

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Atur database di .env, lalu jalankan migrasi
php artisan migrate

# 5. Buat symlink storage
php artisan storage:link

# 6. Jalankan aplikasi
php artisan serve
npm run dev
```

Buka di browser: `http://localhost:8000`

---
## Fitur

- **Admin**:
  - Menambahkan, mengedit, dan menghapus pengguna.
  - Menambahkan, mengedit, dan menghapus barang.
  - Melihat laporan stok barang.

- **User**:
  - Melihat daftar barang.
  - Meminjam barang.
  - Mengembalikan barang.
  - Melihat riwayat peminjaman.

---

## Screenshots

## Lisensi

Proyek ini dibuat untuk keperluan tugas akhir yaitu pengembangan sistem informasi laboratorium.
