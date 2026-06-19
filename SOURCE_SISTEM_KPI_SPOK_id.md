# Dokumen Sumber: Sistem KPI (Key Performance Indicator) (Format Sederhana SPOK)

> Dokumen ini merupakan dokumen sumber dengan format sederhana menggunakan pola SPOK (Subyek, Predikat, Obyek, Keterangan) untuk menjelaskan proses bisnis Sistem Penilaian KPI (Key Performance Indicator) Karyawan secara lengkap dan menyeluruh, mencakup seluruh aktor, proses, data, aturan bisnis, koefisien, formula, dan integrasi sistem.

---

## 1. Definisi Sistem

**Sistem KPI** adalah sistem berbasis web yang digunakan untuk mengelola seluruh proses penilaian kinerja (Key Performance Indicator) karyawan, mulai dari pengisian Form KPI (Penilaian Kinerja Hasil dan Penilaian Kinerja Perilaku), proses persetujuan (approval) berjenjang oleh Lead, Lead HR, dan Manager, hingga pengelolaan akun pengguna oleh Admin. Sistem menggunakan mekanisme **Internal Login + JWT**, di mana seluruh akun pengguna didaftarkan terlebih dahulu oleh Admin melalui `seed_akun`.

Sistem ini mengelola penilaian secara periodik per **quarter** (Q1–Q4) setiap tahunnya, dengan mekanisme **auto-submit** otomatis jika pengguna belum mengirimkan form pada batas waktu yang ditentukan. Setiap tahun, sistem akan membuat entri KPI baru (contoh: KPI 2025, KPI 2026, KPI 2027), dan pengguna dapat membuka kembali riwayat KPI tahun sebelumnya.

---

## 2. Aktor (Subyek Utama)

| No | Aktor | Group Actor | Peran | Alur Submit KPI |
|----|-------|-------------|-------|-----------------|
| A1 | Associate | Employee | Mengisi dan mengirimkan Form KPI miliknya sendiri | → Lead → Lead HR → Manager |
| A2 | Intermediate | Employee | Mengisi dan mengirimkan Form KPI miliknya sendiri | → Lead → Lead HR → Manager |
| A3 | Senior | Employee | Mengisi dan mengirimkan Form KPI miliknya sendiri | → Lead → Lead HR → Manager |
| A4 | Principle | Principle | Mengisi dan mengirimkan Form KPI miliknya sendiri | → Lead HR → Manager |
| A5 | Lead | Lead | Mereview KPI bawahan (Associate, Intermediate, Senior) dan mengisi Form KPI miliknya sendiri | → Lead HR → Manager |
| A6 | Lead HR | Lead HR | Mereview KPI bawahan (Associate, Intermediate, Senior, Lead, Principle) dan mengisi Form KPI miliknya sendiri | → Manager |
| A7 | Manager | Manager | Memberikan persetujuan akhir KPI yang sudah disetujui Lead HR; tidak mengisi KPI sendiri | Hanya reviewer akhir |
| A8 | Admin | Admin | Mengelola seluruh akun pengguna sistem; tidak terlibat dalam proses penilaian KPI | Tidak ada alur KPI |

**Fitur yang tersedia per Aktor:**

| Aktor | Login | Profile | Dashboard | History | Form KPI | Review KPI | Management User |
|-------|-------|---------|-----------|---------|----------|------------|-----------------|
| Associate | ✓ | ✓ | ✓ | ✓ | ✓ | ✗ | ✗ |
| Intermediate | ✓ | ✓ | ✓ | ✓ | ✓ | ✗ | ✗ |
| Senior | ✓ | ✓ | ✓ | ✓ | ✓ | ✗ | ✗ |
| Principle | ✓ | ✓ | ✓ | ✓ | ✓ | ✗ | ✗ |
| Lead | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✗ |
| Lead HR | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✗ |
| Manager | ✓ | ✓ | ✓ | ✓ | ✗ | ✓ | ✗ |
| Admin | ✓ | ✓ | ✓ | ✗ | ✗ | ✗ | ✓ |

**Contoh Data Aktor:**

| Nama | Role | Email | Atasan |
|------|------|-------|--------|
| Rian Pratama | Associate | rian.associate@company.com | Budi (Lead) |
| Dewi Lestari | Intermediate | dewi.intermediate@company.com | Budi (Lead) |
| Andi Wijaya | Senior | andi.senior@company.com | Budi (Lead) |
| Sari Indah | Principle | sari.principle@company.com | Maya (Lead HR) |
| Budi Santosa | Lead | budi.lead@company.com | Maya (Lead HR) |
| Maya Putri | Lead HR | maya.leadhr@company.com | Hendra (Manager) |
| Hendra Kusuma | Manager | hendra.manager@company.com | - |
| Tata Permana | Admin | tata.admin@company.com | - |

---

## 3. Proses Bisnis (Format SPOK)

### 3.1 Proses Login dan Logout

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Seluruh pengguna (Admin, Associate, Intermediate, Senior, Principle, Lead, Lead HR, Manager) |
| **Predikat** | Melakukan autentikasi ke |
| **Obyek** | Sistem menggunakan email dan password |
| **Keterangan** | Pengguna memasukkan email dan password yang telah didaftarkan oleh Admin melalui `seed_akun`. Sistem memverifikasi kredensial menggunakan mekanisme Internal Login dan menerbitkan token JWT jika valid. Pengguna juga dapat melakukan logout untuk mengakhiri sesi aktif. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Email | rian.associate@company.com |
| Password | ******** |
| Status Login | Berhasil / Gagal |
| Token | JWT (disimpan di sesi/klien) |

---

### 3.2 Proses Melihat Profile dan Ubah Password

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Seluruh pengguna |
| **Predikat** | Melihat dan mengubah |
| **Obyek** | Data profil pribadi dan password akun |
| **Keterangan** | Pengguna dapat melihat informasi profil: Nama Lengkap, Email, Jabatan, Divisi, dan Role. Pengguna juga dapat mengubah password akun miliknya sendiri melalui menu Ubah Password. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Nama Lengkap | Rian Pratama |
| Email | rian.associate@company.com |
| Jabatan | Software Engineer |
| Divisi | Engineering |
| Role | Associate |
| Ubah Password | Input Password Lama + Password Baru + Konfirmasi Password Baru |

---

### 3.3 Proses Melihat Dashboard

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Seluruh pengguna (informasi berbeda sesuai role) |
| **Predikat** | Melihat |
| **Obyek** | Ringkasan informasi KPI sesuai role masing-masing |
| **Keterangan** | Setiap role memiliki tampilan dashboard yang berbeda sesuai tanggung jawabnya. |

**Contoh Data Dashboard per Role:**

| Role | Informasi yang Ditampilkan |
|------|----------------------------|
| Admin | Jumlah pengguna berdasarkan role |
| Associate / Intermediate / Senior | Total target KPI yang harus dicapai, Total KPI yang telah diperoleh, Persentase progress KPI, Status Form KPI terakhir, Informasi periode penilaian yang sedang berjalan, Petunjuk pengisian Form KPI |
| Principle | Total target KPI yang harus dicapai, Total KPI yang telah diperoleh, Persentase progress KPI, Status Form KPI terakhir, Informasi periode penilaian yang sedang berjalan, Petunjuk pengisian Form KPI |
| Lead | Total Employee (Associate, Intermediate, Senior) yang sudah submit KPI, Total Employee (Associate, Intermediate, Senior), Total target KPI yang harus dicapai, Total KPI yang telah diperoleh, Persentase progress KPI, Status Form KPI terakhir, Informasi periode penilaian yang sedang berjalan, Petunjuk pengisian Form KPI |
| Lead HR | Total KPI menunggu review, Total KPI telah di-approve, Total KPI ditolak, Total bawahan yang menjadi tanggung jawab Lead HR, Jumlah KPI berdasarkan status, Total target KPI yang harus dicapai, Total KPI yang telah diperoleh, Persentase progress KPI, Status Form KPI terakhir, Informasi periode penilaian yang sedang berjalan, Petunjuk pengisian Form KPI |
| Manager | Total KPI menunggu persetujuan, Total KPI telah di-approve, Total KPI ditolak, Total pengguna dalam sistem, Distribusi KPI berdasarkan status |

---

### 3.4 Proses Melihat History

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR, Manager |
| **Predikat** | Melihat |
| **Obyek** | Riwayat seluruh aktivitas terkait Form KPI |
| **Keterangan** | History menampilkan log aktivitas yang mencakup: Create Form KPI, Update Form KPI, Submit Form KPI, Pengembalian revisi, Approval Lead, Approval Lead HR, Approval Manager, Komentar reviewer pada setiap tahap approval, Waktu kejadian, dan Pelaku yang melakukan tindakan. Khusus Manager, History hanya menampilkan: Pengembalian revisi, Approval Lead, Approval Lead HR, Approval Manager, Komentar reviewer, Waktu kejadian, dan Pelaku (tanpa Create/Update/Submit). |

**Contoh Data:**

| Waktu Kejadian | Aktivitas | Pelaku | Komentar |
|----------------|-----------|--------|----------|
| 01/06/2026 09:00 | Create Form KPI | Rian (Associate) | - |
| 03/06/2026 14:00 | Update Form KPI | Rian (Associate) | - |
| 05/06/2026 08:30 | Submit Form KPI | Rian (Associate) | - |
| 06/06/2026 10:00 | Approval Lead | Budi (Lead) | "KPI sudah sesuai, lanjutkan" |
| 07/06/2026 11:00 | Approval Lead HR | Maya (Lead HR) | "Lanjutkan ke Manager" |
| 08/06/2026 13:00 | Approval Manager | Hendra (Manager) | "Approved, kerja bagus" |

---

### 3.5 Proses Mengisi Form KPI — Subform Jobdesc

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengisi |
| **Obyek** | Data Jobdesc pada Form Penilaian Kinerja Hasil |
| **Keterangan** | Pengguna mengisi 4 field input: (A) Penilaian Koefisien On Time dan On Budget via dropdown, (B) Penilaian Grade Project via dropdown, (C) Nama Kegiatan dan Bukti berupa teks bebas, dan (D) Mandays Proyek berupa positive integer > 0. Sistem secara otomatis menghitung 2 field read-only: "Jumlah Koefisien Ontime OnBudget + Koefisien Grade Project" dan "Total Mandays Penugasan". Subform mendukung multi-row via tombol "Tambah Baris" dan setiap baris dapat dihapus sebelum form disubmit. |

**Contoh Data:**

| Field | Tipe | Nilai Contoh |
|-------|------|-------------|
| Penilaian Koefisien On Time dan On Budget | Dropdown | Sesuai Ekspektasi (95%–105%) → koefisien 1,00 |
| Penilaian Grade Project | Dropdown | Grade B (Role Associate) → koefisien 1,125 |
| Jumlah Koefisien (otomatis) | Read-only | 1,00 + 1,125 = 2,125 |
| Nama Kegiatan dan Bukti | Text Area | "Pengembangan modul laporan KPI, bukti: dokumentasi di repository" |
| Mandays Proyek | Positive Integer | 10 |
| Total Mandays Penugasan (otomatis) | Read-only | (10 × 2,125) ÷ 2 = 10,625 |

**Rumus:**

| Field | Rumus |
|-------|-------|
| Jumlah Koefisien Ontime OnBudget + Koefisien Grade Project | Koefisien On Time/On Budget + Koefisien Grade Project |
| Total Mandays Penugasan | (Mandays Proyek × Jumlah Koefisien) ÷ 2 |

---

### 3.6 Proses Mengisi Form KPI — Subform Continuous Improvement (CI)

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengisi |
| **Obyek** | Data Continuous Improvement pada Form Penilaian Kinerja Hasil |
| **Keterangan** | Pengguna mengisi 3 field input: (A) Jenis Kegiatan/Bukti CI via dropdown, (B) Kegiatan CI berupa teks bebas, dan (C) Mandays CI berupa positive integer > 0. Sistem secara otomatis mengisi 2 field read-only: Koefisien CI (berdasarkan pilihan Jenis Kegiatan) dan Point CI (hasil perkalian Koefisien × Mandays). Subform mendukung multi-row via tombol "Tambah Baris" dan setiap baris dapat dihapus sebelum form disubmit. |

**Contoh Data:**

| Field | Tipe | Nilai Contoh |
|-------|------|-------------|
| Jenis Kegiatan/Bukti CI | Dropdown | "Didaftarkan pada Product & Research, mendapat surat tugas dari Manajer – CI Individu" |
| Koefisien CI (otomatis) | Read-only | 0,75 |
| Kegiatan CI | Text Area | "Membuat tools otomatisasi testing untuk modul KPI" |
| Mandays CI | Positive Integer | 5 |
| Point CI (otomatis) | Read-only | 0,75 × 5 = 3,75 |

**Rumus:**

| Field | Rumus |
|-------|-------|
| Point CI | Koefisien CI × Mandays CI |

---

### 3.7 Proses Mengisi Form KPI — Subform Self Development (SD)

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengisi |
| **Obyek** | Data Self Development pada Form Penilaian Kinerja Hasil |
| **Keterangan** | Pengguna mengisi 3 field input: (A) Jenis Kegiatan SD via dropdown, (B) Kegiatan SD berupa teks bebas, dan (C) Mandays SD berupa positive integer > 0. Sistem secara otomatis mengisi 2 field read-only: Koefisien SD (berdasarkan pilihan Jenis Kegiatan SD) dan Point SD (hasil perkalian Koefisien SD × Mandays SD). Subform mendukung multi-row via tombol "Tambah Baris" dan setiap baris dapat dihapus sebelum form disubmit. |

**Contoh Data:**

| Field | Tipe | Nilai Contoh |
|-------|------|-------------|
| Jenis Kegiatan SD | Dropdown | "Mengikuti Sertifikasi BNSP" |
| Koefisien SD (otomatis) | Read-only | 0,75 |
| Kegiatan SD | Text Area | "Sertifikasi BNSP Junior Web Developer" |
| Mandays SD | Positive Integer | 3 |
| Point SD (otomatis) | Read-only | 0,75 × 3 = 2,25 |

**Rumus:**

| Field | Rumus |
|-------|-------|
| Point SD | Koefisien SD × Mandays SD |

---

### 3.8 Proses Mengisi Form KPI — Subform HR Activity (HRA)

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengisi |
| **Obyek** | Data HR Activity pada Form Penilaian Kinerja Hasil |
| **Keterangan** | Pengguna mengisi 3 field input: (A) Jenis Kegiatan HRA via dropdown, (B) Kegiatan HRA berupa teks bebas, dan (C) Mandays HRA berupa positive integer > 0. Sistem secara otomatis mengisi 2 field read-only: Koefisien HRA (berdasarkan pilihan Jenis Kegiatan HRA) dan Point HRA (hasil perkalian Koefisien HRA × Mandays HRA). Hasil seluruh baris diakumulasikan menjadi Total Point HRA di bagian bawah tabel. Subform mendukung multi-row via tombol "Tambah Baris" dan setiap baris dapat dihapus sebelum form disubmit. |

**Contoh Data:**

| Field | Tipe | Nilai Contoh |
|-------|------|-------------|
| Jenis Kegiatan HRA | Dropdown | "Ikut sebagai peserta (kegiatan non pelatihan)" |
| Koefisien HRA (otomatis) | Read-only | 0,75 |
| Kegiatan HRA | Text Area | "Employee Gathering TLab" |
| Mandays HRA | Positive Integer | 4 |
| Point HRA (otomatis) | Read-only | 0,75 × 4 = 3,00 |
| Total Point HRA (akumulasi) | Read-only | 3,00 |

**Rumus:**

| Field | Rumus |
|-------|-------|
| Point HRA | Koefisien HRA × Mandays HRA |
| Total Point HRA | Jumlah seluruh Point HRA dari semua baris |

---

### 3.9 Proses Mengisi Form KPI — Sub Form Total Cuti

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengisi |
| **Obyek** | Jumlah total hari cuti yang telah digunakan selama periode evaluasi |
| **Keterangan** | Sub Form Total Cuti berisi 1 field bernama "Total Cuti" yang bersifat opsional (default 0). Nilai yang dimasukkan harus berupa bilangan bulat ≥ 0 dan tidak boleh melebihi batas maksimum 12 hari. Field ini hanya dapat diisi atau diubah saat status KPI adalah Draft atau Need Revision; setelah Submitted, field terkunci. Nilai Total Cuti digunakan untuk menghitung Hari Kerja Efektif dan Target Point Minimal 1 Tahun, yang dihitung ulang secara otomatis setiap kali nilai berubah. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Total Cuti | 2 hari |
| Total Hari Kerja Tahunan | 240 hari (tetap) |
| Hari Kerja Efektif | 240 − 2 = 238 hari |
| Batas Maksimum Cuti | 12 hari |
| Status saat bisa diubah | Draft / Need Revision |
| Status saat terkunci | Submitted / Approved |

**Rumus Target Point per Kategori (contoh Associate, cuti 2 hari):**

| Kategori | Rumus | Nilai |
|----------|-------|-------|
| Hari Kerja Efektif | 240 − Total Cuti | 238 |
| Target Point Job Desk | 85% × Hari Kerja Efektif × Koefisien Role | 85% × 238 × 1,00 = 202,3 → 202 |
| Target Point Self Development | 5% × Hari Kerja Efektif × Koefisien Role | 5% × 238 × 1,00 = 11,9 → 12 |
| Target Point HR Activity | 5% × Hari Kerja Efektif | 5% × 238 = 11,9 → 12 |
| Target Point CI | 5% × Hari Kerja Efektif × Koefisien Role | 5% × 238 × 1,00 = 11,9 → 12 |
| Target Point Minimal 1 Tahun | Jumlah seluruh Target Point | 202 + 12 + 12 + 12 = 238 poin |

> Pembulatan menggunakan aturan matematika: nilai desimal ≥ 0,5 dibulatkan ke atas, < 0,5 dibulatkan ke bawah. Target Point HR Activity tidak menggunakan koefisien role karena berlaku sama untuk seluruh pengguna.

---

### 3.10 Proses Mengisi Form KPI — Penilaian Kinerja Perilaku (14 Aspek)

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengisi |
| **Obyek** | 14 subform penilaian perilaku berbentuk accordion dengan rating scale 1–5 |
| **Keterangan** | Form Penilaian Kinerja Perilaku terdiri dari 14 aspek. Setiap subform memiliki 4 field read-only (Definisi, Minimum Capaian, Indikator level 1–5, dan Deskripsi) serta 1 field input yaitu Score (dropdown 1–5). Field "Deskripsi" otomatis menampilkan teks Indikator sesuai level Score yang dipilih. Score wajib diisi pada semua 14 aspek sebelum form dapat disubmit. |

**Contoh Data (Subform Integritas):**

| Field | Tipe | Nilai Contoh |
|-------|------|-------------|
| Definisi | Read-only | "Memiliki pribadi yang jujur dengan dapat menjaga kerahasiaan informasi pribadi, tim, dan Perusahaan" |
| Minimum Capaian – Indikator | Read-only | 2 |
| Minimum Capaian – Keterangan | Read-only | "Mampu bertanggung jawab atas tindakan dan keputusan sendiri; Mengakui kesalahan dan bertanggung jawab atas konsekuensinya" |
| Score | Dropdown (1–5) | 3 |
| Deskripsi (otomatis) | Read-only | "Mampu bertindak secara konsisten sesuai nilai-nilai etika dalam berbagai situasi; Membuat keputusan berdasarkan prinsip-prinsip etika yang kuat" |

---

### 3.11 Proses Submit Form KPI

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengirimkan |
| **Obyek** | Form Penilaian Kinerja Hasil dan Form Penilaian Kinerja Perilaku secara bersamaan |
| **Keterangan** | Saat pengguna menekan tombol Submit, kedua form (Kinerja Hasil dan Kinerja Perilaku) tersubmit sekaligus. Status KPI berubah dari Draft menjadi Submitted, seluruh data terkunci dari perubahan, dan alur approval berjenjang dimulai sesuai role pengirim. `current_approver_id` diset ke reviewer pertama sesuai alur. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Status Sebelum Submit | Draft Q1 |
| Status Sesudah Submit | Submitted Q1 |
| current_approver_id Awal | Lead (Associate/Intermediate/Senior/Lead) / Lead HR (Principle/Lead HR) |
| Data Form | Terkunci, tidak dapat diubah |
| Waktu Submit | 05/04/2026 08:30:00 |

---

### 3.12 Proses Auto-Submit Sistem

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Sistem (Scheduler / Cron Job) |
| **Predikat** | Secara otomatis mengirimkan |
| **Obyek** | Form KPI yang masih berstatus Draft pada batas waktu yang telah ditentukan per quarter |
| **Keterangan** | Jika pengguna tidak melakukan submit manual hingga batas waktu tiap quarter, sistem otomatis mengubah status Draft menjadi Submitted. Sistem menangani logika khusus "KPI tahun X, Q4 auto-submit pada awal tahun X+1". Setiap quarter memiliki batas waktu tetap yang berlaku setiap tahunnya. |

**Batas Waktu Auto-Submit per Quarter:**

| Quarter | Batas Waktu | Status Sebelum | Status Sesudah |
|---------|-------------|----------------|----------------|
| Q1 | 14 April (tahun berjalan) | Draft Q1 | Submitted Q1 |
| Q2 | 14 Juli (tahun berjalan) | Draft Q2 | Submitted Q2 |
| Q3 | 14 Oktober (tahun berjalan) | Draft Q3 | Submitted Q3 |
| Q4 | 14 Januari (tahun berikutnya) | Draft Q4 | Submitted Q4 |

**Contoh:**

| Kasus | Nilai |
|-------|-------|
| KPI Tahun | 2026 |
| Quarter | Q4 |
| Auto-Submit Pada | 14 Januari 2027 |
| Logika Khusus | KPI 2026 Q4 disubmit otomatis di awal tahun 2027 |

---

### 3.13 Proses Review KPI oleh Lead

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Lead |
| **Predikat** | Mereview, menyetujui, atau menolak |
| **Obyek** | Form KPI milik Associate, Intermediate, dan Senior yang berstatus Submitted dengan `current_approver_id` = Lead |
| **Keterangan** | Lead melihat daftar nama Employee yang sudah mengirimkan KPI. Lead dapat menekan "Review KPI" untuk masuk ke tampilan form pengguna tersebut (mode Review), dan menekan "Kembali" untuk keluar. Jika "Approve KPI": `current_approver_id` berubah menjadi Lead HR, status KPI tetap Submitted, Lead dapat menambahkan komentar. Jika "Reject KPI": status KPI berubah menjadi Need Revision (indikator warna biru), Lead dapat menambahkan komentar. Tersedia fitur Bulk Action (Approve Selected / Reject Selected) dengan dialog konfirmasi dan 1 field komentar untuk semua data terpilih. |

**Contoh Data:**

| Field | Nilai (Approve) | Nilai (Reject) |
|-------|-----------------|----------------|
| Status Sebelum | Submitted Q1 | Submitted Q1 |
| Status Sesudah | Submitted Q1 | Need Revision Q1 |
| current_approver_id Sesudah | Lead HR | Tidak berubah (tetap Lead) |
| Indikator Warna Need Revision | - | Biru |
| Komentar | "KPI sudah sesuai, lanjutkan" | "Mohon lengkapi bukti pada Subform Jobdesc" |
| Review Level Tersimpan | Lead | Lead |

---

### 3.14 Proses Review KPI oleh Lead HR

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Lead HR |
| **Predikat** | Mereview, menyetujui, atau menolak |
| **Obyek** | Form KPI milik Associate, Intermediate, Senior, Lead, dan Principle yang berstatus Submitted dengan `current_approver_id` = Lead HR |
| **Keterangan** | Lead HR melihat daftar Nama Employee dan Lead dari setiap pengguna yang telah mengirimkan KPI. Lead HR dapat menekan "Review KPI" untuk masuk ke tampilan form pengguna, dan menekan "Kembali" untuk keluar. Jika "Approve KPI": `current_approver_id` berubah menjadi Manager, status KPI tetap Submitted, Lead HR dapat menambahkan komentar. Jika "Reject KPI": status KPI berubah menjadi Need Revision (indikator warna biru), Lead HR dapat menambahkan komentar. Untuk KPI Lead HR sendiri, form dikirim langsung ke Manager. Tersedia fitur Bulk Action (Approve Selected / Reject Selected). |

**Contoh Data:**

| Field | Nilai (Approve) | Nilai (Reject) |
|-------|-----------------|----------------|
| Status Sebelum | Submitted Q1 | Submitted Q1 |
| Status Sesudah | Submitted Q1 | Need Revision Q1 |
| current_approver_id Sesudah | Manager | Tidak berubah (tetap Lead HR) |
| Indikator Warna Need Revision | - | Biru |
| Komentar | "Penilaian sudah sesuai, lanjutkan ke Manager" | "Penilaian perilaku perlu dilengkapi" |
| Review Level Tersimpan | Lead HR | Lead HR |

---

### 3.15 Proses Review KPI oleh Manager

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Manager |
| **Predikat** | Mereview, menyetujui, atau menolak |
| **Obyek** | Form KPI yang sudah di-Approve oleh Lead HR (`current_approver_id` = Manager) |
| **Keterangan** | Manager melihat daftar KPI yang telah disetujui Lead HR. Manager dapat menekan "Review KPI" untuk masuk ke tampilan form pengguna, dan menekan "Kembali" untuk keluar. Jika "Approve KPI": status KPI berubah menjadi Approved (indikator warna hijau), merupakan persetujuan akhir. Jika "Reject KPI": status KPI berubah menjadi Need Revision (indikator warna biru). Pada kedua pilihan, Manager dapat menambahkan komentar. Tersedia fitur Bulk Action (Import KPI ke Excel, Approve Selected, Reject Selected). |

**Contoh Data:**

| Field | Nilai (Approve) | Nilai (Reject) |
|-------|-----------------|----------------|
| Status Sebelum | Submitted Q1 | Submitted Q1 |
| Status Sesudah | Approved Q1 | Need Revision Q1 |
| Indikator Warna Approved | Hijau | - |
| Indikator Warna Need Revision | - | Biru |
| Komentar | "Excellent, disetujui." | "Data CI belum memadai, harap revisi." |
| Review Level Tersimpan | Manager | Manager |

---

### 3.16 Proses Revisi Form KPI

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Memperbaiki dan mengirim ulang |
| **Obyek** | Form KPI yang dikembalikan reviewer dengan status Need Revision |
| **Keterangan** | Setelah form dikembalikan (oleh Lead, Lead HR, atau Manager), status berubah menjadi Need Revision. Data yang sebelumnya terkunci kembali dapat diubah, termasuk field Total Cuti. Pengguna memperbaiki data dan melakukan submit ulang. Alur approval dimulai kembali dari reviewer pertama sesuai role pengirim. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Status Sebelum Revisi | Need Revision Q2 |
| Komentar Reviewer | "Mohon lengkapi bukti kegiatan CI dan perbaiki score Perilaku." |
| Tindakan Pengguna | Edit data → Submit ulang |
| Status Setelah Submit Ulang | Submitted Q2 |
| current_approver_id | Kembali ke reviewer pertama (Lead untuk Employee) |

---

### 3.17 Proses Bulk Action oleh Lead, Lead HR, dan Manager

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Lead, Lead HR, Manager |
| **Predikat** | Menyetujui atau menolak secara massal |
| **Obyek** | Beberapa data Form KPI yang dipilih sekaligus |
| **Keterangan** | Sistem menyediakan fitur Select All (memilih seluruh data pada halaman saat ini maupun seluruh hasil pencarian) dan Deselect All. Untuk "Approve Selected" dan "Reject Selected", sistem wajib menampilkan dialog konfirmasi sebelum dieksekusi, lalu menyediakan 1 field komentar yang diterapkan ke seluruh data terpilih. Selain itu tersedia fasilitas pencarian (search) dan pengurutan (sorting) pada kolom. Khusus Manager, tersedia tambahan fitur Import KPI pengguna ke dalam format Excel. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Data Terpilih | 5 KPI Karyawan |
| Aksi | Approve Selected |
| Dialog Konfirmasi | "Apakah Anda yakin ingin menyetujui 5 data terpilih?" |
| Komentar (1 field untuk semua) | "Approve batch periode Q1 2026" |
| Hasil | 5 KPI berubah status/current_approver_id sesuai role reviewer |

**Fitur Bulk Action per Aktor:**

| Aktor | Approve Selected | Reject Selected | Import KPI (Excel) | Delete Selected |
|-------|:----------------:|:---------------:|:------------------:|:---------------:|
| Lead | ✓ | ✓ | ✗ | ✗ |
| Lead HR | ✓ | ✓ | ✗ | ✗ |
| Manager | ✓ | ✓ | ✓ | ✗ |
| Admin | ✗ | ✗ | ✓ (import user) | ✓ |

---

### 3.18 Proses Management User oleh Admin

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Admin |
| **Predikat** | Mengelola |
| **Obyek** | Seluruh akun pengguna sistem |
| **Keterangan** | Admin dapat menambah pengguna, mengubah data pengguna, menonaktifkan/menghapus pengguna, mengelola password, mengimpor pengguna massal (Excel/CSV), dan mengatur role pengguna (associate, intermediate, senior, lead, principle, manager). Tersedia fitur Bulk Action: Import pengguna massal dan Delete Selected (dengan dialog konfirmasi). Tersedia pula fitur Select All, Deselect All, pencarian (search), dan pengurutan (sorting). Pada setiap baris data tersedia menu aksi (row action): view detail, update data, delete data, dan atur role. Admin tidak memiliki akses ke proses penilaian atau approval KPI. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Aksi | Import Pengguna (Excel/CSV) |
| Jumlah Data Diimpor | 20 pengguna baru |
| Aksi Lain | Delete Selected (3 pengguna) |
| Dialog Konfirmasi Delete | "Apakah Anda yakin ingin menghapus 3 pengguna terpilih?" |
| Data User Dikelola | Nama Lengkap, Email, Jabatan, Divisi, Role, Status Aktif/Nonaktif, Password |
| Role yang Dapat Diatur | Associate, Intermediate, Senior, Lead, Principle, Manager |

---

## 4. Status KPI dan Alur Perpindahan Status

### 4.1 Daftar Status KPI

| No | Status | Deskripsi | Indikator Warna |
|----|--------|-----------|----------------|
| 1 | Draft (Q1/Q2/Q3/Q4) | Form belum disubmit, data masih dapat diubah | - |
| 2 | Submitted (Q1/Q2/Q3/Q4) | Form telah dikirim, data terkunci, alur approval berjalan | - |
| 3 | Need Revision (Q1/Q2/Q3/Q4) | Form dikembalikan reviewer, data dapat diubah kembali | Biru |
| 4 | Waiting Lead | Logika UI: form menunggu review Lead (berdasarkan current_approver_id) | - |
| 5 | Waiting Lead HR | Logika UI: form menunggu review Lead HR (berdasarkan current_approver_id) | - |
| 6 | Waiting Manager | Logika UI: form menunggu review Manager (berdasarkan current_approver_id) | - |
| 7 | Approved (Q1/Q2/Q3/Q4) | Form telah memperoleh persetujuan akhir dari Manager | Hijau |

> Status "Waiting Lead", "Waiting Lead HR", dan "Waiting Manager" disimpan di database hanya sebagai logika UI berdasarkan nilai `current_approver_id`, bukan sebagai nilai status tersendiri.

### 4.2 Diagram Alur Status

```
[Draft] 
  → (Submit Manual / Auto-Submit) → [Submitted]
  
[Submitted]
  → (Approve Lead)    → current_approver_id = Lead HR  → [Submitted, Waiting Lead HR]
  → (Reject Lead)     → [Need Revision]
  → (Approve Lead HR) → current_approver_id = Manager  → [Submitted, Waiting Manager]
  → (Reject Lead HR)  → [Need Revision]
  → (Approve Manager) → [Approved]
  → (Reject Manager)  → [Need Revision]

[Need Revision]
  → (Submit Ulang Pengguna) → [Submitted] → (alur approval dari awal)
```

---

## 5. Data yang Dikelola

### 5.1 Data User

| Atribut | Tipe Data | Contoh Nilai |
|---------|-----------|-------------|
| user_id | ID unik | U001 |
| nama_lengkap | String | Rian Pratama |
| email | String | rian.associate@company.com |
| password | String (terenkripsi) | ******** |
| atasan_id | FK → user_id | U005 (Budi, Lead) |
| role_id | ENUM | Associate |
| status_akun | ENUM | Aktif / Nonaktif |
| created_at | Timestamp | 01/01/2026 08:00:00 |
| updated_at | Timestamp | 01/06/2026 09:00:00 |

### 5.2 Data KPI

| Atribut | Tipe Data | Contoh Nilai |
|---------|-----------|-------------|
| kpi_id | ID unik | KPI20260001 |
| employee_id | FK → user_id | U001 |
| current_approver_id | FK → user_id | U005 (Lead) / U006 (Lead HR) / U007 (Manager) |
| periode_penilaian | String | Semester 1 |
| tahun | Integer | 2026 |
| status | String | Draft / Submitted / Approved / Need Revision |
| total_nilai | Decimal | 7,85 |
| quarter | ENUM | Q1 / Q2 / Q3 / Q4 |
| created_at | Timestamp | 01/06/2026 09:00:00 |
| updated_at | Timestamp | 08/06/2026 13:00:00 |

### 5.3 Data KPI_Hasil

| Atribut | Tipe Data | Contoh Nilai |
|---------|-----------|-------------|
| hasil_id | ID unik | H0001 |
| kpi_id | FK → kpi_id | KPI20260001 |
| jenis_subform | ENUM | Jobdesc / Continuous Improvement / Self Development / HR Activity |
| jenis_kegiatan | String | "Didaftarkan pada Product & Research – CI Individu" |
| kegiatan | String | "Membuat tools otomatisasi testing" |
| indikator | String | "Penilaian Koefisien On Time dan On Budget" |
| koefisien | Decimal | 1,75 |
| mandays | Integer | 5 |
| point | Decimal | 8,75 |
| created_at | Timestamp | 01/06/2026 09:10:00 |
| updated_at | Timestamp | 01/06/2026 09:20:00 |

### 5.4 Data KPI_Perilaku

| Atribut | Tipe Data | Contoh Nilai |
|---------|-----------|-------------|
| perilaku_id | ID unik | P0001 |
| kpi_id | FK → kpi_id | KPI20260001 |
| aspek_id | FK → aspek_id | INTEGRITAS |
| score | Integer (1–5) | 3 |
| deskripsi | String | "Mampu bertindak secara konsisten sesuai nilai-nilai etika dalam berbagai situasi" |
| created_at | Timestamp | 01/06/2026 09:30:00 |
| updated_at | Timestamp | 01/06/2026 09:30:00 |

### 5.5 Data Master_Perilaku

| Atribut | Tipe Data | Contoh Nilai |
|---------|-----------|-------------|
| aspek_id | ID unik | INTEGRITAS |
| aspek_perilaku | String | Integritas |
| definisi | String | "Memiliki pribadi yang jujur dengan dapat menjaga kerahasiaan informasi pribadi, tim, dan Perusahaan" |
| minimum_capaian_indikator | Integer | 2 |
| minimum_capaian_keterangan | String | "Mampu bertanggung jawab atas tindakan dan keputusan sendiri; Mengakui kesalahan dan bertanggung jawab atas konsekuensinya" |
| indikator_1 | String | "Mengikuti aturan dan prosedur yang ditetapkan; Membutuhkan pengawasan untuk memastikan kepatuhan" |
| indikator_2 | String | "Mampu bertanggung jawab atas tindakan dan keputusan sendiri; Mengakui kesalahan dan bertanggung jawab atas konsekuensinya" |
| indikator_3 | String | "Mampu bertindak secara konsisten sesuai nilai-nilai etika dalam berbagai situasi; Membuat keputusan berdasarkan prinsip-prinsip etika yang kuat" |
| indikator_4 | String | "Mampu mempengaruhi orang lain untuk bertindak dengan integritas" |
| indikator_5 | String | "Menciptakan budaya organisasi yang menjunjung tinggi integritas" |

### 5.6 Data Review_KPI

| Atribut | Tipe Data | Contoh Nilai |
|---------|-----------|-------------|
| review_id | ID unik | R0001 |
| kpi_id | FK → kpi_id | KPI20260001 |
| reviewer_id | FK → user_id | U005 (Budi, Lead) |
| review_level | ENUM | Lead / Lead HR / Manager |
| komentar | String | "KPI sudah sesuai, lanjutkan" |
| keputusan | ENUM | Approved / Reject |
| review_date | Timestamp | 06/06/2026 10:00:00 |

---

## 6. Aturan Bisnis

| No | Aturan | Keterangan | Contoh |
|----|--------|------------|--------|
| R1 | Status Draft | Form belum disubmit; seluruh data dapat diubah pengguna | KPI Rian berstatus Draft Q1; Rian bebas mengedit data Jobdesc |
| R2 | Status Submitted | Form terkirim dan data terkunci dari perubahan | Setelah submit, Rian tidak dapat mengubah data apapun |
| R3 | Status Need Revision | Form dikembalikan reviewer; data dapat diubah dan disubmit ulang | Lead reject KPI Rian → status Need Revision Q1; Rian dapat merevisi |
| R4 | Status Waiting (Lead/Lead HR/Manager) | Disimpan sebagai logika UI berdasarkan current_approver_id, bukan field status tersendiri | KPI Rian dengan current_approver_id = Lead HR ditampilkan sebagai "Waiting Lead HR" |
| R5 | Status Approved | Persetujuan akhir diberikan Manager; form selesai | Manager approve → status Approved Q1, indikator warna hijau |
| R6 | Reject otomatis ubah status | Keputusan Reject dari reviewer mana pun otomatis mengubah KPI.status menjadi Need Revision | Lead HR reject KPI Budi → KPI.status = Need Revision Q2 |
| R7 | Alur approval Employee/Lead | Associate/Intermediate/Senior/Lead → disetujui Lead → disetujui Lead HR → disetujui Manager | Approve Lead → current_approver_id = Lead HR; Approve Lead HR → current_approver_id = Manager |
| R8 | Alur approval Principle | KPI Principle dikirim langsung ke Lead HR tanpa melalui Lead | Submit Principle → current_approver_id = Lead HR |
| R9 | Alur approval Lead HR | KPI Lead HR sendiri dikirim langsung ke Manager | Submit Lead HR → current_approver_id = Manager |
| R10 | Submit gabungan | Form Penilaian Kinerja Hasil dan Form Penilaian Kinerja Perilaku disubmit secara bersamaan dalam satu aksi | Tekan tombol Submit → kedua form otomatis berstatus Submitted Q1 |
| R11 | Auto-submit per quarter | Jika tidak disubmit manual hingga batas waktu, sistem otomatis submit Draft menjadi Submitted | Draft Q1 belum disubmit pada 14 April → otomatis Submitted Q1 |
| R12 | Logika auto-submit Q4 | Q4 auto-submit terjadi pada 14 Januari tahun berikutnya | KPI 2026 Q4 belum disubmit → auto-submit pada 14 Januari 2027 |
| R13 | KPI baru tiap tahun | Sistem membuat entri KPI baru setiap tahun; pengguna dapat membuka riwayat KPI tahun sebelumnya | Di menu Form KPI tersedia pilihan "Tahun 2025" dan "Tahun 2026" |
| R14 | Validasi Mandays | Field Mandays (Jobdesc/CI/SD/HRA) wajib berupa Positive Integer > 0; tidak menerima desimal, negatif, huruf, spasi, atau simbol | Input "5" valid ✓ / Input "5.5" atau "-2" atau "lima" tidak valid ✗ |
| R15 | Validasi Total Cuti | Total Cuti berupa bilangan bulat ≥ 0; tidak boleh negatif; tidak boleh melebihi batas maksimum 12 hari | Total Cuti 13 → ditolak ✗ / Total Cuti 5 → valid ✓ |
| R16 | Total Cuti terkunci saat Submitted | Field Total Cuti hanya bisa diubah saat status Draft atau Need Revision | KPI status Submitted → field Total Cuti read-only |
| R17 | Field Bukti hanya teks | Seluruh field yang mengandung istilah "Bukti" menggunakan Text Area; tidak mendukung upload file atau lampiran | Field "Nama Kegiatan dan Bukti" diisi deskripsi teks bebas, bukan file PDF/gambar |
| R18 | Multi-row subform | Subform Jobdesc, CI, SD, dan HRA mendukung penambahan baris via tombol "Tambah Baris"; baris dapat dihapus sebelum submit | Pengguna menambah 3 baris Jobdesc, menghapus 1 baris, lalu submit |
| R19 | Bulk Action wajib konfirmasi | Setiap aksi massal (Approve Selected, Reject Selected, Delete Selected) wajib menampilkan dialog konfirmasi sebelum dieksekusi | Klik "Reject Selected" → muncul dialog konfirmasi → pengguna konfirmasi → dieksekusi |
| R20 | Komentar tunggal untuk Bulk Action | Approve Selected/Reject Selected menyediakan 1 field komentar yang diterapkan ke seluruh data terpilih | Manager isi 1 komentar untuk 5 KPI yang di-Approve Selected |
| R21 | Admin tidak akses penilaian KPI | Admin hanya mengelola akun pengguna; tidak memiliki akses ke menu Form KPI atau Review KPI | Admin tidak dapat melihat atau mengubah isi Form KPI manapun |
| R22 | Score Perilaku wajib semua aspek | Semua 14 aspek perilaku wajib memiliki Score sebelum form dapat disubmit | Jika Score Inovasi belum dipilih → form tidak dapat disubmit |
| R23 | Pembulatan Target Point | Hasil perhitungan Target Point per kategori menggunakan pembulatan matematika: ≥ 0,5 dibulatkan ke atas, < 0,5 dibulatkan ke bawah | 11,9 → 12; 11,4 → 11 |
| R24 | HR Activity tanpa koefisien role | Target Point HR Activity dihitung tanpa koefisien role karena berlaku sama untuk seluruh karyawan | Target HR Activity = 5% × Hari Kerja Efektif (tanpa × Koefisien Role) |

---

## 7. Aturan Kalkulasi dan Formula

### 7.1 Formula Subform Jobdesc

| Field | Formula |
|-------|---------|
| Jumlah Koefisien | Koefisien On Time & On Budget + Koefisien Grade Project |
| Total Mandays Penugasan | (Mandays Proyek × Jumlah Koefisien) ÷ 2 |

### 7.2 Formula Subform CI, SD, HRA

| Subform | Formula Point |
|---------|--------------|
| Continuous Improvement | Point CI = Koefisien CI × Mandays CI |
| Self Development | Point SD = Koefisien SD × Mandays SD |
| HR Activity | Point HRA = Koefisien HRA × Mandays HRA |

### 7.3 Formula Target Point Minimal 1 Tahun

| Kategori | Formula |
|----------|---------|
| Hari Kerja Efektif | 240 − Total Cuti |
| Target Point Job Desk | 85% × Hari Kerja Efektif × Koefisien Role |
| Target Point Self Development | 5% × Hari Kerja Efektif × Koefisien Role |
| Target Point HR Activity | 5% × Hari Kerja Efektif |
| Target Point CI | 5% × Hari Kerja Efektif × Koefisien Role |
| Target Point Minimal 1 Tahun | Jobdesc + Self Dev + HR Activity + CI |

### 7.4 Formula Penilaian Kinerja Hasil

| Komponen | Formula |
|----------|---------|
| Nilai Kinerja Hasil | (Total Mandays Jobdesc + Total Point CI + Total Point SD + Total Point HRA) ÷ Target Point per Tahun |
| Final Score Kinerja Hasil | 70% × 5 × Nilai Kinerja Hasil |

### 7.5 Formula Penilaian Kinerja Perilaku

| Komponen | Formula |
|----------|---------|
| Nilai Subform per Aspek | Score Aspek ÷ Nilai Indikator Aspek |
| Rata-Rata Score Kinerja Perilaku | Jumlah seluruh Nilai Subform (14 aspek) ÷ 14 |
| Final Score Kinerja Perilaku | 30% × 5 × Rata-Rata Score Kinerja Perilaku |

### 7.6 Formula Final KPI Score

| Komponen | Formula |
|----------|---------|
| Final Score KPI | Final Score Kinerja Hasil + Final Score Kinerja Perilaku |

### 7.7 Predikat Nilai Kinerja Total

| Rentang Nilai | Predikat | Contoh |
|---------------|----------|--------|
| > 7,50 | Excellent | Nilai = 8,00 → Excellent |
| 6,25 – 7,50 | Baik Sekali | Nilai = 7,50 → Baik Sekali |
| 5,00 – 6,24 | Baik | Nilai = 6,24 → Baik |
| 3,75 – 4,99 | Cukup | Nilai = 4,99 → Cukup |
| < 3,75 | Kurang | Nilai = 3,74 → Kurang |

---

## 8. Tabel Referensi Koefisien

### 8.1 Koefisien On Time dan On Budget (Subform Jobdesc)

| Pilihan | Koefisien |
|---------|-----------|
| 21% atau lebih di atas ekspektasi | 1,50 |
| 10–20% di atas ekspektasi | 1,25 |
| Sesuai Ekspektasi (95%–105%) | 1,00 |
| 10–20% di bawah ekspektasi | 0,75 |
| 21–30% di bawah ekspektasi | 0,50 |
| Unacceptable (> 30% di bawah ekspektasi) | 0,25 |

### 8.2 Koefisien Grade Project berdasarkan Role (Subform Jobdesc)

| Role | Grade C | Grade B | Grade A |
|------|:-------:|:-------:|:-------:|
| Associate | 1,000 | 1,125 | 1,250 |
| Intermediate | 0,875 | 1,000 | 1,125 |
| Senior | 0,750 | 0,875 | 1,000 |
| Lead | 0,625 | 0,750 | 0,875 |
| Principle | 0,500 | 0,625 | 0,750 |
| Lead HR | 0,625 | 0,750 | 0,875 |

### 8.3 Koefisien Continuous Improvement (CI)

| Jenis Kegiatan/Bukti CI | Koefisien |
|-------------------------|-----------|
| Tidak didaftarkan pada Product & Research (tanpa perencanaan) – CI Belum Sesuai Format | 0,125 |
| Tidak didaftarkan pada Product & Research (tanpa perencanaan) – CI Sesuai Format | 0,250 |
| Didaftarkan pada Product & Research, mendapat surat tugas dari Manajer – CI Individu | 0,750 |
| Didaftarkan pada Product & Research, mendapat surat tugas dari Manajer – menjadi Produk, Proyek, WI, SOP, atau CI Kolaborasi | 1,000 |
| CI yang menjadi produk/proyek komersial atau CI yang terbukti menurunkan biaya operasional serta disetujui oleh Manajer | 1,250 |

### 8.4 Koefisien Self Development (SD)

| Jenis Kegiatan SD | Koefisien |
|-------------------|-----------|
| Training Offline/Online/Pasif/TLab Circle Internal dengan/tanpa sertifikat durasi < 8 jam (menerima materi); Membaca Buku Online durasi < 8 jam | 0,75 |
| Mengikuti Sertifikasi BNSP | 0,75 |
| Sertifikasi Internasional tanpa Proctored Exam, dengan mengikuti training online | 1,00 |
| Sertifikasi Internasional dengan Proctored Exam, dengan/tanpa proses Training Offline/Online | 1,50 |
| Mengisi Webinar/Seminar/Event sebagai pembicara/moderator yang disetujui Perusahaan, maksimal 2 hari – unpaid | 1,25 |
| Mengisi Training/Co-teaching yang disetujui Perusahaan – unpaid | 1,75 |
| Mengisi Training/Co-teaching yang disetujui Perusahaan – paid | 1,25 |
| Training Offline/Online/Pasif durasi > 8–24 jam (menerima materi); Membaca Buku Online durasi > 8–24 jam; > 24 jam sertifikasi Internasional Non-Proctored Exam – Menulis pada Media yang disetujui perusahaan | 0,75 |
| Training Offline/Online/Pasif durasi > 8–24 jam (menerima materi); Membaca Buku Online durasi > 8–24 jam; > 24 jam sertifikasi Internasional Non-Proctored Exam – Membuat Proposal CI/Produk/Proyek atau Working Instruction yang disetujui perusahaan | 1,00 |
| Menulis pada Jurnal Nasional | 3,00 |
| Menulis pada Jurnal Internasional | 3,00 |
| Juara dalam Hackathon/Lomba Coding/Desain/Infrastruktur tingkat Nasional | 3,00 |
| Juara dalam Hackathon/Lomba Coding/Desain/Infrastruktur tingkat Internasional | 3,00 |

### 8.5 Koefisien HR Activity (HRA)

| Jenis Kegiatan HRA | Koefisien |
|--------------------|-----------|
| Ikut sebagai peserta (kegiatan non pelatihan) | 0,75 |
| Ikut dalam kegiatan kategori pelatihan soft skill, hard skill, mindset skill | 0,75 |
| Presensi | 0,75 |
| Ikut sebagai panitia, pemateri, koordinator kegiatan komunitas internal TLab, dll yang disetujui perusahaan | 1,00 |

### 8.6 Koefisien Role untuk Target Point

| Role | Koefisien |
|------|:---------:|
| Associate | 1,000 |
| Intermediate | 1,050 |
| Senior | 1,100 |
| Lead | 1,150 |
| Principle | 1,150 |
| Lead HR | 1,155 |

---

## 9. Target Point Minimum Tahunan per Role

| Role | Jobdesc | Self Dev | HR Activity | CI | Total |
|------|:-------:|:--------:|:-----------:|:--:|:-----:|
| Associate | 204 | 12 | 12 | 12 | 240 |
| Intermediate | 214 | 13 | 12 | 13 | 251 |
| Senior | 224 | 13 | 12 | 13 | 263 |
| Lead | 235 | 14 | 12 | 12 | 273 |
| Principle | 235 | 13 | 12 | 14 | 274 |
| Lead HR | 237 | 14 | 12 | 12 | 275 |

---

## 10. Tabel Referensi Indikator Penilaian Perilaku (14 Aspek)

### 10.1 Ringkasan Aspek Perilaku

| No | Aspek | Min. Capaian (Indikator) | Definisi Singkat |
|----|-------|:------------------------:|-----------------|
| 1 | Integritas | 2 | Memiliki pribadi yang jujur dan menjaga kerahasiaan informasi |
| 2 | Speed | 2 | Kemampuan menyelesaikan aktivitas dalam waktu sesingkat mungkin sesuai deadline |
| 3 | Ketelitian Kerja | 3 | Kemampuan meminimalisir kesalahan dengan memeriksa data secara detail dan cermat |
| 4 | Penyesuaian Diri | 3 | Beradaptasi terhadap perubahan situasi; fleksibel dan terbuka terhadap cara-cara baru |
| 5 | Hasrat Berprestasi | 2 | Kepedulian tinggi pada pekerjaan sehingga terdorong bekerja di atas standar |
| 6 | Komunikasi Interpersonal | 3 | Berkomunikasi efektif dengan orang lain, termasuk mendengar aktif dan memberikan umpan balik |
| 7 | Pengelolaan Hubungan | 3 | Membangun, memelihara, dan mengembangkan hubungan yang positif dan produktif |
| 8 | Kerjasama | 3 | Bekerja dalam kelompok dan aktif berpartisipasi dalam pencapaian tujuan |
| 9 | Fokus Pada Kualitas | 3 | Mendorong dan mempertahankan standar kualitas tinggi dalam pekerjaan |
| 10 | Customer Centric | 3 | Memfasilitasi kebutuhan dan kepuasan pelanggan sebagai prioritas utama |
| 11 | Inovasi | 2 | Menghasilkan solusi inovatif dan mencoba cara baru dalam menghadapi masalah |
| 12 | Berpikir Analitis | 2 | Memecahkan masalah sulit melalui evaluasi seksama dan sistematis |
| 13 | Berpikir Konseptual | 2 | Memahami konsep kompleks dan membuat koneksi logis antara ide-ide terkait |
| 14 | Business Acumen | 2 | Memahami konsep bisnis dan keuangan untuk bekerja secara efektif |

### 10.2 Indikator Level 1–5 per Aspek

**1. Integritas** (Min. Capaian: 2)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Mengikuti aturan dan prosedur yang ditetapkan; Membutuhkan pengawasan untuk memastikan kepatuhan |
| 2 | Mampu bertanggung jawab atas tindakan dan keputusan sendiri; Mengakui kesalahan dan bertanggung jawab atas konsekuensinya |
| 3 | Mampu bertindak secara konsisten sesuai nilai-nilai etika dalam berbagai situasi; Membuat keputusan berdasarkan prinsip-prinsip etika yang kuat |
| 4 | Mampu mempengaruhi orang lain untuk bertindak dengan integritas |
| 5 | Menciptakan budaya organisasi yang menjunjung tinggi integritas |

**2. Speed** (Min. Capaian: 2)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Penyelesaian tugas lebih dari waktu yang diberikan |
| 2 | Penyelesaian tugas sesuai dengan deadline waktu yang ditentukan (ontime) |
| 3 | Penyelesaian tugas kurang dari deadline waktu yang ditentukan (intime) |
| 4 | Penyelesaian tugas kurang dari deadline (intime) dengan cara baru untuk mempercepat; Mampu menyelesaikan tugas yang sangat kompleks secara mandiri |
| 5 | Penyelesaian tugas kurang dari deadline (intime) dengan cara baru; Mampu menyelesaikan tugas yang sangat kompleks dengan sangat efisien dalam situasi sulit |

**3. Ketelitian Kerja** (Min. Capaian: 3)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Membuat banyak kesalahan dan kurang memperhatikan detail |
| 2 | Mampu menyelesaikan tugas dengan tingkat ketelitian dasar; Mulai memperhatikan detail, tetapi masih bisa membuat kesalahan |
| 3 | Mampu menyelesaikan tugas dengan ketelitian yang konsisten dan meminimalkan kesalahan; Mampu mengidentifikasi dan menghindari kesalahan dengan efektif |
| 4 | Memiliki standar ketelitian yang tinggi; Mampu menghasilkan pekerjaan yang berkualitas tinggi dan bebas dari kesalahan |
| 5 | Mampu mengantisipasi dan mencegah kesalahan sebelum terjadi; Mampu mengembangkan sistem dan prosedur untuk meningkatkan ketelitian kerja |

**4. Penyesuaian Diri** (Min. Capaian: 3)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Cenderung mempertahankan cara lama dan menghindari hal-hal baru |
| 2 | Lambat dalam mengikuti perubahan dan masih menggunakan petunjuk/metode lama; Memerlukan dukungan dan informasi yang jelas tentang perubahan |
| 3 | Menyesuaikan situasi, aturan, dan metode cara kerja lama dengan menerapkan situasi, aturan, dan metode baru; Mencari informasi dan sumber daya untuk membantu adaptasi |
| 4 | Mengikuti perubahan secara terbuka dan melakukan perubahan dengan sukarela; Mencari cara untuk meningkatkan efektivitas dalam situasi dan metode baru |
| 5 | Menjadi agen perubahan yang aktif dan mendorong orang lain untuk beradaptasi; Mampu menciptakan lingkungan yang mendukung perubahan |

**5. Hasrat Berprestasi** (Min. Capaian: 2)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Memberikan usahanya dengan fokus pada tugas dengan prestasi rata-rata; Tidak diperlukan inisiatif untuk memulai tugas atau cara kerja baru |
| 2 | Memiliki inisiatif dan menunjukkan keinginan untuk mencapai standar kerja yang ditetapkan (minimum sama dengan prestasi rata-rata) |
| 3 | Mampu bekerja untuk mencapai standar kinerja yang ditetapkan manajemen (menyesuaikan anggaran, mencapai kuota/target, persyaratan kualitas, dsb) |
| 4 | Berpikir mandiri dalam menetapkan ukuran keberhasilan kerjanya (jumlah uang yang dikeluarkan, tingkat penjualan, penggunaan waktu, memenangkan persaingan, dsb) |
| 5 | Mempunyai kebijakan dalam sistem kerja sendiri untuk memperbaiki kinerja secara berkelanjutan; target kerja selalu meningkat dari waktu ke waktu tanpa menetapkan target/tujuan tertentu di awal |

**6. Komunikasi Interpersonal** (Min. Capaian: 3)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Cenderung pasif dalam interaksi; Kesulitan menyampaikan pesan secara jelas; Kurang mampu mendengarkan secara aktif |
| 2 | Mampu menyampaikan pesan secara cukup jelas; Mulai menunjukkan kemampuan untuk mendengarkan; Dapat merespons umpan balik dengan cukup baik |
| 3 | Mampu menyampaikan pesan secara jelas, ringkas, dan persuasif; Mampu mendengarkan secara aktif dan memahami perspektif orang lain |
| 4 | Mampu memahami dan merespons emosi orang lain dengan baik; Mampu membangun hubungan yang kuat dan saling percaya |
| 5 | Dapat memahami sudut pandang orang lain dan memberikan umpan balik yang konstruktif |

**7. Pengelolaan Hubungan** (Min. Capaian: 3)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Mengucilkan diri, menghindari interaksi sosial |
| 2 | Cenderung berfokus pada diri sendiri dan kebutuhan sendiri; Kesulitan memahami perspektif orang lain |
| 3 | Mempertahankan hubungan pekerjaan, termasuk obrolan tidak terstruktur namun masih berkaitan dengan pekerjaan |
| 4 | Membuat hubungan informal di lingkungan kerja; mengobrol tentang anak-anak, olahraga, berita, dan sebagainya |
| 5 | Sering menyelenggarakan kontak informal di lingkungan kerja, baik tim internal maupun eksternal; dengan sengaja membangun kesan hubungan yang baik |

**8. Kerjasama** (Min. Capaian: 3)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Tidak menerima keputusan tim dan tidak melaksanakan tugas yang diberikan |
| 2 | Tidak menerima keputusan tim tetapi tetap melaksanakan tugas yang diberikan |
| 3 | Berpartisipasi sebagai anggota tim yang baik, melakukan tugas/bagiannya, dan mendukung keputusan tim |
| 4 | Selalu menjadikan orang lain tahu mengenai proses di dalam grup; Membagi informasi yang berguna dan relevan bagi anggota tim |
| 5 | Berpartisipasi sebagai anggota tim yang baik, mendukung keputusan tim, dan memberikan masukan yang dapat diterima dalam tim |

**9. Fokus Pada Kualitas** (Min. Capaian: 3)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Hasil pekerjaan tidak sesuai dengan standar yang ditentukan |
| 2 | Hasil pekerjaan sesuai standar yang ditentukan tetapi tidak sesuai dengan timeline yang ditentukan |
| 3 | Bertanggung jawab memberikan hasil sesuai standar yang ditetapkan; Menyelesaikan tugas dengan tuntas; Dapat diandalkan dan bertanggung jawab |
| 4 | Melakukan perbaikan cara kerja untuk mendapatkan hasil yang efektif dan berkualitas tinggi; Konsisten menghasilkan pekerjaan berkualitas tinggi |
| 5 | Menetapkan hasil kerja sendiri yang lebih tinggi dari standar tim; Melakukan usaha/perubahan metode kerja; Tangguh menghadapi hambatan untuk mencapai hasil melebihi standar |

**10. Customer Centric** (Min. Capaian: 3)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Memberikan respons seadanya atas pertanyaan/kebutuhan customer; tidak berusaha mencari akar permasalahan atau konteks masalah customer |
| 2 | Menindaklanjuti kebutuhan, permintaan, dan keluhan customer; menjaga customer mengetahui perkembangan produk/jasa (tanpa mencari akar permasalahan) |
| 3 | Memonitor kepuasan customer, mendistribusikan informasi yang membantu kepada customer; memberikan servis ramah dan bersikap sebagai sahabat |
| 4 | Memperbaiki masalah yang berkaitan dengan konsumen secara sungguh-sungguh |
| 5 | Selalu siap membantu terutama pada periode kritis konsumen; memberikan akses mudah (nomor HP) atau menghabiskan banyak waktu di lokasi konsumen |

**11. Inovasi** (Min. Capaian: 2)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Tidak melakukan hal-hal baru dalam pekerjaannya untuk meningkatkan kinerja |
| 2 | Melakukan pengembangan yang sudah dilakukan sebelumnya untuk meningkatkan pekerjaan individu |
| 3 | Melakukan pengembangan yang sudah dilakukan sebelumnya untuk meningkatkan pekerjaan dalam satu tim |
| 4 | Melakukan sesuatu yang baru dan belum pernah dilakukan dalam pekerjaan tersebut guna meningkatkan kinerja, namun sudah dilakukan di tim lain |
| 5 | Melakukan sesuatu/pengembangan baru yang belum dilakukan sebelumnya untuk meningkatkan pekerjaan dalam satu tim |

**12. Berpikir Analitis** (Min. Capaian: 2)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Kurang dapat menggali informasi yang dibutuhkan |
| 2 | Dapat melakukan analisis masalah dengan data informasi yang tersedia |
| 3 | Melihat hubungan mendasar; Menganalisa hubungan antara bagian dari persoalan |
| 4 | Melihat hubungan mendasar; Menganalisa hubungan antar bagian persoalan; Membuat hubungan sebab akibat sederhana dan mengkaji keuntungan/kelemahan setiap alternatif |
| 5 | Menganalisa hubungan antar bagian persoalan; Membuat hubungan sebab akibat dan mengkaji keuntungan/kelemahan alternatif; Membutuhkan bantuan untuk menganalisis masalah |

**13. Berpikir Konseptual** (Min. Capaian: 2)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Berpikir secara konkrit |
| 2 | Menggunakan akal sehat dan pengalaman masalah lalu untuk mengidentifikasi situasi/masalah; Melihat kesamaan antara permasalahan sekarang dan masalah lalu |
| 3 | Mampu menerapkan konsep-konsep dasar untuk memecahkan masalah sederhana |
| 4 | Menerapkan dan memodifikasi konsep belajar secara wajar (seperti analisis akar masalah) atau menerapkan pengetahuan masa lalu dan kecenderungan antar situasi yang berbeda |
| 5 | Menyatukan ide, isu, dan observasi menjadi konsep tunggal atau penjelasan yang jelas; Mengidentifikasi isu kunci dalam situasi kompleks |

**14. Business Acumen** (Min. Capaian: 2)

| Level | Deskripsi Indikator |
|:-----:|----------------------|
| 1 | Pemahaman dasar tentang konsep bisnis yang relevan dengan peran mereka; Mampu mengikuti prosedur dan instruksi yang diberikan; Memahami bagaimana pekerjaan berkontribusi pada tujuan tim/departemen |
| 2 | Memahami alur kerja dasar departemen; Mampu menggunakan perangkat lunak/sistem yang relevan dengan pekerjaan mereka |
| 3 | Mampu menerapkan konsep bisnis dalam pekerjaan sehari-hari; Dapat mengidentifikasi masalah dan mencari solusi sesuai prosedur yang ada; Mengelola waktu dan prioritas untuk menyelesaikan tugas |
| 4 | Mampu menganalisis situasi bisnis dan mengidentifikasi peluang untuk perbaikan |
| 5 | Memberikan kontribusi yang signifikan pada tim atau departemen |

---

## 11. Contoh Perhitungan Lengkap End-to-End

### Skenario: Associate, Total Cuti 2 hari, Q1 2026

**Data Input:**

| Subform | Kegiatan | Koefisien | Mandays | Point |
|---------|----------|-----------|---------|-------|
| Jobdesc | Pengembangan Modul KPI (Grade B, Sesuai Ekspektasi) | 2,125 | 10 | 10,625 |
| CI | Membuat tools otomatisasi testing (CI Individu) | 0,75 | 5 | 3,75 |
| SD | Sertifikasi BNSP | 0,75 | 3 | 2,25 |
| HRA | Employee Gathering | 0,75 | 4 | 3,00 |

**Perhitungan Kinerja Hasil:**

| Langkah | Formula | Nilai |
|---------|---------|-------|
| Total Point Semua Subform | 10,625 + 3,75 + 2,25 + 3,00 | 19,625 |
| Target Point Minimal 1 Tahun (Associate, cuti 2) | 202 + 12 + 12 + 12 | 238 poin |
| Nilai Kinerja Hasil | 19,625 ÷ 238 | 0,0824 |
| Final Score Kinerja Hasil | 70% × 5 × 0,0824 | 0,2884 |

**Data Input Perilaku (contoh 4 aspek):**

| Aspek | Score | Indikator | Nilai Subform |
|-------|:-----:|:---------:|:-------------:|
| Integritas | 3 | 2 | 3 ÷ 2 = 1,50 |
| Speed | 2 | 2 | 2 ÷ 2 = 1,00 |
| Ketelitian Kerja | 3 | 3 | 3 ÷ 3 = 1,00 |
| Hasrat Berprestasi | 3 | 2 | 3 ÷ 2 = 1,50 |
| ... (14 aspek total) | | | |

**Perhitungan Kinerja Perilaku (asumsi rata-rata Nilai Subform = 1,20):**

| Langkah | Formula | Nilai |
|---------|---------|-------|
| Rata-Rata Score Kinerja Perilaku | Jumlah 14 Nilai Subform ÷ 14 | 1,20 |
| Final Score Kinerja Perilaku | 30% × 5 × 1,20 | 1,80 |

**Hasil Akhir:**

| Komponen | Nilai |
|----------|-------|
| Final Score Kinerja Hasil | 0,2884 |
| Final Score Kinerja Perilaku | 1,80 |
| Final Score KPI | 0,2884 + 1,80 = 2,09 |
| Predikat | Kurang (< 3,75) |

---

## 12. Integrasi Sistem

| Dari | Ke | Data yang Dipertukarkan | Contoh |
|------|----|--------------------------|--------|
| Form KPI (Hasil & Perilaku) | Tabel KPI, KPI_Hasil, KPI_Perilaku | Data perhitungan koefisien, mandays, point, score, dan deskripsi dari 4 subform hasil dan 14 subform perilaku | Saat submit, seluruh baris Jobdesc/CI/SD/HRA dan 14 skor perilaku tersimpan ke tabel terkait |
| Form KPI (Perilaku) | Tabel Master_Perilaku | Pengambilan Definisi, Minimum Capaian, dan Indikator 1–5 untuk ditampilkan pada 14 subform perilaku | Sistem memuat teks Indikator dari Master_Perilaku berdasarkan aspek_id saat form dibuka |
| Review KPI (Lead/Lead HR/Manager) | Tabel Review_KPI, Tabel KPI | Keputusan review (Approved/Reject), komentar reviewer, dan perubahan current_approver_id / status KPI | Lead Approve → current_approver_id pada tabel KPI berubah menjadi Lead HR |
| Scheduler/Cron Job | Tabel KPI | Pemeriksaan status Draft yang belum disubmit melewati batas waktu quarter; otomatis ubah menjadi Submitted | Pada 14 April, semua KPI dengan status Draft Q1 otomatis berubah menjadi Submitted Q1 |
| Admin – Management User | Tabel User | Penambahan, perubahan, penghapusan, pengaturan role, dan nonaktifkan pengguna (manual atau import Excel/CSV) | Admin mengimpor 20 data pengguna baru via file Excel; sistem membuat akun dengan role dan atasan yang ditentukan |
| Seluruh modul | Modul Login (Internal Login + JWT) | Email, password (terenkripsi), dan token JWT sesi | Setiap akses ke fitur memerlukan token JWT yang valid; token diterbitkan saat login berhasil menggunakan seed_akun |

---

## 13. Ringkasan

| Kategori | Jumlah |
|----------|:------:|
| Aktor (Role) | 8 |
| Group Actor | 6 |
| Proses Bisnis Utama | 18 |
| Entitas Data | 6 |
| Status KPI | 7 |
| Subform Penilaian Kinerja Hasil | 4 (Jobdesc, CI, SD, HRA) |
| Subform Penilaian Kinerja Perilaku | 14 Aspek |
| Aturan Bisnis Utama | 24 |
| Tabel Referensi Koefisien | 6 (On Time/Budget, Grade Project, CI, SD, HRA, Koefisien Role) |
| Formula Kalkulasi | 12 |
| Quarter per Tahun | 4 (Q1, Q2, Q3, Q4) |
| Predikat Nilai Kinerja | 5 (Excellent, Baik Sekali, Baik, Cukup, Kurang) |

---

*Dokumen ini menggunakan format SPOK sederhana untuk memudahkan ekstraksi persyaratan ke DFD, ERD, Use Case Diagram, Activity Diagram, dan Sequence Diagram.*