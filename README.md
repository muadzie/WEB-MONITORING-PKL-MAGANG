<div align="center">

# 🎓 WEB MONITORING PKL / MAGANG

**Sistem Informasi Monitoring Praktik Kerja Lapangan (PKL) / Magang**

<br>

<img src="https://readme-typing-svg.demolab.com?font=Fira+Code&weight=700&size=22&pause=1000&color=3B82F6&center=true&vCenter=true&width=800&lines=Laravel+12;Multi-Role+%7C+Real-time+Monitoring+%7C+Geo-Attendance;Admin+%7C+Siswa+%7C+Guru+Pembimbing+%7C+Pembimbing+PT;Laporan+%7C+Logbook+%7C+Absensi+%7C+Penilaian+%7C+Export" alt="Typing SVG" />

<br>

<img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
<img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" />
<img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
<img src="https://img.shields.io/badge/AdminLTE-3.15-0EA5E9?style=for-the-badge" />
<img src="https://img.shields.io/badge/Livewire-3-4B32C3?style=for-the-badge&logo=livewire&logoColor=white" />
<img src="https://img.shields.io/badge/TailwindCSS-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" />
<img src="https://img.shields.io/badge/Jetstream-5-FF2D20?style=for-the-badge" />
<img src="https://img.shields.io/badge/Status-Production_Ready-16A34A?style=for-the-badge" />

<br>

> Aplikasi berbasis **Laravel 12** untuk memonitoring kegiatan PKL / Magang secara digital, modern, dan terstruktur.  
> Mendukung **multi-role**, **dual approval workflow**, **jurnal harian**, **absensi geolocation**, **laporan**, dan **dashboard monitoring real-time**.

</div>

---

## 📋 Daftar Isi

- [Tentang Project](#-tentang-project)
- [Fitur Unggulan](#-fitur-ungggulan)
- [Role & Hak Akses](#-role--hak-akses)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Entity Relationship Diagram](#-entity-relationship-diagram)
- [Tech Stack](#-tech-stack)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Panduan Instalasi](#-panduan-instalasi)
- [Cara Menjalankan](#-cara-menjalankan)
- [Akun Default](#-akun-default)
- [Struktur Route](#-struktur-route)
- [Struktur Folder](#-struktur-folder)
- [Troubleshooting](#-troubleshooting)
- [Kontribusi](#-kontribusi)
- [Lisensi & Kredit](#-lisensi--kredit)

---

## ✨ Tentang Project

**Sistem Informasi Monitoring PKL / Magang** adalah platform manajemen PKL berbasis web yang dirancang untuk sekolah menengah kejuruan (SMK) dan perguruan tinggi dalam mengelola seluruh siklus PKL — mulai dari **pendaftaran, penempatan, monitoring harian, absensi, penilaian, hingga pelaporan akhir**.

### Masalah yang Dipecahkan

| Masalah | Solusi |
|---------|--------|
| Monitoring manual & tidak terstruktur | Dashboard real-time untuk setiap role |
| Sulit tracking progres siswa | Jurnal harian + approval workflow |
| Absensi tidak terverifikasi | Geolocation-based attendance (radius 100m) |
| Komunikasi terbatas | Notifikasi in-app antar role |
| Data tercecer | Satu database terpusat + export XLS |
| Penilaian subjektif | Dual assessment (Dosen + PT) dengan kriteria jelas |

---

## 🚀 Fitur Unggulan

### 👨‍💼 Manajemen Multi-Role

| Role | Deskripsi |
|------|-----------|
| **Admin** | Manajemen semua data master, users, export, rekap |
| **Siswa** | Absensi, jurnal harian, izin/sakit, upload laporan, lihat nilai |
| **Guru Pembimbing (Dosen)** | Bimbingan, review logbook, review laporan, penilaian, absensi |
| **Pembimbing PT/Industri** | Monitoring, review logbook, penilaian, lihat laporan |

### 📊 Modul Lengkap

| Modul | Fitur Utama |
|-------|-------------|
| **Dashboard** | Statistik real-time, chart per bulan, aktivitas terbaru |
| **Data Master** | CRUD Users, Dosen, Perusahaan, Kelompok PKL |
| **Penempatan PKL** | Grouping siswa, assign dosen & perusahaan, status tracking |
| **Absensi Harian** | Check-in/out dengan GPS, validasi radius, bukti foto, auto-alfa |
| **Jurnal Harian (Logbook)** | Catatan kegiatan + foto, jam mulai/selesai |
| **Approval Workflow** | Dual approval (Dosen + PT) sebelum jurnal disetujui |
| **Izin & Sakit** | Pengajuan dengan bukti foto, approval dosen |
| **Laporan PKL** | Upload file (PDF/DOC), review dosen (setujui/revisi/tolak) |
| **Penilaian** | Dosen nilai (laporan, presentasi, sikap) + PT nilai (kinerja, disiplin, kerjasama, inisiatif) |
| **Notifikasi** | Notifikasi in-app untuk setiap event penting |
| **Export & Rekap** | XLS export untuk kelompok, nilai, siswa, absensi, tahunan |
| **Manajemen Map** | Penempatan dengan radius peta (latitude/longitude) |

---

## 👤 Role & Hak Akses

```
┌─────────────────────────────────────────────────────┐
│                    WEB MONITORING PKL                 │
├─────────┬──────────┬──────────┬──────────────────────┤
│  ADMIN  │  DOSEN   │    PT    │       SISWA          │
├─────────┼──────────┼──────────┼──────────────────────┤
│ • Users │ • Dashboard │ • Dashboard │ • Dashboard       │
│ • Dosen │ • Bimbingan │ • Monitoring │ • Absensi (GPS)  │
│ • PT    │ • Review    │ • Review    │ • Logbook Harian  │
│ • Siswa │   Logbook   │   Logbook   │ • Izin & Sakit    │
│ • Kelompok│ • Penilaian │ • Penilaian│ • Upload Laporan  │
│ • Export│ • Absensi   │ • Lihat    │ • Lihat Nilai     │
│ • Rekap │ • Izin/Sakit│   Laporan  │ • Edit Profile    │
│ • Laporan│ • Laporan   │            │                    │
└─────────┴──────────┴──────────┴──────────────────────┘
```

---

## 🏗️ Arsitektur Sistem

```
web-monitoring-pkl-magang/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/        # 9 Controllers
│   │   │   ├── Dosen/        # 4 Controllers
│   │   │   ├── Perusahaan/   # 2 Controllers
│   │   │   └── Siswa/        # 7 Controllers
│   │   ├── Middleware/
│   │   │   └── CheckRole.php # Custom role middleware
│   │   └── Requests/         # Form requests
│   ├── Models/               # 11 Eloquent Models
│   ├── Console/
│   │   └── Commands/
│   │       └── UpdateKelompokSelesai.php
│   └── Providers/            # Service providers
├── bootstrap/
│   └── app.php               # Middleware & exception config
├── config/
│   ├── adminlte.php          # AdminLTE theme (550+ lines)
│   ├── jetstream.php         # Jetstream (livewire stack)
│   ├── fortify.php           # Fortify auth config
│   └── ...
├── database/
│   └── migrations/           # 23 migration files
├── resources/
│   └── views/                # Blade templates (AdminLTE)
│       ├── layouts/
│       ├── admin/
│       ├── dosen/
│       ├── pt/
│       └── siswa/
├── routes/
│   ├── web.php               # Main routes (243 lines)
│   ├── api.php               # API routes
│   └── console.php           # Schedule & commands
└── public/                   # Assets & entry point
```

---

## 🗄️ Entity Relationship Diagram

### Struktur Database (11 Tabel Utama)

```
users (id, name, email, password, role, nomor_induk, phone, foto, is_active)
  ├── dosens (id, nidn, nama_dosen, user_id, gelar_depan, gelar_belakang, ...)
  ├── perusahaans (id, nama_perusahaan, user_id, latitude, longitude, ...)
  ├── kelompok_siswas (id, kelompok_pkl_id, siswa_id, nim, kelas, prodi)
  │     └── kelompok_pkls (id, nama_kelompok, dosen_id, perusahaan_id, status)
  ├── logbooks (id, kelompok_siswa_id, tanggal, kegiatan, status, approval_dosen, approval_pt, ...)
  ├── laporans (id, kelompok_siswa_id, judul_laporan, status, reviewer_dosen_id, ...)
  ├── absensis (id, siswa_id, kelompok_siswa_id, tanggal, jam_masuk, jam_keluar, latitude, longitude, ...)
  ├── ijin_sakit (id, siswa_id, jenis, tanggal_mulai, tanggal_selesai, status, ...)
  ├── penilaians (id, kelompok_siswa_id, penilai, nilai_laporan, nilai_kinerja, nilai_akhir, ...)
  └── notifikasis (id, user_id, judul, pesan, tipe, url, is_read)
```

### Approval Workflow Logbook

```
Siswa Membuat Logbook
        │
        ▼
   Status: Pending
        │
        ├──► Dosen Approve? ──► Pending (tunggu PT)
        │         │
        │         ▼
        │    Dosen Reject? ──► Ditolak
        │
        ├──► PT Approve? ──► Pending (tunggu Dosen)
        │         │
        │         ▼
        │    PT Reject? ──► Ditolak
        │
        ▼
  Kedua Approve? ──► Disetujui ✅
```

---

## 🛠️ Tech Stack

### Backend

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| Laravel Framework | ^12.0 | Core framework |
| PHP | ^8.2 | Runtime |
| Laravel Jetstream | ^5.4 | Auth scaffolding (Livewire stack) |
| Laravel Fortify | (bawaan Jetstream) | Auth backend (2FA, email verification) |
| Laravel Sanctum | ^4.0 | API token authentication |
| Livewire | ^3.6.4 | Dynamic UI components |
| Spatie Permission | ^7.2 | Role/permission management |
| Yajra DataTables | ^12.7 | Server-side datatables |

### Frontend

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| AdminLTE 3 | ^3.15 | Admin dashboard template |
| Bootstrap 4 | (bawaan AdminLTE) | CSS framework |
| TailwindCSS | ^4.0 | Utility CSS |
| Vite | ^7.0 | Frontend build tool |
| Alpine.js | (bawaan Livewire) | Interaktivitas UI |

### Database

| Teknologi | Fungsi |
|-----------|--------|
| MySQL / MariaDB | Database utama |
| Laravel Migrations | Version control database |
| Haversine Formula | Geolocation radius validation |

---

## ⚙️ Persyaratan Sistem

- **PHP** 8.2 atau lebih baru
- **Composer** 2.x
- **Node.js** 18+ & **NPM**
- **MySQL** 5.7+ / **MariaDB** 10.3+
- **Web Server** Apache / Nginx / Laragon / XAMPP
- **Extensions PHP:** `pdo_mysql`, `mbstring`, `gd`, `xml`, `curl`, `fileinfo`, `bcmath`, `openssl`

---

## 📦 Panduan Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/muadzie/WEB-MONITORING-PKL-MAGANG.git
cd WEB-MONITORING-PKL-MAGANG
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_monitoring_pkl
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate App Key

```bash
php artisan key:generate
```

### 5. Setup Database

```bash
php artisan migrate
```

> **Alternatif:** Import file SQL yang tersedia di folder `database/` jika ada.

### 6. Build Frontend Assets

```bash
npm run build
```

---

## ▶️ Cara Menjalankan

### Development Server

```bash
php artisan serve
```

Akses di **http://localhost:8000**

### Development Mode (Full Stack)

```bash
composer run dev
```

Perintah ini menjalankan secara bersamaan:
- `php artisan serve` (Laravel server)
- `php artisan queue:listen` (Queue worker)
- `php artisan pail` (Log viewer)
- `npm run dev` (Vite HMR)

---

## 🔐 Akun Default

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@example.com` | `password` |
| **Dosen** | `dosen@example.com` | `password` |
| **PT** | `pt@example.com` | `password` |
| **Siswa** | `siswa@example.com` | `password` |

> ⚠️ Ubah password setelah login pertama!

---

## 🧭 Struktur Route

### Web Routes (`routes/web.php`) — 50+ Route Endpoints

| Prefix | Auth | Middleware | Jumlah Route |
|--------|------|-----------|:-----------:|
| `/` | - | - | 1 (Home) |
| `/dashboard` | `auth:sanctum` | - | 1 |
| `/notifikasi` | `auth:sanctum` | - | 4 |
| `/profile` | `auth:sanctum` | - | 4 |
| `/approval` | `auth:sanctum` | - | 3 |
| `/admin` | `auth:sanctum` | `role:admin` | 25+ |
| `/dosen` | `auth:sanctum` | `role:dosen` | 25+ |
| `/pt` | `auth:sanctum` | `role:pt` | 15+ |
| `/siswa` | `auth:sanctum` | `role:siswa` | 15+ |

### API Routes (`routes/api.php`)

| Method | Endpoint | Middleware | Deskripsi |
|--------|----------|-----------|-----------|
| GET | `/api/user` | `auth:sanctum` | Current user data |

### Console Routes (`routes/console.php`)

| Command | Schedule | Deskripsi |
|---------|----------|-----------|
| `pkl:selesaikan` | Daily 00:05 | Auto-selesaikan kelompok yang sudah lewat tanggal |

---

## 📁 Struktur Folder

```
├── app/
│   ├── Console/
│   │   ├── Commands/
│   │   │   └── UpdateKelompokSelesai.php   # Artisan command
│   │   └── kernel.php → (removed, migrated to routes/console.php)
│   ├── Exports/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── DosenController.php
│   │   │   │   ├── PerusahaanController.php
│   │   │   │   ├── KelompokController.php
│   │   │   │   ├── ExportController.php
│   │   │   │   ├── LaporanController.php
│   │   │   │   ├── LogbookController.php
│   │   │   │   └── RekapController.php
│   │   │   ├── Dosen/
│   │   │   │   ├── BimbinganController.php
│   │   │   │   ├── PenilaianController.php
│   │   │   │   ├── AbsensiDosenController.php
│   │   │   │   └── IjinSakitController.php
│   │   │   ├── Perusahaan/
│   │   │   │   ├── MonitoringController.php
│   │   │   │   └── PenilaianPtController.php
│   │   │   ├── Siswa/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── AbsensiController.php
│   │   │   │   ├── IjinSakitController.php
│   │   │   │   ├── LogbookController.php
│   │   │   │   ├── LaporanController.php
│   │   │   │   ├── PenilaianController.php
│   │   │   │   └── ProfileController.php
│   │   │   ├── ApprovalController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── NotifikasiController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/
│   │   │   └── CheckRole.php
│   │   └── Requests/
│   ├── Livewire/                  # (Jetstream built-in components)
│   ├── Models/
│   │   ├── User.php
│   │   ├── Dosen.php
│   │   ├── Perusahaan.php
│   │   ├── KelompokPkl.php
│   │   ├── KelompokSiswa.php
│   │   ├── Logbook.php
│   │   ├── Laporan.php
│   │   ├── Penilaian.php
│   │   ├── Absensi.php
│   │   ├── IjinSakit.php
│   │   └── Notifikasi.php
│   └── Providers/
├── bootstrap/
│   └── app.php
├── config/
│   └── *.php                     # 15+ config files
├── database/
│   └── migrations/               # 23 migration files
├── public/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── admin/
│       ├── dosen/
│       ├── pt/
│       ├── siswa/
│       ├── auth/
│       ├── components/
│       ├── emails/
│       ├── errors/
│       ├── vendor/
│       └── welcome.blade.php
├── routes/
│   ├── web.php
│   ├── api.php
│   └── console.php
├── storage/
├── tests/
└── vendor/
```

---

## 🖼️ Preview Tampilan

> *(Tambahkan screenshot aplikasi di sini)*

| Halaman | Preview |
|---------|---------|
| Dashboard Admin | `[Screenshot]` |
| Data Siswa | `[Screenshot]` |
| Jurnal Harian | `[Screenshot]` |
| Absensi GPS | `[Screenshot]` |
| Penilaian | `[Screenshot]` |

---

## ❗ Troubleshooting

### Error "Target class [controller] does not exist"

```bash
php artisan optimize:clear
composer dump-autoload
```

### Error 403 Forbidden saat akses route

Pastikan user memiliki role yang sesuai. Cek di tabel `users` kolom `role`.

### Error 404 Not Found

```bash
php artisan route:list
```
Pastikan route terdaftar.

### Error "Class not found"

```bash
composer dump-autoload
```

### Error storage link

```bash
php artisan storage:link
```

### Error SQLSTATE[HY000] [1045]

Cek kembali konfigurasi database di `.env` — pastikan username, password, dan database name benar.

### Error Vite / Tailwind tidak jalan

```bash
npm install
npm run build
```

### Error Queue / Notifikasi tidak muncul

```bash
php artisan queue:work --daemon
```

---

## 🤝 Kontribusi

Kontribusi selalu diterima! Silakan:

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

### Tim Pengembang

| Nama | Role |
|------|------|
| **Ilham Mu'adz Fakhrizi** | Creator & Fullstack Developer |
| Ridwan | Developer |
| Dhifka | Developer |
| Adrias | Developer |
| Reza | Developer |

---

## 📝 Lisensi & Kredit

**© 2026 Ilham Mu'adz Fakhrizi & Team**

Project ini dikembangkan untuk tujuan edukasi dan monitoring PKL / Magang.

### Dibangun dengan

- [Laravel](https://laravel.com) — PHP Framework
- [AdminLTE 3](https://adminlte.io) — Admin Dashboard Template
- [Jetstream](https://jetstream.laravel.com) — Auth & Profile Scaffolding
- [Livewire](https://livewire.laravel.com) — Dynamic UI
- [TailwindCSS](https://tailwindcss.com) — Utility CSS
- [Vite](https://vitejs.dev) — Build Tool

---

<div align="center">
  <br>
  <strong>💙 Dibuat dengan penuh dedikasi untuk pendidikan Indonesia</strong>
  <br><br>
  <img src="https://img.shields.io/badge/Made_with-Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/Made_in-Indonesia-red?style=for-the-badge" />
  <br><br>
  <sub>Last updated: May 2026</sub>
</div>

<!-- Last updated: May 2026 -->

> *Project ini dikembangkan untuk tujuan edukasi monitoring PKL / Magang*
