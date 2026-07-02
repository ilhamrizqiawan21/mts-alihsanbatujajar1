# Sistem Pencatatan Siswa MTs Al-Ihsan Batujajar (SIPESAN)

Aplikasi web administrasi sekolah untuk mencatat dan memantau data siswa MTs Al-Ihsan Batujajar. Project ini dibangun dengan Laravel dan menyediakan modul pengelolaan siswa, kelas, absensi, pelanggaran, surat izin, kebersihan kelas, keterlambatan, prestasi, pengaturan tahun ajaran, serta export laporan.

## Gambaran Global

Sistem ini berfungsi sebagai pusat pencatatan aktivitas siswa di lingkungan sekolah. Admin atau petugas sekolah dapat login, melihat ringkasan data pada dashboard, mengelola data master, mencatat aktivitas harian, dan mengunduh laporan dalam format PDF maupun XLSX.

Secara garis besar, alur aplikasi adalah:

1. Pengguna login melalui halaman autentikasi berbasis session.
2. Dashboard menampilkan ringkasan jumlah kelas, siswa, absensi, pelanggaran, data siswa terbaru, pelanggaran terbaru, dan absensi hari ini.
3. Pengguna mengelola data siswa dan kelas sebagai data utama.
4. Modul operasional mencatat absensi, pelanggaran, izin, kebersihan, keterlambatan, dan prestasi.
5. Data dapat difilter dan diexport untuk kebutuhan laporan sekolah.

## Spesifikasi Teknis

| Komponen | Spesifikasi |
| --- | --- |
| Framework backend | Laravel 13.x |
| Bahasa backend | PHP 8.3 atau lebih baru |
| Frontend | Blade Template, Bootstrap 5, Bootstrap Icons, CSS custom |
| Build tool frontend | Vite |
| Package manager PHP | Composer |
| Package manager JS | NPM |
| Database utama | MySQL / MariaDB direkomendasikan |
| PDF export | `barryvdh/laravel-dompdf` |
| XLSX export | Exporter custom pada `app/Support/XlsxExporter.php` |
| Testing | PHPUnit |
| Web server lokal | Laravel Artisan Serve, Laragon, Apache, atau Nginx |

## Bahasa dan Teknologi yang Digunakan

- PHP untuk logika backend, controller, model, middleware, dan service.
- Laravel sebagai framework utama.
- Blade untuk template halaman.
- HTML, CSS, dan JavaScript untuk tampilan antarmuka.
- Bootstrap 5 dan Bootstrap Icons untuk komponen UI.
- Vite untuk proses asset frontend.
- MySQL atau MariaDB untuk penyimpanan data.
- PHPUnit untuk pengujian otomatis.

## Fitur Utama

- Login dan logout pengguna berbasis session legacy.
- Dashboard ringkasan data sekolah.
- Manajemen data siswa.
- Manajemen data kelas dan wali kelas.
- Pencatatan absensi siswa per tanggal dan bulan.
- Pencatatan pelanggaran siswa beserta jenis pelanggaran dan poin.
- Pencatatan surat izin siswa.
- Pencatatan kebersihan kelas.
- Pencatatan keterlambatan siswa.
- Pencatatan prestasi siswa.
- Pengaturan tahun ajaran aktif.
- Filter data berdasarkan nama, kelas, tanggal, bulan, atau tahun sesuai modul.
- Export laporan PDF untuk beberapa modul.
- Export laporan XLSX untuk beberapa modul.
- Layout responsif dengan sidebar desktop dan menu mobile.

## Keunggulan Project

- Dibuat spesifik untuk kebutuhan administrasi sekolah, bukan aplikasi generik.
- Modul pencatatan siswa cukup lengkap untuk kebutuhan operasional harian.
- Tampilan dashboard memudahkan pemantauan kondisi terbaru.
- Data dapat diexport ke PDF dan XLSX sehingga mudah digunakan untuk laporan.
- Struktur mengikuti pola Laravel MVC sehingga mudah dikembangkan.
- Sudah tersedia test feature untuk memeriksa route, koneksi database, halaman CRUD, absensi, dashboard, dan export.
- Mendukung schema legacy melalui file SQL sehingga dapat digunakan bersama database lama.

## Struktur Folder Penting

```text
app/
  Http/Controllers/     Controller untuk setiap modul aplikasi
  Http/Middleware/      Middleware autentikasi legacy
  Models/               Model Eloquent untuk tabel aplikasi
  Support/              Helper export XLSX

database/
  migrations/           Migration Laravel
  seeders/              Seeder data awal

resources/
  views/                Template Blade per modul
  css/                  Source CSS frontend
  js/                   Source JavaScript frontend

public/
  css/app.css           CSS publik
  logo-sekolah.png      Logo sekolah
  favicon*              Icon aplikasi

routes/
  web.php               Definisi route web aplikasi

scripts/
  legacy_schema.sql     Schema dan data awal legacy
  sanitize_legacy_sql.py Script bantu sanitasi SQL legacy

tests/
  Feature/              Test fitur aplikasi
  Unit/                 Test unit
```

## Modul Aplikasi

| Modul | Fungsi |
| --- | --- |
| Dashboard | Menampilkan statistik dan aktivitas terbaru |
| Siswa | CRUD data siswa, detail siswa, export laporan |
| Kelas | CRUD data kelas dan wali kelas, export laporan |
| Absensi | Input dan rekap kehadiran siswa |
| Pelanggaran | Catatan pelanggaran siswa dan poin pelanggaran |
| Izin | Catatan surat izin siswa |
| Kebersihan | Penilaian kebersihan kelas |
| Keterlambatan | Catatan siswa terlambat |
| Prestasi | Catatan prestasi siswa |
| Pengaturan | Pengaturan tahun ajaran aktif |

## Prasyarat Instalasi

Pastikan perangkat sudah memiliki:

- PHP 8.3+
- Composer
- Node.js dan NPM
- MySQL atau MariaDB
- Ekstensi PHP umum Laravel, seperti `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, dan `zip`
- Laragon, XAMPP, Valet, Herd, atau web server lain yang mendukung PHP

## Cara Instalasi

### 1. Clone atau salin project

```bash
git clone <url-repository> mts-alihsan1
cd mts-alihsan1
```

Jika project sudah berada di folder Laragon seperti `C:\laragon\www\mts-alihsan1`, cukup masuk ke folder tersebut.

### 2. Install dependency PHP

```bash
composer install
```

### 3. Install dependency frontend

```bash
npm install
```

### 4. Buat file environment

```bash
cp .env.example .env
```

Pada Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Konfigurasi database

Buat database MySQL/MariaDB, misalnya:

```sql
CREATE DATABASE mts_alihsan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Lalu sesuaikan file `.env`:

```env
APP_NAME="MTs Al-Ihsan"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mts_alihsan
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

### 7. Import schema dan data awal

Project ini memiliki file schema legacy lengkap di:

```text
scripts/legacy_schema.sql
```

Import file tersebut ke database:

```bash
mysql -u root -p mts_alihsan < scripts/legacy_schema.sql
```

Jika menggunakan Laragon atau phpMyAdmin, buat database `mts_alihsan`, lalu import file `scripts/legacy_schema.sql` melalui menu Import.

Catatan: migration Laravel pada folder `database/migrations` hanya memuat sebagian struktur inti. Untuk menjalankan seluruh modul seperti login, izin, kebersihan, keterlambatan, dan prestasi, gunakan import `scripts/legacy_schema.sql`.

### 8. Build asset frontend

Untuk development:

```bash
npm run dev
```

Untuk production:

```bash
npm run build
```

### 9. Jalankan aplikasi

```bash
php artisan serve
```

Buka aplikasi di browser:

```text
http://localhost:8000
```

Jika menggunakan Laragon, aplikasi juga dapat diakses melalui virtual host yang disediakan Laragon, misalnya:

```text
http://mts-alihsan1.test
```

## Akun Login Awal

Jika menggunakan `scripts/legacy_schema.sql`, akun awal yang tersedia adalah:

```text
Username: admin
Password: password
Role: admin
```

Segera ubah password setelah aplikasi digunakan pada lingkungan produksi.

## Perintah Penting

```bash
# Menjalankan server Laravel
php artisan serve

# Menjalankan Vite development server
npm run dev

# Build asset production
npm run build

# Membersihkan cache konfigurasi
php artisan config:clear

# Membersihkan cache aplikasi
php artisan cache:clear

# Menjalankan test
php artisan test

# Menjalankan script test dari Composer
composer test
```

## Export Laporan

Beberapa modul menyediakan export:

- PDF menggunakan DomPDF.
- XLSX menggunakan class custom `App\Support\XlsxExporter`.

Route export tersedia antara lain untuk:

- Siswa
- Kelas
- Absensi
- Pelanggaran
- Izin
- Kebersihan
- Keterlambatan
- Prestasi

## Testing

Project menyediakan beberapa test pada folder `tests/Feature`, seperti:

- `DatabaseConnectionTest`
- `DashboardTest`
- `CrudPageTest`
- `AbsensiPageTest`
- `ExportRoutesTest`
- `LegacySchemaTest`
- `ModuleControllersTest`
- `RouteAccessTest`

Jalankan test dengan:

```bash
php artisan test
```

Pastikan database test sudah tersedia dan konfigurasi `.env` sesuai sebelum menjalankan test yang membutuhkan koneksi database.

## Catatan Pengembangan

- Autentikasi menggunakan session legacy dengan middleware `legacy.auth`.
- Model `User` memakai kolom `username`, bukan email.
- File `scripts/legacy_schema.sql` adalah acuan schema paling lengkap untuk modul yang ada saat ini.
- Layout utama berada di `resources/views/layouts/app.blade.php`.
- Definisi route aplikasi berada di `routes/web.php`.
- Styling utama berada di `public/css/app.css` dan `resources/css/app.css`.
- Export XLSX tidak bergantung pada library spreadsheet eksternal, tetapi menggunakan generator XLSX custom.

## Rekomendasi Deployment

Untuk production:

1. Set `.env`:

```env
APP_ENV=production
APP_DEBUG=false
```

2. Jalankan optimasi:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Pastikan folder berikut dapat ditulis oleh web server:

```text
storage/
bootstrap/cache/
```

4. Arahkan document root web server ke folder:

```text
public/
```

## Lisensi

Project ini dibuat untuk kebutuhan Sistem Pencatatan Siswa MTs Al-Ihsan Batujajar. Sesuaikan informasi lisensi dengan kebijakan pemilik project atau institusi.
