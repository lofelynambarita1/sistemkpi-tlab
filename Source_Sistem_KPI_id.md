# Dokumen Sumber: Sistem KPI (Format Sederhana SPOK)

> Dokumen ini merupakan dokumen sumber dengan format sederhana menggunakan pola SPOK (Subyek, Predikat, Obyek, Keterangan) untuk menjelaskan proses bisnis Sistem Penilaian KPI (Key Performance Indicator) Karyawan.

---

## 1. Definisi Sistem

**Sistem KPI** adalah sistem berbasis web yang digunakan untuk mengelola seluruh proses penilaian kinerja (Key Performance Indicator) karyawan, mulai dari pengisian Form KPI (Penilaian Kinerja Hasil dan Penilaian Kinerja Perilaku), proses persetujuan (approval) berjenjang oleh Lead, Lead HR, dan Manager, hingga pengelolaan akun pengguna oleh Admin. Sistem menggunakan mekanisme **Internal Login + JWT**, di mana seluruh akun pengguna didaftarkan terlebih dahulu oleh Admin melalui `seed_akun`.

---

## 2. Aktor (Subyek Utama)

| No | Aktor | Group Actor | Peran | Contoh |
|----|-------|-------------|-------|--------|
| A1 | Associate | Employee | Mengisi dan mengirimkan Form KPI miliknya sendiri | Rian, karyawan dengan role Associate |
| A2 | Intermediate | Employee | Mengisi dan mengirimkan Form KPI miliknya sendiri | Dewi, karyawan dengan role Intermediate |
| A3 | Senior | Employee | Mengisi dan mengirimkan Form KPI miliknya sendiri | Andi, karyawan dengan role Senior |
| A4 | Principle | Principle | Mengisi dan mengirimkan Form KPI miliknya sendiri kepada Lead HR | Sari, karyawan dengan role Principle |
| A5 | Lead | Lead | Mereview KPI bawahan (Associate, Intermediate, Senior) serta mengisi Form KPI miliknya sendiri | Budi, Lead Divisi Engineering |
| A6 | Lead HR | Lead HR | Mereview KPI Lead, Principle, dan bawahannya, serta mengisi Form KPI miliknya sendiri | Maya, Lead HR |
| A7 | Manager | Manager | Mereview dan menyetujui akhir KPI yang sudah disetujui Lead HR | Hendra, Manager Divisi |
| A8 | Admin | Admin | Mengelola seluruh akun pengguna sistem, tidak terlibat dalam proses penilaian KPI | Tata, Admin Sistem |

---

## 3. Proses Bisnis (Format SPOK)

### 3.1 Proses Login dan Logout

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Seluruh pengguna (Admin, Associate, Intermediate, Senior, Principle, Lead, Lead HR, Manager) |
| **Predikat** | Melakukan autentikasi |
| **Obyek** | Email dan password |
| **Keterangan** | Pengguna memasukkan email dan password yang telah didaftarkan oleh Admin melalui `seed_akun`. Sistem memverifikasi kredensial menggunakan mekanisme Internal Login dan menerbitkan token JWT jika valid. Pengguna juga dapat melakukan logout untuk mengakhiri sesi. |

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
| **Obyek** | Data profil dan password akun |
| **Keterangan** | Pengguna dapat melihat informasi profil yang terdiri dari Nama Lengkap, Email, Jabatan, Divisi, dan Role. Pengguna juga dapat mengubah password akun miliknya sendiri melalui menu Ubah Password. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Nama Lengkap | Rian Pratama |
| Email | rian.associate@company.com |
| Jabatan | Software Engineer |
| Divisi | Engineering |
| Role | Associate |

---

### 3.3 Proses Melihat Dashboard

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Seluruh pengguna (informasi berbeda sesuai role) |
| **Predikat** | Melihat |
| **Obyek** | Ringkasan informasi KPI sesuai dengan role masing-masing |
| **Keterangan** | Setiap role memiliki tampilan dashboard yang berbeda sesuai dengan tanggung jawabnya, sebagaimana dijelaskan pada tabel berikut. |

**Contoh Data Dashboard per Role:**

| Role | Informasi yang Ditampilkan |
|------|------------------------------|
| Admin | Jumlah pengguna berdasarkan role |
| Associate/Intermediate/Senior | Total target KPI yang harus dicapai, Total KPI yang telah diperoleh, Persentase progress KPI, Status Form KPI terakhir, Informasi periode penilaian yang sedang berjalan, Petunjuk pengisian Form KPI |
| Principle | Total KPI yang perlu dicapai, KPI yang sudah dimiliki saat ini, Petunjuk pengisian Form KPI, Progress KPI |
| Lead | Total Employee (Associate, Intermediate, Senior) yang sudah submit KPI, dan Total Employee (Associate, Intermediate, Senior) |
| Lead HR | Total KPI menunggu review, Total KPI telah di-approve, Total KPI ditolak, Total bawahan yang menjadi tanggung jawab Lead HR, Jumlah KPI berdasarkan status |
| Manager | Total KPI menunggu persetujuan, Total KPI telah diapprove, Total KPI ditolak, Total pengguna dalam sistem, Distribusi KPI berdasarkan status |

---

### 3.4 Proses Mengisi Form Penilaian Kinerja Hasil – Subform Jobdesc

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengisi |
| **Obyek** | Data Jobdesc pada Form Penilaian Kinerja Hasil |
| **Keterangan** | Pengguna mengisi 4 field input: Penilaian Koefisien On Time dan On Budget (dropdown), Penilaian Grade Project (dropdown), Nama Kegiatan dan Bukti (teks bebas), dan Mandays Proyek (positive integer). Sistem secara otomatis menghitung 2 field yang tidak dapat diubah: "Jumlah Koefisien Ontime OnBudget + Koefisien Grade Project" dan "Total Mandays Penugasan". Subform ini mendukung input multi-row melalui tombol "Tambah Baris", dan setiap baris dapat dihapus sebelum form disubmit. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Penilaian Koefisien On Time dan On Budget | Sesuai Ekspektasi (95%-105%) → koefisien 1 |
| Penilaian Grade Project | B (Role Associate) → koefisien 1,125 |
| Jumlah Koefisien Ontime OnBudget + Koefisien Grade Project | 1 + 1,125 = 2,125 |
| Nama Kegiatan dan Bukti | "Pengembangan modul laporan KPI, bukti: dokumentasi sistem terlampir di repository" |
| Mandays Proyek | 10 |
| Total Mandays Penugasan | (10 × 2,125) ÷ 2 = 10,625 |

---

### 3.5 Proses Mengisi Form Penilaian Kinerja Hasil – Subform Continuous Improvement (CI)

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengisi |
| **Obyek** | Data Continuous Improvement pada Form Penilaian Kinerja Hasil |
| **Keterangan** | Pengguna mengisi 3 field input: Jenis Kegiatan/Bukti CI (dropdown), Kegiatan CI (teks bebas), dan Mandays CI (positive integer). Sistem secara otomatis mengisi 2 field yang tidak dapat diubah: Koefisien CI (berdasarkan pilihan Jenis Kegiatan/Bukti CI) dan Point CI (hasil perkalian Koefisien × Mandays). Subform ini mendukung input multi-row melalui tombol "Tambah Baris", dan setiap baris dapat dihapus sebelum form disubmit. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Jenis Kegiatan/Bukti CI | "Didaftarkan pada Product & Research, mendapat surat tugas dari Manajer – CI Individu" |
| Koefisien CI | 0,75 |
| Kegiatan CI | "Membuat tools otomatisasi testing untuk modul KPI" |
| Mandays CI | 5 |
| Point CI | 0,75 × 5 = 3,75 |

---

### 3.6 Proses Mengisi Form Penilaian Kinerja Hasil – Subform Self Development (SD)

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengisi |
| **Obyek** | Data Self Development pada Form Penilaian Kinerja Hasil |
| **Keterangan** | Pengguna mengisi 3 field input: Jenis Kegiatan SD (dropdown), Kegiatan SD (teks bebas), dan Mandays SD (positive integer). Sistem secara otomatis mengisi 2 field yang tidak dapat diubah: Koefisien SD (berdasarkan pilihan Jenis Kegiatan SD) dan Point SD (hasil perkalian Koefisien SD × Mandays SD). Subform ini mendukung input multi-row melalui tombol "Tambah Baris", dan setiap baris dapat dihapus sebelum form disubmit. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Jenis Kegiatan SD | "Mengikuti Sertifikasi BNSP" |
| Koefisien SD | 0,75 |
| Kegiatan SD | "Sertifikasi BNSP Junior Web Developer" |
| Mandays SD | 3 |
| Point SD | 0,75 × 3 = 2,25 |

---

### 3.7 Proses Mengisi Form Penilaian Kinerja Hasil – Subform HR Activity (HRA)

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengisi |
| **Obyek** | Data HR Activity pada Form Penilaian Kinerja Hasil |
| **Keterangan** | Pengguna mengisi 2 field input: Jenis Kegiatan HRA (dropdown) dan Kegiatan HRA (teks bebas), serta field Mandays HRA (positive integer). Sistem secara otomatis mengisi 2 field yang tidak dapat diubah: Koefisien HRA (berdasarkan pilihan Jenis Kegiatan HRA) dan Point HRA (hasil perkalian Koefisien HRA × Mandays HRA). Subform ini mendukung input multi-row melalui tombol "Tambah Baris", dan setiap baris dapat dihapus sebelum form disubmit. Hasil perhitungan seluruh baris diakumulasikan menjadi Total Point di bagian bawah tabel. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Jenis Kegiatan HRA | "Ikut sebagai peserta (kegiatan non pelatihan)" |
| Koefisien HRA | 0,75 |
| Kegiatan HRA | "Employee Gathering" |
| Mandays HRA | 4 |
| Point HRA | 0,75 × 4 = 3 |
| Total Point (akumulasi seluruh baris HRA) | 3 |

---

### 3.8 Proses Mengisi Form Penilaian Kinerja Perilaku

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengisi |
| **Obyek** | 14 subform penilaian perilaku (berbentuk accordion dengan rating scale) |
| **Keterangan** | Form Penilaian Kinerja Perilaku terdiri dari 14 aspek (Integritas, Speed, Ketelitian Kerja, Penyesuaian Diri, Hasrat Berprestasi, Komunikasi Interpersonal, Pengelolaan Hubungan, Kerjasama, Fokus Pada Kualitas, Customer Centric, Inovasi, Berpikir Analitis, Berpikir Konseptual, dan Business Acumen). Setiap subform memiliki 4 field tetap (Definisi, Minimum Capaian, Indikator level 1–5, dan Deskripsi) serta 1 field input yaitu Score (dropdown 1–5). Field "Deskripsi" otomatis menampilkan teks Indikator sesuai level Score yang dipilih. |

**Contoh Data (Subform Integritas):**

| Field | Nilai |
|-------|-------|
| Definisi | "Memiliki pribadi yang jujur dengan dapat menjaga kerahasiaan informasi pribadi, tim, dan Perusahaan" |
| Minimum Capaian – Indikator | 2 |
| Minimum Capaian – Keterangan | "Mampu bertanggung jawab atas tindakan dan keputusan sendiri; Mengakui kesalahan dan bertanggung jawab atas konsekuensinya" |
| Score (input) | 3 |
| Deskripsi (otomatis dari Indikator level 3) | "Mampu bertindak secara konsisten sesuai dengan nilai-nilai etika dalam berbagai situasi; Membuat keputusan berdasarkan prinsip-prinsip etika yang kuat" |

> Rincian Definisi, Minimum Capaian, dan Indikator level 1–5 untuk seluruh 14 aspek terdapat pada **Tabel Referensi Indikator Penilaian Perilaku** di Bagian 5 (Aturan Bisnis).

---

### 3.9 Proses Submit Form KPI

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR |
| **Predikat** | Mengirimkan |
| **Obyek** | Form Penilaian Kinerja Hasil dan Form Penilaian Kinerja Perilaku |
| **Keterangan** | Ketika pengguna menekan tombol Submit, Form Penilaian Kinerja Hasil dan Form Penilaian Kinerja Perilaku akan tersubmit secara bersamaan. Status KPI berubah dari Draft menjadi Submitted, data terkunci dari perubahan, dan KPI memulai alur persetujuan berjenjang sesuai role pengirim. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Status Sebelum | Draft |
| Status Sesudah | Submitted |
| current_approver_id Awal | Lead (untuk Associate/Intermediate/Senior/Lead), Lead HR (untuk Principle) |
| Periode Penilaian | Semester 1 |
| Tahun | 2026 |

---

### 3.10 Proses Review KPI oleh Lead

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Lead |
| **Predikat** | Mereview, menyetujui, atau menolak |
| **Obyek** | Form KPI milik Associate, Intermediate, dan Senior yang berstatus Submitted |
| **Keterangan** | Lead melihat daftar nama Employee (Associate/Intermediate/Senior) yang sudah mengirimkan KPI. Lead dapat menekan tombol "Review KPI" untuk diarahkan ke Form KPI pengguna tersebut, dan menekan "Kembali" untuk keluar dari mode review. Jika Lead memilih "Approve KPI", sistem mengubah `current_approver_id` menjadi Lead HR dan status KPI tetap Submitted, serta Lead dapat menambahkan komentar. Jika Lead memilih "Reject KPI", status KPI berubah menjadi Need Revision (indikator warna biru), dan Lead dapat menambahkan komentar pada field komentar. |

**Contoh Data:**

| Field | Nilai (Approve) | Nilai (Reject) |
|-------|------------------|------------------|
| Status Sebelum | Submitted | Submitted |
| Status Sesudah | Submitted | Need Revision |
| current_approver_id Sesudah | Lead HR | tetap Lead (tidak berubah) |
| Indikator Warna | - | Biru |
| Komentar Reviewer | "KPI sudah sesuai, lanjutkan" | "Mohon lengkapi bukti pada Subform Jobdesc" |
| Review Level | Lead | Lead |

---

### 3.11 Proses Review KPI oleh Lead HR

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Lead HR |
| **Predikat** | Mereview, menyetujui, atau menolak |
| **Obyek** | Form KPI milik Associate, Intermediate, Senior, Lead, dan Principle yang berstatus Submitted dengan `current_approver_id` = Lead HR |
| **Keterangan** | Lead HR melihat daftar Nama Employee dan Lead dari setiap pengguna yang telah mengirimkan KPI. Lead HR dapat menekan tombol "Review KPI" untuk diarahkan ke Form KPI pengguna tersebut, dan menekan "Kembali" untuk keluar dari mode review. Jika Lead HR memilih "Approve KPI", sistem mengubah `current_approver_id` menjadi Manager dan status KPI tetap Submitted, serta Lead HR dapat menambahkan komentar. Jika Lead HR memilih "Reject KPI", status KPI berubah menjadi Need Revision (indikator warna biru), dan Lead HR dapat menambahkan komentar. Untuk KPI milik Lead HR sendiri, Form KPI hanya akan dikirimkan langsung kepada Manager. |

**Contoh Data:**

| Field | Nilai (Approve) | Nilai (Reject) |
|-------|------------------|------------------|
| Status Sebelum | Submitted | Submitted |
| Status Sesudah | Submitted | Need Revision |
| current_approver_id Sesudah | Manager | tetap Lead HR (tidak berubah) |
| Indikator Warna | - | Biru |
| Review Level | Lead HR | Lead HR |

---

### 3.12 Proses Review KPI oleh Manager

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Manager |
| **Predikat** | Mereview, menyetujui, atau menolak |
| **Obyek** | Form KPI yang sudah di-Approve oleh Lead HR (`current_approver_id` = Manager) |
| **Keterangan** | Manager melihat daftar Nama pengguna dari setiap employee yang sudah mengirimkan request verifikasi KPI. Manager dapat menekan tombol "Review KPI" untuk diarahkan ke Form KPI pengguna tersebut, dan menekan "Kembali" untuk keluar dari mode review. Jika Manager memilih "Approve KPI", status KPI berubah menjadi Approved (indikator warna hijau), yang berarti form telah memperoleh persetujuan akhir. Jika Manager memilih "Reject KPI", status KPI berubah menjadi Need Revision (indikator warna biru). Pada kedua pilihan, Manager dapat menambahkan komentar pada field komentar. |

**Contoh Data:**

| Field | Nilai (Approve) | Nilai (Reject) |
|-------|------------------|------------------|
| Status Sebelum | Submitted | Submitted |
| Status Sesudah | Approved | Need Revision |
| Indikator Warna | Hijau | Biru |
| Review Level | Manager | Manager |
| Keputusan | Approved | Reject |

---

### 3.13 Proses Bulk Action (Approve Selected / Reject Selected)

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Lead, Lead HR, Manager |
| **Predikat** | Menyetujui atau menolak secara massal |
| **Obyek** | Beberapa data Form KPI yang dipilih sekaligus |
| **Keterangan** | Sistem menyediakan fitur Select All (memilih seluruh data pada halaman saat ini maupun seluruh hasil pencarian) dan Deselect All. Untuk "Approve Selected", sistem menampilkan dialog konfirmasi sebelum proses dijalankan, lalu menampilkan 1 field komentar yang akan dikirimkan ke seluruh data terpilih. Untuk "Reject Selected", berlaku mekanisme yang sama. Sistem juga menyediakan fasilitas pencarian (search) dan pengurutan (sorting) pada kolom. Khusus Manager, tersedia tambahan fitur Import KPI pengguna dalam bentuk Excel. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Data Terpilih | 5 KPI Karyawan |
| Aksi | Approve Selected |
| Dialog Konfirmasi | "Apakah Anda yakin ingin menyetujui 5 data terpilih?" |
| Komentar (1 field untuk semua) | "Approve batch periode Semester 1 2026" |
| Hasil | 5 KPI berubah status/current_approver_id sesuai role reviewer |

---

### 3.14 Proses Melihat History

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Associate, Intermediate, Senior, Principle, Lead, Lead HR, Manager |
| **Predikat** | Melihat |
| **Obyek** | Riwayat aktivitas terkait Form KPI |
| **Keterangan** | History menampilkan aktivitas Create Form KPI, Update Form KPI, Submit Form KPI, Pengembalian revisi, Approval Lead, Approval Lead HR, Approval Manager, Komentar reviewer pada setiap tahap approval, Waktu kejadian, dan Pelaku yang melakukan tindakan. Khusus Manager, History menampilkan Pengembalian revisi, Approval Lead, Approval Lead HR, Approval Manager, Komentar reviewer pada setiap tahap approval, Waktu kejadian, dan Pelaku yang melakukan tindakan (tanpa aktivitas Create/Update/Submit). |

**Contoh Data:**

| Waktu Kejadian | Aktivitas | Pelaku | Komentar |
|----------------|-----------|--------|----------|
| 01/06/2026 09:00 | Create Form KPI | Rian (Associate) | - |
| 03/06/2026 14:00 | Submit Form KPI | Rian (Associate) | - |
| 04/06/2026 10:00 | Approval Lead | Budi (Lead) | "KPI sudah sesuai, lanjutkan" |
| 05/06/2026 11:00 | Approval Lead HR | Maya (Lead HR) | "Lanjutkan ke Manager" |
| 06/06/2026 13:00 | Approval Manager | Hendra (Manager) | "Approved, kerja bagus" |

---

### 3.15 Proses Management User oleh Admin

| Komponen | Deskripsi |
|----------|-----------|
| **Subyek** | Admin |
| **Predikat** | Mengelola |
| **Obyek** | Seluruh akun pengguna sistem |
| **Keterangan** | Admin dapat menambah pengguna, mengubah data pengguna, menonaktifkan/menghapus pengguna, mengelola password pengguna, mengimpor pengguna secara massal (Excel/CSV), dan mengatur role pengguna (associate, intermediate, senior, lead, principle, manager). Sistem menyediakan fitur Bulk Action berupa Import pengguna massal dan Delete Selected (dengan dialog konfirmasi sebelum penghapusan), serta fitur Select All dan Deselect All. Sistem juga menyediakan fasilitas pencarian (search) dan pengurutan (sorting). Pada setiap baris data tersedia menu aksi (row action) untuk view detail, update data, delete data, dan mengatur role pengguna. |

**Contoh Data:**

| Field | Nilai |
|-------|-------|
| Aksi | Import Pengguna (Excel/CSV) |
| Jumlah Data Diimpor | 20 pengguna |
| Aksi Lain | Delete Selected |
| Dialog Konfirmasi | "Apakah Anda yakin ingin menghapus 3 pengguna terpilih?" |
| Data User Dikelola | Profil, Email, Divisi, Jabatan, Role, Status Aktif/Nonaktif |

---

## 4. Data yang Dikelola

### 4.1 Data User

| Atribut | Contoh Nilai |
|---------|--------------|
| user_id | U001 |
| nama_lengkap | Rian Pratama |
| email | rian.associate@company.com |
| password | (terenkripsi) |
| atasan_id | U010 (Budi, Lead) |
| role_id | Associate |
| status_akun | Aktif |
| created_at | 01/01/2026 08:00:00 |
| updated_at | 01/06/2026 09:00:00 |

### 4.2 Data KPI

| Atribut | Contoh Nilai |
|---------|--------------|
| kpi_id | KPI20260001 |
| employee_id | U001 |
| current_approver_id | Lead / Lead HR / Manager |
| periode_penilaian | Semester 1 |
| tahun | 2026 |
| status | Draft / Submitted / Approved / Need Revision |
| total_nilai | 87,5 |
| created_at | 01/06/2026 09:00:00 |
| updated_at | 06/06/2026 13:00:00 |

### 4.3 Data KPI Hasil

| Atribut | Contoh Nilai |
|---------|--------------|
| hasil_id | H0001 |
| kpi_id | KPI20260001 |
| jenis_subform | Jobdesc / Continuous Improvement / Self Development / HR Activity |
| jenis_kegiatan | "Sertifikasi BNSP" |
| kegiatan | "Sertifikasi BNSP Junior Web Developer" |
| indikator | "Penilaian Koefisien On Time dan On Budget" |
| koefisien | 1,00 |
| mandays | 5 |
| point | 5,00 |
| created_at | 01/06/2026 09:10:00 |
| updated_at | 01/06/2026 09:20:00 |

### 4.4 Data KPI_Perilaku

| Atribut | Contoh Nilai |
|---------|--------------|
| perilaku_id | P0001 |
| kpi_id | KPI20260001 |
| aspek_id | INTEGRITAS |
| score | 3 |
| deskripsi | "Mampu bertindak secara konsisten sesuai dengan nilai-nilai etika dalam berbagai situasi; Membuat keputusan berdasarkan prinsip-prinsip etika yang kuat" |
| created_at | 01/06/2026 09:30:00 |
| updated_at | 01/06/2026 09:30:00 |

### 4.5 Data Master_Perilaku

| Atribut | Contoh Nilai |
|---------|--------------|
| aspek_id | INTEGRITAS |
| aspek_perilaku | Integritas |
| definisi | "Memiliki pribadi yang jujur dengan dapat menjaga kerahasiaan informasi pribadi, tim, dan Perusahaan" |
| minimum_capaian_indikator | 2 |
| minimum_capaian_keterangan | "Mampu bertanggung jawab atas tindakan dan keputusan sendiri; Mengakui kesalahan dan bertanggung jawab atas konsekuensinya" |
| indikator_1 | "Mengikuti aturan dan prosedur yang ditetapkan; Membutuhkan pengawasan untuk memastikan kepatuhan" |
| indikator_2 | "Mampu bertanggung jawab atas tindakan dan keputusan sendiri; Mengakui kesalahan dan bertanggung jawab atas konsekuensinya" |
| indikator_3 | "Mampu bertindak secara konsisten sesuai dengan nilai-nilai etika dalam berbagai situasi; Membuat keputusan berdasarkan prinsip-prinsip etika yang kuat" |
| indikator_4 | "Mampu mempengaruhi orang lain untuk bertindak dengan integritas" |
| indikator_5 | "Menciptakan budaya organisasi yang menjunjung tinggi integritas" |

### 4.6 Data Review_KPI

| Atribut | Contoh Nilai |
|---------|--------------|
| review_id | R0001 |
| kpi_id | KPI20260001 |
| reviewer_id | U010 (Budi, Lead) |
| review_level | Lead / Lead HR / Manager |
| komentar | "KPI sudah sesuai, lanjutkan" |
| keputusan | Approved / Reject |
| review_date | 04/06/2026 10:00:00 |

---

## 5. Aturan Bisnis

| No | Aturan | Keterangan | Contoh |
|----|--------|------------|--------|
| R1 | Status KPI – Draft | Form belum disubmit, pengguna masih dapat melakukan perubahan data | KPI Rian masih berstatus Draft, Rian dapat mengubah data Jobdesc |
| R2 | Status KPI – Submitted | Form telah dikirim, masuk ke alur persetujuan, dan data terkunci dari perubahan | Setelah submit, Rian tidak dapat lagi mengedit Subform Jobdesc |
| R3 | Status KPI – Need Revision | Form dikembalikan oleh reviewer untuk diperbaiki, pengguna dapat merevisi dan submit ulang | Lead mereject KPI Rian → status menjadi Need Revision |
| R4 | Status KPI – Waiting Lead / Waiting Lead HR / Waiting Manager | Form sedang menunggu proses review pada masing-masing tahap | KPI Rian menunggu review oleh Lead → Waiting Lead |
| R5 | Status KPI – Approved | Form telah memperoleh persetujuan akhir | Manager menyetujui KPI Rian → status menjadi Approved |
| R6 | Reject otomatis ubah status | Ketika keputusan reviewer = Reject, sistem otomatis mengubah KPI.status menjadi Need Revision | Lead HR reject KPI Maya → KPI.status = Need Revision |
| R7 | Alur approval berjenjang Employee/Lead | Associate/Intermediate/Senior/Lead → di-review Lead → diteruskan ke Lead HR → diteruskan ke Manager | Approve oleh Lead → current_approver_id = Lead HR; Approve oleh Lead HR → current_approver_id = Manager |
| R8 | Alur approval Principle/Lead HR | KPI Principle dan Lead HR dikirim langsung ke Lead HR/Manager (tanpa melalui Lead) | KPI Lead HR langsung dikirim ke Manager untuk di-approve |
| R9 | Submit gabungan | Form Penilaian Kinerja Hasil dan Form Penilaian Kinerja Perilaku disubmit secara bersamaan | Saat Rian menekan Submit, kedua form berubah status menjadi Submitted secara serentak |
| R10 | Validasi Mandays | Seluruh field Mandays (Jobdesc, CI, SD, HRA) wajib berupa Positive Integer (> 0), tidak menerima desimal, negatif, huruf, spasi, atau simbol | Input "5" valid; input "5.5", "-2", "lima", atau "5 hari" tidak valid |
| R11 | Field Bukti tanpa upload | Seluruh field yang mengandung istilah "Bukti" hanya berupa Text Area, tidak mendukung upload file/lampiran | Field "Nama Kegiatan dan Bukti" diisi dengan deskripsi teks bebas |
| R12 | Multi-row & hapus baris | Subform Jobdesc, CI, SD, dan HRA mendukung multi-row via tombol "Tambah Baris"; setiap baris dapat dihapus sebelum submit | Pengguna menambahkan 3 baris Jobdesc, kemudian menghapus 1 baris sebelum submit |
| R13 | Bulk Action wajib konfirmasi | Setiap aksi massal (Approve Selected, Reject Selected, Delete Selected) wajib menampilkan dialog konfirmasi sebelum dieksekusi | Klik "Reject Selected" untuk 4 data → muncul dialog "Apakah Anda yakin?" |
| R14 | Komentar tunggal untuk Bulk Action | Approve Selected/Reject Selected hanya menyediakan 1 field komentar yang diterapkan ke seluruh data terpilih | Manager mengisi 1 komentar untuk 5 KPI yang di-Approve Selected |
| R15 | Admin tidak terlibat penilaian | Admin hanya mengelola akun pengguna dan tidak memiliki akses ke proses penilaian/approval KPI | Admin tidak dapat melihat menu Form KPI atau Review KPI |

### 5.1 Tabel Koefisien Penilaian On Time dan On Budget (Subform Jobdesc – Field A)

| Pilihan | Koefisien |
|---------|-----------|
| 21% atau lebih di atas ekspektasi | 1,50 |
| 10–20% di atas ekspektasi | 1,25 |
| Sesuai Ekspektasi (95%–105%) | 1,00 |
| 10–20% di bawah ekspektasi | 0,75 |
| 21–30% di bawah ekspektasi | 0,50 |
| Unacceptable (>30% di bawah ekspektasi) | 0,25 |

### 5.2 Tabel Koefisien Grade Project berdasarkan Role (Subform Jobdesc – Field B)

| Role | Grade C | Grade B | Grade A |
|------|---------|---------|---------|
| Associate | 1,000 | 1,125 | 1,250 |
| Intermediate | 0,875 | 1,000 | 1,125 |
| Senior | 0,750 | 0,875 | 1,000 |
| Lead | 0,625 | 0,750 | 0,875 |
| Principle | 0,500 | 0,625 | 0,750 |

### 5.3 Rumus Perhitungan Subform Jobdesc

| Field | Rumus |
|-------|-------|
| Jumlah Koefisien Ontime OnBudget + Koefisien Grade Project | Koefisien On Time/On Budget + Koefisien Grade Project |
| Total Mandays Penugasan | (Mandays Proyek × Jumlah Koefisien Ontime OnBudget + Koefisien Grade Project) ÷ 2 |

### 5.4 Tabel Koefisien Continuous Improvement (CI)

| Pilihan Jenis Kegiatan/Bukti CI | Koefisien |
|----------------------------------|-----------|
| Tidak didaftarkan pada Product & Research (tanpa perencanaan) – CI Belum Sesuai Format | 0,125 |
| Tidak didaftarkan pada Product & Research (tanpa perencanaan) – CI Sesuai Format | 0,25 |
| Didaftarkan pada Product & Research, mendapat surat tugas dari Manajer – CI Individu | 0,75 |
| Didaftarkan pada Product & Research, mendapat surat tugas dari Manajer – menjadi Produk, Proyek, WI, SOP, atau CI Kolaborasi | 1,00 |
| CI yang menjadi produk/proyek komersial atau CI yang terbukti menurunkan biaya operasional serta disetujui oleh Manajer | 1,25 |

Rumus: **Point CI = Koefisien CI × Mandays CI**

### 5.5 Tabel Koefisien Self Development (SD)

| Pilihan Jenis Kegiatan SD | Koefisien |
|----------------------------|-----------|
| Training Offline/Online/Pasif/TLab Circle Internal dengan/tanpa sertifikat durasi < 8 jam (menerima materi); Membaca Buku Online durasi < 8 jam | 0,75 |
| Mengikuti Sertifikasi BNSP | 0,75 |
| Sertifikasi Internasional tanpa Proctored Exam, dengan mengikuti training online | 1,00 |
| Sertifikasi Internasional dengan Proctored Exam, dengan/tanpa proses Training Offline/Online | 1,50 |
| Mengisi Webinar/Seminar/Event sebagai pembicara/moderator yang disetujui Perusahaan, maksimal 2 hari – unpaid | 1,25 |
| Mengisi Training/Co-teaching yang disetujui Perusahaan – unpaid | 1,75 |
| Mengisi Training/Co-teaching yang disetujui Perusahaan – paid | 1,25 |
| Training Offline/Online/Pasif dengan/tanpa sertifikat durasi > 8 jam s.d. 24 jam (menerima materi); Membaca Buku Online durasi > 8–24 jam; >24 jam sertifikasi Internasional Non-Proctored Exam – Menulis pada Media yang disetujui perusahaan | 0,75 |
| Training Offline/Online/Pasif dengan/tanpa sertifikat durasi > 8 jam s.d. 24 jam (menerima materi); Membaca Buku Online durasi > 8–24 jam; >24 jam sertifikasi Internasional Non-Proctored Exam – Membuat Proposal CI/Produk/Proyek atau Working Instruction yang disetujui perusahaan | 1,00 |
| Menulis pada Jurnal Nasional | 3,00 |
| Menulis pada Jurnal Internasional | 3,00 |
| Juara dalam Hackathon/Lomba Coding/Desain/Infrastruktur tingkat Nasional | 3,00 |
| Juara dalam Hackathon/Lomba Coding/Desain/Infrastruktur tingkat Internasional | 3,00 |

Rumus: **Point SD = Koefisien SD × Mandays SD**

### 5.6 Tabel Koefisien HR Activity (HRA)

| Pilihan Jenis Kegiatan HRA | Koefisien |
|------------------------------|-----------|
| Ikut sebagai peserta (kegiatan non pelatihan) | 0,75 |
| Ikut dalam kegiatan kategori pelatihan soft skill, hard skill, mindset skill | 0,75 |
| Presensi | 0,75 |
| Ikut sebagai panitia, pemateri, koordinator kegiatan komunitas internal TLab, dll yang disetujui perusahaan | 1,00 |

Rumus: **Point HRA = Koefisien HRA × Mandays HRA**, dengan Total Point = akumulasi seluruh Point HRA pada semua baris.

### 5.7 Tabel Referensi Indikator Penilaian Perilaku (14 Aspek)

| No | Aspek | Definisi | Min. Capaian (Indikator / Keterangan) |
|----|-------|----------|-----------------------------------------|
| 1 | Integritas | Memiliki pribadi yang jujur dengan dapat menjaga kerahasiaan informasi pribadi, tim, dan Perusahaan | 2 / Mampu bertanggung jawab atas tindakan dan keputusan sendiri; Mengakui kesalahan dan bertanggung jawab atas konsekuensinya |
| 2 | Speed | Kemampuan untuk mengerjakan suatu aktivitas secara berulang yang sama dan berkesinambungan dalam waktu sesingkat mungkin, berhubungan dengan waktu penyelesaian tugas sesuai waktu yang diberikan | 2 / Penyelesaian tugas sesuai dengan deadline waktu yang ditentukan (ontime) |
| 3 | Ketelitian Kerja | Kemampuan untuk meminimalisir kesalahan dalam bekerja dengan memeriksa data dan informasi secara detail, seksama, cermat, tepat, dan menyeluruh | 3 / Mampu menyelesaikan tugas dengan ketelitian yang konsisten dan meminimalkan kesalahan; Mampu mengidentifikasi dan menghindari kesalahan dengan efektif |
| 4 | Penyesuaian Diri | Beradaptasi terhadap perubahan situasi, menyusun kembali tugas dan prioritas selama perubahan terjadi; fleksibel, terbuka terhadap cara-cara baru tanpa bergantung berlebihan pada metode/proses lama | 3 / Menyesuaikan situasi, aturan, dan metode cara kerja lama dengan menerapkan situasi, aturan, dan metode baru; Mencari informasi dan sumber daya untuk membantu adaptasi |
| 5 | Hasrat Berprestasi | Kepedulian yang tinggi pada pekerjaannya sehingga terdorong untuk bekerja dengan lebih baik atau di atas standar | 2 / Memiliki inisiatif dan menunjukkan keinginan untuk mencapai standar kerja yang telah ditetapkan (minimum sama dengan prestasi rata-rata) |
| 6 | Komunikasi Interpersonal | Kemampuan untuk berkomunikasi secara efektif dengan orang lain, termasuk mendengar aktif, menunjukkan pemahaman, dan memberikan umpan balik baik secara personal maupun kelompok | 3 / Mampu menyampaikan pesan secara jelas, ringkas, dan persuasif; Mampu mendengarkan secara aktif dan memahami perspektif orang lain |
| 7 | Pengelolaan Hubungan | Kemampuan untuk membangun, memelihara, dan mengembangkan hubungan yang positif dan produktif dengan orang lain | 3 / Mempertahankan hubungan pekerjaan, termasuk obrolan tidak terstruktur namun masih berkaitan dengan pekerjaan |
| 8 | Kerjasama | Kemampuan untuk bekerja dalam kelompok dan aktif berpartisipasi dalam pencapaian tujuan | 3 / Berpartisipasi sebagai anggota tim yang baik, melakukan tugas/bagiannya, dan mendukung keputusan tim |
| 9 | Fokus Pada Kualitas | Mendorong dan mempertahankan standar kualitas yang tinggi dalam pekerjaan | 3 / Bertanggung jawab memberikan hasil sesuai standar, menyelesaikan tugas dengan tuntas, dapat diandalkan dan bertanggung jawab |
| 10 | Customer Centric | Mampu memfasilitasi kebutuhan dan kepuasan pelanggan sebagai prioritas utama (customer sesungguhnya atau rekan pemakai hasil kerja) | 3 / Memonitor kepuasan customer, mendistribusikan informasi yang membantu, memberikan servis ramah dan bersikap sebagai sahabat |
| 11 | Inovasi | Menghasilkan solusi inovatif, mencoba cara baru dan berbeda untuk menghadapi masalah dan peluang dalam situasi kerja | 2 / Melakukan pengembangan yang sudah dilakukan sebelumnya untuk meningkatkan pekerjaan individu |
| 12 | Berpikir Analitis | Memecahkan masalah sulit melalui evaluasi seksama dan sistematis terhadap informasi, alternatif, dan konsekuensinya; mempertimbangkan banyak sumber informasi secara sistematis sebelum membuat keputusan akhir | 2 / Dapat melakukan analisis masalah dengan data informasi yang tersedia |
| 13 | Berpikir Konseptual | Kemampuan untuk memahami konsep kompleks dan membuat koneksi logis antara ide-ide terkait | 2 / Menggunakan akal sehat dan pengalaman masalah lalu untuk mengidentifikasi situasi/masalah; melihat kesamaan antara permasalahan sekarang dan masalah lalu |
| 14 | Business Acumen | Memahami konsep-konsep bisnis dan keuangan secara umum, memahami bisnis organisasi, dan menggunakan pengetahuan untuk bekerja secara efektif | 2 / Pemahaman dasar tentang konsep bisnis yang relevan dengan peran mereka; Memahami bagaimana pekerjaan berkontribusi pada tujuan tim/departemen |

#### 5.7.1 Indikator Level 1–5 per Aspek

**1. Integritas**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Mengikuti aturan dan prosedur yang ditetapkan; Membutuhkan pengawasan untuk memastikan kepatuhan |
| 2 | Mampu bertanggung jawab atas tindakan dan keputusan sendiri; Mengakui kesalahan dan bertanggung jawab atas konsekuensinya |
| 3 | Mampu bertindak secara konsisten sesuai dengan nilai-nilai etika dalam berbagai situasi; Membuat keputusan berdasarkan prinsip-prinsip etika yang kuat |
| 4 | Mampu mempengaruhi orang lain untuk bertindak dengan integritas |
| 5 | Menciptakan budaya organisasi yang menjunjung tinggi integritas |

**2. Speed**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Penyelesaian tugas lebih dari waktu yang diberikan |
| 2 | Penyelesaian tugas sesuai dengan deadline waktu yang ditentukan (ontime) |
| 3 | Penyelesaian tugas kurang dari deadline waktu yang ditentukan (intime) |
| 4 | Penyelesaian tugas kurang dari deadline (intime) dengan cara baru untuk mempercepat penyelesaian; Mampu menyelesaikan tugas yang sangat kompleks secara mandiri |
| 5 | Penyelesaian tugas kurang dari deadline (intime) dengan cara baru untuk mempercepat penyelesaian; Mampu menyelesaikan tugas yang sangat kompleks dengan sangat efisien dalam situasi sulit |

**3. Ketelitian Kerja**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Membuat banyak kesalahan dan kurang memperhatikan detail |
| 2 | Mampu menyelesaikan tugas dengan tingkat ketelitian dasar dan menghindari kesalahan yang jelas; Mulai memperhatikan detail, tetapi masih bisa membuat kesalahan |
| 3 | Mampu menyelesaikan tugas dengan ketelitian yang konsisten dan meminimalkan kesalahan; Mampu mengidentifikasi dan menghindari kesalahan dengan efektif |
| 4 | Memiliki standar ketelitian yang tinggi; Mampu menghasilkan pekerjaan yang berkualitas tinggi dan bebas dari kesalahan |
| 5 | Mampu mengantisipasi dan mencegah kesalahan sebelum terjadi; Mampu mengembangkan sistem dan prosedur untuk meningkatkan ketelitian kerja |

**4. Penyesuaian Diri**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Cenderung mempertahankan cara lama dan menghindari hal-hal baru |
| 2 | Lambat dalam mengikuti perubahan dan masih menggunakan petunjuk/metode lama; Memerlukan dukungan dan informasi yang jelas tentang perubahan |
| 3 | Menyesuaikan situasi, aturan, dan metode cara kerja lama dengan menerapkan situasi, aturan, dan metode baru; Mencari informasi dan sumber daya untuk membantu adaptasi |
| 4 | Mengikuti perubahan secara terbuka dan melakukan perubahan dengan sukarela; Mencari cara untuk meningkatkan efektivitas dalam situasi, aturan, dan metode baru |
| 5 | Menjadi agen perubahan yang aktif dan mendorong orang lain untuk beradaptasi; Mampu menciptakan lingkungan yang mendukung perubahan |

**5. Hasrat Berprestasi**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Memberikan usahanya dengan fokus pada tugas dengan prestasi rata-rata; Tidak diperlukan inisiatif untuk memulai tugas atau cara kerja baru |
| 2 | Memiliki inisiatif dan menunjukkan keinginan untuk mencapai standar kerja yang telah ditetapkan (minimum sama dengan prestasi rata-rata) |
| 3 | Mampu bekerja untuk mencapai standar kinerja yang ditetapkan oleh pihak manajemen (misalnya menyesuaikan anggaran, mencapai kuota/target penjualan, persyaratan kualitas, dsb) |
| 4 | Berpikir mandiri dalam menetapkan ukuran keberhasilan kerjanya (misalnya jumlah uang yang dikeluarkan, tingkat penjualan, menilai performansi orang lain, penggunaan waktu, tingkat scrap, memenangkan persaingan, dsb) |
| 5 | Mempunyai kebijakan dalam sistem kerja atau kebiasaan kerjanya sendiri untuk memperbaiki kinerja secara berkelanjutan (target kerja selalu meningkat dari waktu ke waktu) tanpa menetapkan target/tujuan tertentu pada awal kerjanya |

**6. Komunikasi Interpersonal**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Cenderung pasif dalam interaksi; Kesulitan dalam menyampaikan pesan secara jelas; Kurang mampu mendengarkan secara aktif |
| 2 | Mampu menyampaikan pesan secara cukup jelas; Mulai menunjukkan kemampuan untuk mendengarkan; Dapat merespon umpan balik dengan cukup baik |
| 3 | Mampu menyampaikan pesan secara jelas, ringkas, dan persuasif; Mampu mendengarkan secara aktif dan memahami perspektif orang lain |
| 4 | Mampu memahami dan merespons emosi orang lain dengan baik; Mampu membangun hubungan yang kuat dan saling percaya |
| 5 | Dapat memahami sudut pandang orang lain dan memberikan umpan balik yang konstruktif |

**7. Pengelolaan Hubungan**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Mengucilkan diri, menghindari interaksi sosial |
| 2 | Cenderung berfokus pada diri sendiri dan kebutuhan sendiri; Kesulitan dalam memahami perspektif orang lain |
| 3 | Mempertahankan hubungan pekerjaan, termasuk obrolan tidak terstruktur namun masih mengenai hubungan dengan pekerjaan |
| 4 | Membuat hubungan informal/tidak resmi di lingkungan kerja, mengobrol tentang anak-anak, olahraga, berita, dan sebagainya |
| 5 | Sering menyelenggarakan kontak informal/tidak resmi di lingkungan kerja, baik dengan tim internal maupun eksternal; dengan sengaja membangun kesan hubungan yang baik |

**8. Kerjasama**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Tidak menerima keputusan tim dan tidak melaksanakan tugas yang diberikan |
| 2 | Tidak menerima keputusan tim tetapi tetap melaksanakan tugas yang diberikan |
| 3 | Berpartisipasi sebagai anggota tim yang baik, melakukan tugas/bagiannya, dan mendukung keputusan tim |
| 4 | Selalu menjadikan orang lain tahu mengenai proses di dalam grup; Membagi informasi yang berguna dan relevan bagi anggota tim |
| 5 | Berpartisipasi sebagai anggota tim yang baik, melakukan tugas/bagiannya, mendukung keputusan tim, dan memberikan masukan yang dapat diterima dalam tim |

**9. Fokus Pada Kualitas**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Hasil pekerjaan tidak sesuai dengan standar yang ditentukan |
| 2 | Hasil pekerjaan sesuai standar yang ditentukan tetapi tidak sesuai dengan timeline yang ditentukan |
| 3 | Bertanggung jawab memberikan hasil sesuai standar yang ditetapkan; Menyelesaikan tugas dengan tuntas; Dapat diandalkan dan bertanggung jawab |
| 4 | Melakukan perbaikan cara kerja untuk mendapatkan hasil kerja yang efektif dan berkualitas tinggi; Konsisten menghasilkan pekerjaan yang berkualitas tinggi |
| 5 | Menetapkan hasil kerja sendiri yang lebih tinggi dari standar tim; Melakukan usaha/perubahan metode kerja untuk meningkatkan hasil kerja; Menunjukkan usaha mencapai hasil lebih baik; Tangguh menghadapi hambatan untuk mencapai hasil melebihi standar |

**10. Customer Centric**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Memberikan respon seadanya atas pertanyaan/kebutuhan customer; tidak berusaha mencari akar permasalahan atau konteks masalah customer |
| 2 | Menindaklanjuti kebutuhan, permintaan, dan keluhan customer; menjaga customer mengetahui perkembangan produk/jasa perusahaan (tanpa mencari akar permasalahan) |
| 3 | Memonitor kepuasan customer, mendistribusikan informasi yang membantu kepada customer; memberikan servis ramah dan bersikap sebagai sahabat |
| 4 | Memperbaiki masalah yang berkaitan dengan konsumen secara sungguh-sungguh |
| 5 | Selalu siap membantu terutama pada periode kritis konsumen; memberikan akses mudah (nomor HP/telepon) atau menghabiskan banyak waktu di lokasi konsumen |

**11. Inovasi**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Tidak melakukan hal-hal baru dalam pekerjaannya untuk meningkatkan kinerja |
| 2 | Melakukan pengembangan yang sudah dilakukan sebelumnya untuk meningkatkan pekerjaan individu |
| 3 | Melakukan pengembangan yang sudah dilakukan sebelumnya untuk meningkatkan pekerjaan dalam satu tim |
| 4 | Melakukan sesuatu yang baru dan belum pernah dilakukan dalam pekerjaan tersebut sebelumnya guna meningkatkan kinerja, namun sudah dilakukan di tim lain |
| 5 | Melakukan sesuatu/pengembangan baru yang belum dilakukan sebelumnya untuk meningkatkan pekerjaan dalam satu tim |

**12. Berpikir Analitis**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Kurang dapat menggali informasi yang dibutuhkan |
| 2 | Dapat melakukan analisis masalah dengan data informasi yang tersedia |
| 3 | Melihat hubungan mendasar; Menganalisa hubungan antara bagian dari persoalan |
| 4 | Melihat hubungan mendasar; Menganalisa hubungan antar bagian persoalan; Membuat hubungan sebab akibat sederhana dan mengkaji keuntungan/kelemahan setiap alternatif |
| 5 | Menganalisa hubungan antar bagian persoalan; Membuat hubungan sebab akibat sederhana dan mengkaji keuntungan/kelemahan setiap alternatif; Membutuhkan bantuan untuk menganalisis masalah |

**13. Berpikir Konseptual**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Berpikir secara konkrit |
| 2 | Menggunakan akal sehat dan pengalaman masalah lalu untuk mengidentifikasi situasi/masalah; Melihat kesamaan antara permasalahan sekarang dan masalah lalu |
| 3 | Mampu menerapkan konsep-konsep dasar untuk memecahkan masalah sederhana |
| 4 | Menerapkan dan memodifikasi konsep belajar secara wajar (seperti analisis akar masalah) atau menerapkan pengetahuan masa lalu, kecenderungan, dan hubungan antar situasi yang berbeda |
| 5 | Menyatukan ide, isu, dan observasi menjadi konsep tunggal atau penjelasan yang jelas; Mengidentifikasi isu kunci dalam situasi kompleks |

**14. Business Acumen**

| Level | Deskripsi Indikator |
|-------|----------------------|
| 1 | Pemahaman dasar tentang konsep bisnis yang relevan dengan peran mereka; Mampu mengikuti prosedur dan instruksi yang diberikan; Memahami bagaimana pekerjaan berkontribusi pada tujuan tim/departemen |
| 2 | Memahami alur kerja dasar departemen; Mampu menggunakan perangkat lunak/sistem yang relevan dengan pekerjaan mereka |
| 3 | Mampu menerapkan konsep bisnis dalam pekerjaan sehari-hari; Dapat mengidentifikasi masalah dan mencari solusi sesuai prosedur yang ada; Mengelola waktu dan prioritas untuk menyelesaikan tugas |
| 4 | Mampu menganalisis situasi bisnis dan mengidentifikasi peluang untuk perbaikan |
| 5 | Memberikan kontribusi yang signifikan pada tim atau departemen |

---

## 6. Integrasi Sistem

| Dari | Ke | Data yang Dipertukarkan | Contoh |
|------|----|--------------------------|--------|
| Form KPI (Hasil & Perilaku) | Database KPI, KPI_Hasil, KPI_Perilaku | Data perhitungan koefisien, mandays, point, score, dan deskripsi | Saat submit, seluruh baris Jobdesc/CI/SD/HRA dan 14 skor perilaku tersimpan ke tabel terkait |
| Form KPI | Master_Perilaku | Pengambilan Definisi, Minimum Capaian, dan Indikator 1–5 untuk ditampilkan pada 14 subform perilaku | Sistem memuat teks Indikator dari Master_Perilaku berdasarkan aspek_id |
| Review KPI (Lead/Lead HR/Manager) | Review_KPI, KPI | Keputusan review (Approved/Reject), komentar, dan perubahan current_approver_id/status | Lead Approve → current_approver_id pada tabel KPI berubah menjadi Lead HR |
| Admin – Management User | Tabel User | Penambahan, perubahan, penghapusan, dan pengaturan role pengguna (manual atau import Excel/CSV) | Admin mengimpor 20 data pengguna baru via file Excel |
| Seluruh modul | Modul Login (Internal Login + JWT) | Email, password, dan token sesi | Setiap akses ke fitur memerlukan token JWT yang valid hasil login dari seed_akun |

---

## Ringkasan

| Kategori | Jumlah |
|----------|--------|
| Aktor (Role) | 8 |
| Group Actor | 6 |
| Proses Bisnis Utama | 15 |
| Entitas Data | 6 |
| Status KPI | 7 |
| Subform Penilaian Kinerja Hasil | 4 |
| Subform Penilaian Kinerja Perilaku | 14 |
| Aturan Bisnis Utama (R1–R15) | 15 |
| Tabel Referensi Koefisien | 4 (Jobdesc On Time/On Budget, Grade Project, CI, SD, HRA) |

---