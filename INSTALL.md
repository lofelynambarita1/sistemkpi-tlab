# 🚀 Panduan Instalasi — Sistem KPI

## Persyaratan
- PHP >= 8.2
- Composer
- MySQL >= 8.0 (atau MariaDB >= 10.4)
- Web server: Apache / Nginx (atau PHP built-in server untuk dev)

---

## Langkah Instalasi

### 1. Clone / Extract Project
```bash
# Taruh folder kpi-system di direktori web Anda
cd /var/www/html   # atau path pilihan Anda
```

### 2. Install Dependency PHP
```bash
cd kpi-system
composer install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env`, sesuaikan koneksi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kpi_system
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Buat Database
```sql
CREATE DATABASE kpi_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Jalankan Migration & Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 6. Set Permission Storage
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache   # Linux/Apache
```

### 7. Jalankan Aplikasi

**Untuk development:**
```bash
php artisan serve
# Buka http://localhost:8000
```

**Untuk production (Apache):**  
Arahkan DocumentRoot ke folder `public/`

---

## Akun Demo (Setelah Seeding)

| Role          | Email                  | Password      |
|---------------|------------------------|---------------|
| Associate     | budi@example.com       | password123   |
| Intermediate  | sari@example.com       | password123   |
| Senior        | andi@example.com       | password123   |
| Lead          | rina@example.com       | password123   |
| Principle     | doni@example.com       | password123   |
| **HR**        | **hr@example.com**     | **password123** |
| **Manager**   | **manager@example.com**| **password123** |

---

## Fitur Utama

### Staff (Associate / Intermediate / Senior / Lead / Principle)
- ✅ Dashboard target capaian tahunan dengan progress bar
- ✅ Buat & edit dokumen KPI (selama status Draft)
- ✅ Form 1: Penilaian Kinerja Hasil
  - Sub Form Jobdesc (4 input + 2 kalkulasi otomatis)
  - Sub Form Continues Improvement (3 input + 2 kalkulasi)
  - Sub Form Self Development (3 input + 2 kalkulasi)
  - Sub Form HR Activity (3 input + 2 kalkulasi)
- ✅ Form 2: Penilaian Kinerja Perilaku (1 input score + 5 field readonly)
- ✅ Submit dokumen KPI
- ✅ Lihat riwayat perubahan termasuk yang dilakukan HR/Manager

### HR & Manager
- ✅ Dashboard semua dokumen KPI staff yang disubmit
- ✅ Filter berdasarkan status, role, tahun, nama
- ✅ View detail dokumen KPI staff
- ✅ **Update** data setiap baris subform
- ✅ **Delete** dokumen dengan konfirmasi pop-up "Apakah Anda yakin ingin menghapus?"
- ✅ Ubah status dokumen (Submitted → Reviewed → Approved)
- ✅ Semua perubahan tercatat di **History** dan terlihat oleh staff

---

## Struktur Tabel Database

```
users                    — Semua actor (7 role)
kpi_documents            — Header dokumen KPI
kpi_jobdescs             — Sub form Jobdesc
kpi_continues_improvements — Sub form CI
kpi_self_developments    — Sub form Self Development
kpi_hr_activities        — Sub form HR Activity
kpi_kinerja_perilakus    — Sub form Kinerja Perilaku
kpi_document_histories   — Log semua perubahan
kpi_annual_targets       — Target & capaian tahunan per staff
```

---

## Kalkulasi Otomatis

| Sub Form | Field Kalkulasi | Rumus |
|---|---|---|
| Jobdesc | Jumlah Koefisien | Koef.OTB + Grade Project |
| Jobdesc | Total Mandays Penugasan | Jumlah Koefisien × Mandays Proyek |
| CI/SD/HR | Koefisien | Lookup dari Jenis Kegiatan |
| CI/SD/HR | Point | Koefisien × Mandays |
