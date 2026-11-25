# ManganSek - Website Rekomendasi Makanan Hemat

## Deskripsi Proyek

ManganSek merupakan website rekomendasi makanan, minuman, dan
jajanan hemat yang dirancang untuk membantu mahasiswa menemukan
pilihan makanan sesuai dengan kebutuhan dan anggaran.

Website ini dikembangkan menggunakan framework Laravel 13
dengan penerapan arsitektur Model, View, Controller (MVC)
dan database MySQL/MariaDB.

Proyek ini dikembangkan untuk memenuhi Ujian Akhir Praktikum
(UAP) mata kuliah Pemrograman Web.

## Teknologi yang Digunakan

- Laravel 13
- PHP 8.3 atau lebih baru
- MySQL/MariaDB
- HTML
- CSS
- JavaScript
- Blade Template Engine
- Eloquent ORM
- Composer
- Git dan GitHub

## Fitur Website

### User

- Registrasi akun
- Login dan logout
- Dashboard pengguna
- Rekomendasi tempat makan
- Pencarian makanan, minuman, dan jajanan
- Menambahkan dan menghapus favorit
- Memberikan rating dan review
- Mengedit dan menghapus review sendiri
- Melihat dan membagikan Meal Hack
- Melihat informasi promo
- Mengelola profil pengguna

### Admin

- Login dan logout
- Dashboard administrator
- Melihat statistik website
- Menambahkan data menu
- Mengedit data menu
- Menghapus data menu
- Mengunggah foto menu
- Melihat review pengguna
- Mengelola profil administrator

## Implementasi Laravel

Website ManganSek menerapkan beberapa komponen Laravel,
antara lain:

- Model untuk mengelola data dan relasi database.
- View menggunakan Blade untuk menampilkan antarmuka.
- Controller untuk mengelola logika aplikasi.
- Routing untuk mengatur URL dan HTTP Request.
- Middleware untuk membatasi hak akses pengguna.
- Migration untuk membuat struktur database (DDL).
- Seeder untuk mengisi data awal database (DML).
- Validation untuk memvalidasi input pengguna.
- Authentication untuk mengelola autentikasi.
- Eloquent ORM untuk berinteraksi dengan database.
- CSRF Protection untuk melindungi pengiriman formulir.

## Struktur Folder

```text
ManganSekLaravel13/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   ├── Providers/
│   └── Support/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   ├── seeders/
│   └── sql/
├── public/
│   └── assets/
├── resources/
│   └── views/
├── routes/
├── storage/
├── tests/
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
└── README.md
```

## Struktur Database

Database ManganSek terdiri dari enam tabel utama:

| Tabel | Keterangan |
|---|---|
| users | Menyimpan data akun user dan admin |
| tempat | Menyimpan data makanan, minuman, dan jajanan |
| review | Menyimpan rating dan ulasan pengguna |
| favorit | Menyimpan daftar favorit pengguna |
| meal_hack | Menyimpan tips makan hemat |
| promo | Menyimpan informasi promosi |

Database menerapkan Primary Key, Foreign Key, Unique
Constraint, dan relasi antartabel.

## Persyaratan Instalasi

Sebelum menjalankan aplikasi, pastikan perangkat telah
memiliki:

- PHP minimal versi 8.3
- Composer
- MySQL atau MariaDB
- XAMPP atau lingkungan pengembangan sejenis
- Git (opsional)
- Ekstensi PHP yang diperlukan Laravel
- Ekstensi PHP PDO MySQL

## Panduan Instalasi

### 1. Download Repository

Download repository dalam format ZIP melalui menu
Code > Download ZIP pada GitHub.

Ekstrak file ZIP, kemudian buka folder project menggunakan
Visual Studio Code.

### 2. Instalasi Dependency

Buka terminal pada folder project, kemudian jalankan:

```bash
composer install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

Untuk Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Untuk Linux atau macOS:

```bash
cp .env.example .env
```

### 4. Generate Application Key

Jalankan perintah berikut:

```bash
php artisan key:generate
```

### 5. Membuat Database

Aktifkan MySQL melalui XAMPP, kemudian buka phpMyAdmin:

http://localhost/phpmyadmin

Buat database kosong bernama `mangansek` dengan menjalankan:

```sql
CREATE DATABASE mangansek
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

### 6. Konfigurasi Database

Buka file `.env`, kemudian sesuaikan konfigurasi berikut:

```env
APP_NAME=ManganSek
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mangansek
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Sesuaikan username, password, dan port dengan konfigurasi
database pada perangkat masing-masing.

### 7. Membersihkan Cache

```bash
php artisan config:clear
php artisan optimize:clear
```

### 8. Menjalankan Migration dan Seeder

Pastikan database yang digunakan masih kosong.

Jalankan Migration untuk membuat struktur database:

```bash
php artisan migrate
```

Jalankan Seeder untuk memasukkan data awal:

```bash
php artisan db:seed
```

Migration dan Seeder juga dapat dijalankan sekaligus
menggunakan perintah:

```bash
php artisan migrate --seed
```

Pilih salah satu cara. Tidak perlu menjalankan Seeder
kembali apabila data awal sudah berhasil dimasukkan.

### 9. Membuat Storage Link

```bash
php artisan storage:link
```

Perintah ini digunakan agar foto menu yang disimpan
melalui Laravel dapat diakses oleh website.

### 10. Menjalankan Aplikasi

```bash
php artisan serve
```

Buka alamat berikut melalui browser:

http://127.0.0.1:8000

## Alternatif Instalasi Database

Selain menggunakan Migration dan Seeder, database dapat
dibuat dengan mengimpor file SQL yang tersedia pada
folder `database/sql/` melalui phpMyAdmin.

Gunakan salah satu metode instalasi database:

1. Migration dan Seeder (direkomendasikan).
2. Import file SQL melalui phpMyAdmin.

Jangan menjalankan kedua metode pada database yang sama
karena dapat menyebabkan konflik struktur tabel atau
duplikasi data.

## Akun Demo

### Administrator

| Keterangan | Data |
|---|---|
| Portal | Admin |
| Email | admin@mangansek.test |
| Password | ManganSek@2026! |

Akun tersebut merupakan akun demo yang tersedia melalui
Seeder, bukan akun pribadi administrator.

### User

Pengguna dapat membuat akun baru melalui halaman
registrasi yang tersedia pada website.

## Pengujian Aplikasi

Untuk memeriksa daftar routing:

```bash
php artisan route:list
```

Untuk memeriksa status Migration:

```bash
php artisan migrate:status
```

Untuk menjalankan pengujian otomatis:

```bash
php artisan test
```

Pengujian fungsionalitas website meliputi:

- Autentikasi user dan admin.
- Pembatasan hak akses berdasarkan role.
- Create, Read, Update, dan Delete data menu.
- Upload foto menu.
- Pencarian dan rekomendasi makanan.
- Review dan rating.
- Favorit.
- Meal Hack.
- Promo.
- Pengelolaan profil.
- Integrasi database.

## Keamanan Aplikasi

Beberapa mekanisme keamanan yang diterapkan:

- Password hashing.
- CSRF Protection.
- Middleware Authentication.
- Role-Based Access Control.
- Validasi input pengguna.
- Pembatasan akses CRUD khusus administrator.
- Pembatasan perubahan review berdasarkan kepemilikan akun.

File `.env` tidak disertakan dalam repository untuk
menjaga keamanan konfigurasi aplikasi.

## Troubleshooting

### Error tabel sessions atau cache tidak ditemukan

Pastikan konfigurasi `.env` menggunakan:

```env
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Kemudian jalankan:

```bash
php artisan optimize:clear
```

### Error koneksi database

Pastikan MySQL telah berjalan dan konfigurasi database
pada file `.env` sudah sesuai.

### Error PHP Extension intl

Aktifkan ekstensi berikut pada file `php.ini` yang
digunakan oleh PHP CLI:

```ini
extension=intl
```

### Error autoload Composer

Jalankan:

```bash
composer dump-autoload
```

### Foto upload tidak tampil

Jalankan:

```bash
php artisan storage:link
```

## Anggota Kelompok

| No | Nama | NIM | Kontribusi |
|---|---|---|---|
| 1 | Muhammad Hafiz Raihansyah     | 255150600111039  | Meal Hack       |
| 2 | Farica Natarina Putri Wahyudi | 255250600111026  | Minuman & Jajan |
| 3 | Daffa Rafi Andhika            | 255150600111042  | Review          |
| 4 | Nisrina Salma                 | 255150607111019  | Makanan         |
| 5 | Putri Hayu Aulya              | 255150607111018  | info promo      |

## Informasi Akademik

- Mata Kuliah: Pemrograman Web
- Kegiatan: Ujian Akhir Praktikum (UAP)
- Program Studi: Pendidikan Teknologi Informasi
- Fakultas: Fakultas Ilmu Komputer
- Universitas: Universitas Brawijaya
- Tahun: 2026

## Dokumentasi

Dokumentasi pengembangan, perancangan database, user flow,
implementasi fitur, dan hasil pengujian tersedia pada
Laporan Akhir Ujian Akhir Praktikum.

---

ManganSek - Website Rekomendasi Makanan Hemat

Universitas Brawijaya | 2026