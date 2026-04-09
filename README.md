<div align="center">

# 🎓 Sistem Informasi Monitoring PKL / Magang

<img src="https://readme-typing-svg.demolab.com?font=Fira+Code&weight=700&size=28&pause=1000&color=3B82F6&center=true&vCenter=true&width=1000&lines=Laravel+Based+Monitoring+PKL+%2F+Magang+System;Modern+Dashboard+%7C+Multi+Role+%7C+Production+Ready;Admin+%7C+Siswa+%7C+Guru+Pembimbing+%7C+Pembimbing+PT" alt="Typing SVG" />

<br><br>

<img src="https://img.shields.io/badge/Laravel-Framework-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
<img src="https://img.shields.io/badge/PHP-8.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" />
<img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
<img src="https://img.shields.io/badge/Status-Production_Ready-16A34A?style=for-the-badge" />
<img src="https://img.shields.io/badge/UI-Modern_Dashboard-0EA5E9?style=for-the-badge" />
<img src="https://img.shields.io/badge/License-Educational-8B5CF6?style=for-the-badge" />

<br><br>

> **Aplikasi berbasis Laravel untuk memonitor kegiatan PKL / Magang secara digital, modern, terstruktur, dan profesional.**  
> Mendukung **multi-role**, **approval workflow**, **jurnal harian**, **absensi**, **laporan**, dan **dashboard monitoring**
> > **CREATOR BY ILHAM MU'ADZ FAKHRIZI AND TEAM (RIDWAN,DHIFKA,ADRIAS,REZA)**.

</div>

---

## 📌 Table of Contents

- [✨ Tentang Project](#-tentang-project)
- [🚀 Fitur Unggulan](#-fitur-unggulan)
- [🛠️ Tech Stack](#️-tech-stack)
- [⚡ Quick Install](#-quick-install)
- [⚙️ Cara Download & Install Project](#️-cara-download--install-project)
- [🗄️ Setup Database](#️-setup-database)
- [▶️ Menjalankan Project](#️-menjalankan-project)
- [🖼️ Preview Tampilan](#️-preview-tampilan)
- [🔐 Akun Login Default](#-akun-login-default)
- [📁 Struktur Folder](#-struktur-folder)
- [❗ Troubleshooting](#-troubleshooting)
- [🤝 Kontribusi](#-kontribusi)
- [💙 Support](#-support)

---

## ✨ Tentang Project

**Sistem Informasi Monitoring PKL / Magang** adalah aplikasi web berbasis **Laravel** yang dirancang untuk membantu proses pengelolaan dan pemantauan kegiatan **Praktik Kerja Lapangan (PKL)** atau **Magang** secara **real-time**, **efisien**, dan **terintegrasi**.

Sistem ini mempermudah koordinasi antara:

- **Admin Sekolah**
- **Siswa**
- **Guru Pembimbing**
- **Pembimbing Perusahaan / PT**

Dengan platform ini, seluruh proses seperti **penempatan siswa**, **absensi harian**, **jurnal kegiatan**, **approval**, **laporan**, hingga **monitoring progres** dapat dilakukan dalam satu sistem yang modern dan profesional.

---

## 🚀 Fitur Unggulan

### 👨‍💼 Role Management
- **Admin**
- **Siswa**
- **Guru Pembimbing**
- **Pembimbing Perusahaan / PT**

### 📊 Core Features

| Modul | Deskripsi |
|------|-----------|
| Dashboard Monitoring | Statistik siswa, perusahaan, absensi, jurnal, dan approval |
| Data Siswa | CRUD data siswa peserta PKL / Magang |
| Data Guru Pembimbing | CRUD guru pembimbing sekolah |
| Data Perusahaan / Instansi | CRUD tempat PKL / Magang |
| Penempatan PKL | Penempatan siswa ke perusahaan / instansi |
| Absensi Harian | Kehadiran harian siswa selama PKL |
| Jurnal Harian | Catatan kegiatan harian siswa |
| Approval Jurnal | Persetujuan jurnal oleh pembimbing perusahaan |
| Validasi Guru | Monitoring & validasi progres oleh guru pembimbing |
| Upload Laporan | Pengumpulan laporan PKL / Magang |
| Rekap Monitoring | Monitoring progres dan status penyelesaian |
| CRUD Lengkap | Seluruh master data dapat dikelola penuh |

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|------|-----------|
| Framework | Laravel |
| Backend | PHP 8.4+ |
| Database | MySQL / MariaDB |
| Frontend | Blade + Bootstrap / AdminLTE / ArchitectUI |
| Authentication | Laravel Auth / Custom Auth |
| Server | Apache / Nginx / Laravel Serve |

---

## ⚡ Quick Install

> **Untuk yang ingin langsung cepat jalan**, jalankan perintah berikut secara berurutan:

```bash
git clone https://github.com/username/nama-project.git
cd nama-project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
