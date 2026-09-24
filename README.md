# Transaction Report

Aplikasi web untuk **mencatat dan melaporkan transaksi** per usaha (multi-user). Setiap pengguna hanya dapat melihat dan mengelola data transaksinya sendiri, lengkap dengan dashboard ringkasan, grafik pendapatan harian, filter rentang tanggal, dan manajemen profil.

Dibangun dengan **Laravel 13**, **PHP 8.5**, **MySQL**, **Tailwind CSS 4**, dan **Vite**.

---

## ✨ Fitur Utama

- **Autentikasi lengkap** — register, login, logout, lupa password, dan reset password.
- **Multi-tenant sederhana** — setiap user memiliki `business_name` dan hanya bisa mengakses transaksinya sendiri (dijaga oleh `TransactionPolicy`).
- **Dashboard ringkasan** — total transaksi, total pendapatan, dan rata-rata nominal dengan pilihan rentang: Hari Ini, 7 Hari, 30 Hari, dan Bulan Ini.
- **Grafik pendapatan harian** — bar chart interaktif (tooltip berisi tanggal, total, dan jumlah transaksi).
- **CRUD Transaksi** — tambah, lihat, ubah, dan hapus transaksi (soft delete) dengan validasi via Form Request.
- **Filter rentang tanggal** — daftar transaksi bisa difilter berdasarkan tanggal mulai dan tanggal akhir, dengan pagination.
- **Manajemen profil** — ubah nama, nama usaha, email, dan ganti password.
- **Zona waktu lokal** — semua tanggal transaksi disimpan dalam UTC dan ditampilkan dalam `Asia/Jakarta`.

---

## 🧱 Teknologi

| Kategori | Teknologi |
| --- | --- |
| Backend | Laravel 13, PHP 8.5 |
| Database | MySQL |
| Frontend | Blade, Tailwind CSS 4, Vite 8 |
| Testing | Pest 5, PHPUnit |
| Tooling | Laravel Pint, Laravel Boost, Laravel Pail |

---

## ✅ Persyaratan

Pastikan sudah terpasang:

- PHP **8.3+** (disarankan 8.5) dengan ekstensi standar Laravel
- Composer
- Node.js **18+** dan npm
- MySQL (server berjalan)

---

## 🚀 Langkah Menjalankan Proyek

### 1. Clone repositori

```bash
git clone <url-repositori> web-trx-report-laravel
cd web-trx-report-laravel
```

### 2. Install dependensi PHP & JavaScript

```bash
composer install
npm install
```

### 3. Siapkan environment

```bash
copy .env.example .env
php artisan key:generate
```

### 4. Buat database MySQL

Buat database bernama `web_trx_report` (atau sesuaikan dengan `DB_DATABASE` di `.env`).

```sql
CREATE DATABASE web_trx_report CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Sesuaikan kredensial database pada `.env` bila perlu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_trx_report
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan migrasi & seeder

```bash
php artisan migrate --seed
```

Seeder membuat akun demo beserta 20 transaksi contoh:

| Email | Password |
| --- | --- |
| `test@example.com` | `password` |

### 6. Jalankan aplikasi

Cara cepat (menjalankan server, queue, log, dan Vite sekaligus):

```bash
composer run dev
```

Atau jalankan secara terpisah:

```bash
php artisan serve
npm run dev
```

Buka **http://localhost:8000** di browser.

> Untuk mode produksi, jalankan `npm run build` agar aset frontend dikompilasi.

### Alternatif: Setup otomatis

Tersedia script composer yang menjalankan seluruh langkah di atas:

```bash
composer run setup
```

---

## 🧪 Menjalankan Test

```bash
php artisan test --compact
```

Test menggunakan database SQLite in-memory (lihat `phpunit.xml`), jadi tidak mengganggu data MySQL.

---

## 🗂️ Struktur Proyek

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                      # Login, Register, Forgot/Reset Password
│   │   ├── DashboardController.php    # Ringkasan & grafik
│   │   ├── ProfileController.php      # Manajemen profil
│   │   └── TransactionController.php  # CRUD + filter transaksi
│   └── Requests/                      # Validasi Form Request
├── Models/
│   ├── Transaction.php                # Soft delete + konversi timezone
│   └── User.php                       # UUID + relasi transaksi
└── Policies/TransactionPolicy.php     # Otorisasi kepemilikan data

database/
├── migrations/                        # Skema users, cache, jobs, transactions
├── factories/                         # UserFactory, TransactionFactory
└── seeders/DatabaseSeeder.php         # Akun & data demo

resources/views/
├── auth/                              # Halaman autentikasi
├── dashboard.blade.php                # Dashboard + grafik
├── profile/                           # Halaman profil
└── transactions/                      # Daftar & form transaksi
```

---

## 🧭 Routing

| Method | URI | Keterangan |
| --- | --- | --- |
| `GET` | `/dashboard` | Dashboard ringkasan & grafik |
| `GET` | `/transactions` | Daftar transaksi + filter tanggal |
| `GET` | `/transactions/create` | Form tambah transaksi |
| `POST` | `/transactions` | Simpan transaksi |
| `GET` | `/transactions/{id}/edit` | Form ubah transaksi |
| `PUT` | `/transactions/{id}` | Perbarui transaksi |
| `DELETE` | `/transactions/{id}` | Hapus transaksi (soft delete) |
| `GET` | `/profile` | Halaman profil |
| `POST` | `/profile` | Perbarui profil |
| `POST` | `/profile/password` | Ganti password |

Lihat semua rute dengan:

```bash
php artisan route:list --except-vendor
```

---

## 🛠️ Command List

```bash
php artisan migrate:fresh --seed   # Reset database + data demo
php artisan route:list             # Lihat daftar rute
vendor/bin/pint --dirty            # Rapikan format kode PHP
php artisan pail                   # Lihat log aplikasi secara real-time
npm run build                      # Build aset untuk produksi
```

---

## 💖 Dukungan & Kontak

Kamu dapat mendukung saya di https://saweria.co/erfrandarmawan

Collab via erfrandarmawan@develobe.id

Social Media Channel :
- https://www.youtube.com/@develobe_id
- https://tiktok.com/@erfrandarmawan
- https://instagram.com/erfrandarmawan

---

## 📄 Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
