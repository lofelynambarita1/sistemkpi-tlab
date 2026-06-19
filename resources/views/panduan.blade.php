@extends('layouts.app')

@section('title', 'Panduan Sistem KPI')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
<style>
    .mermaid svg { font-family: "Inter", system-ui, sans-serif; }
    .mermaid-container pre { background: transparent !important; }
    .mermaid-container .node a {
        color: inherit !important;
        text-decoration: none !important;
        font-weight: 600;
        display: block;
    }
    .mermaid-container .node a:hover { text-decoration: underline !important; }
</style>
@endpush

@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="{{ route('dashboard') }}" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li class="text-gray-700 font-semibold">Panduan</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Panduan Sistem KPI</h1>
    <p class="text-sm text-gray-500 mt-0.5">Dokumentasi dan alur penggunaan sistem penilaian kinerja</p>
</header>

{{-- Tentang Sistem --}}
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-red-700 mb-4">Tentang Sistem</h2>
    <div class="text-sm text-gray-600 leading-relaxed">
        <p class="mb-3">
            <strong>Sistem KPI (Key Performance Indicator)</strong> adalah sistem informasi berbasis web
            yang dikembangkan untuk mengelola proses penilaian kinerja karyawan secara digital
            dan terstandarisasi.
        </p>
        <p>
            Sistem ini menyediakan <strong>4 modul utama</strong> yang dapat diakses melalui sidebar menu.
            Setiap modul dirancang untuk memfasilitasi proses bisnis mulai dari
            pengisian form KPI hingga persetujuan berjenjang dan pelaporan.
        </p>
    </div>
</div>

{{-- Alur Proses --}}
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-red-700 mb-6">Alur Penggunaan Sistem</h2>

    {{-- P1: Autentikasi --}}
    <h3 class="font-semibold text-red-700 mb-4">P1 — Autentikasi & Profil</h3>
    <p class="text-xs text-gray-500 mb-3">Aktor: Semua Karyawan (Associate, Intermediate, Senior, Principle, Lead, Lead HR, Manager, Admin)</p>
    <div class="mermaid-container bg-gray-50 rounded-lg p-4 mb-4 overflow-x-auto">
        <pre class="mermaid">
flowchart LR
    A["Login<br/>Karyawan memasukkan<br/>email dan password"] ==>
    B["Dashboard<br/>Sistem mengarahkan<br/>ke dashboard sesuai role"]
    B ==> C{"Role Check<br/>Identifikasi peran<br/>pengguna"}
    C -->|"Employee"| D["Form KPI<br/>Akses pengisian KPI"]
    C -->|"Lead/HR/Manager"| E["Review KPI<br/>Akses persetujuan"]
    C -->|"Admin"| F["Manajemen User<br/>Akses administrasi"]
        </pre>
    </div>
    <div class="grid grid-cols-3 gap-3 mb-8">
        <div class="p-3 bg-gray-50 rounded kpi-border-primary">
            <div class="font-semibold text-red-700 text-xs">1. Login</div>
            <p class="text-xs text-gray-500 mt-1">Karyawan login dengan email dan password yang didaftarkan oleh Admin.</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary">
            <div class="font-semibold text-red-700 text-xs">2. Dashboard</div>
            <p class="text-xs text-gray-500 mt-1">Sistem menampilkan dashboard yang disesuaikan dengan peran pengguna.</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary">
            <div class="font-semibold text-red-700 text-xs">3. Navigasi</div>
            <p class="text-xs text-gray-500 mt-1">Pengguna diarahkan ke menu yang sesuai berdasarkan role (Employee, Lead, Manager, Admin).</p>
        </div>
    </div>

    {{-- P2: Pengisian KPI --}}
    <h3 class="font-semibold text-yellow-600 mb-4">P2 — Pengisian Form KPI</h3>
    <p class="text-xs text-gray-500 mb-3">Aktor: Associate, Intermediate, Senior, Principle, Lead, Lead HR</p>
    <div class="mermaid-container bg-gray-50 rounded-lg p-4 mb-4 overflow-x-auto">
        <pre class="mermaid">
flowchart LR
    A["Akses Form KPI<br/>Karyawan mengisi<br/>kinerja hasil"] ==>
    B["Subform Perilaku<br/>Isi 14 aspek<br/>penilaian perilaku"]
    B ==> C["Preview Score<br/>Sistem hitung skor<br/>real-time otomatis"]
    C ==> D{"Simpan/Submit?<br/>Draft atau Submit?"}
    D -->|"Draft"| E["Simpan Draft<br/>Data tersimpan<br/>bisa diedit lagi"]
    D -->|"Submit"| F["Submit KPI<br/>Status Draft<br/>→ Submitted"]
        </pre>
    </div>
    <div class="grid grid-cols-3 gap-3 mb-8">
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #EAB308;">
            <div class="font-semibold text-yellow-600 text-xs">1. Kinerja Hasil</div>
            <p class="text-xs text-gray-500 mt-1">Karyawan mengisi subform Jobdesc, CI, SD, dan HRA dengan mandays dan bukti.</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #EAB308;">
            <div class="font-semibold text-yellow-600 text-xs">2. Kinerja Perilaku</div>
            <p class="text-xs text-gray-500 mt-1">Mengisi score 1–5 untuk 14 aspek perilaku; deskripsi indikator muncul otomatis.</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #EAB308;">
            <div class="font-semibold text-yellow-600 text-xs">3. Submit</div>
            <p class="text-xs text-gray-500 mt-1">Karyawan submit KPI; data terkunci dan masuk alur persetujuan berjenjang.</p>
        </div>
    </div>

    {{-- P3: Review --}}
    <h3 class="font-semibold text-green-600 mb-4">P3 — Review & Persetujuan Berjenjang</h3>
    <p class="text-xs text-gray-500 mb-3">Aktor: Lead, Lead HR, Manager</p>
    <div class="mermaid-container bg-gray-50 rounded-lg p-4 mb-4 overflow-x-auto">
        <pre class="mermaid">
flowchart LR
    A["Review Lead<br/>Lead tinjau KPI<br/>bawahan Employee"] ==>
    B{"Keputusan Lead?<br/>Approve atau Reject?"}
    B -->|"Approve"| C["Review Lead HR<br/>Tinjau KPI tingkat<br/>lanjut"]
    B -->|"Reject"| R["Revisi<br/>Status → Need<br/>Revision"]
    C ==> D{"Keputusan Lead HR?<br/>Approve atau Reject?"}
    D -->|"Approve"| E["Final Approval<br/>Manager final<br/>approval"]
    D -->|"Reject"| R
    E ==> F["Hitung Final Score<br/>Skor final dihitung<br/>otomatis"]
    R --> A
        </pre>
    </div>
    <div class="grid grid-cols-3 gap-3 mb-8">
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #16A34A;">
            <div class="font-semibold text-green-600 text-xs">1. Review Lead</div>
            <p class="text-xs text-gray-500 mt-1">Lead meninjau KPI bawahan; approve atau reject dengan komentar.</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #16A34A;">
            <div class="font-semibold text-green-600 text-xs">2. Review Lead HR</div>
            <p class="text-xs text-gray-500 mt-1">Lead HR meninjau KPI tingkat lanjut; approve atau reject.</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #16A34A;">
            <div class="font-semibold text-green-600 text-xs">3. Final Approval</div>
            <p class="text-xs text-gray-500 mt-1">Manager melakukan final approval; Final KPI Score dihitung otomatis.</p>
        </div>
    </div>

    {{-- P4: Dashboard & History --}}
    <h3 class="font-semibold text-blue-600 mb-4">P4 — Dashboard & Riwayat</h3>
    <p class="text-xs text-gray-500 mb-3">Aktor: Semua Karyawan</p>
    <div class="mermaid-container bg-gray-50 rounded-lg p-4 mb-4 overflow-x-auto">
        <pre class="mermaid">
flowchart LR
    A["Dashboard<br/>Visibilitas real-time<br/>status KPI"] ==>
    B{"Peran?<br/>Employee / Lead /<br/>Manager / Admin"}
    B -->|"Employee"| C["History KPI<br/>Lihat riwayat<br/>quarter lalu"]
    B -->|"Lead"| D["Review List<br/>Daftar KPI<br/>menunggu review"]
    B -->|"Manager"| E["Export KPI<br/>Ekspor ke Excel<br/>untuk analisis"]
    B -->|"Admin"| F["User Stats<br/>Jumlah pengguna<br/>per role"]
        </pre>
    </div>
    <div class="grid grid-cols-3 gap-3 mb-8">
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #2563EB;">
            <div class="font-semibold text-blue-600 text-xs">1. Dashboard</div>
            <p class="text-xs text-gray-500 mt-1">Setiap peran melihat dashboard yang disesuaikan: progress, status, dan target KPI.</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #2563EB;">
            <div class="font-semibold text-blue-600 text-xs">2. History</div>
            <p class="text-xs text-gray-500 mt-1">Karyawan melihat riwayat KPI per quarter: status, skor, dan predikat historis.</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #2563EB;">
            <div class="font-semibold text-blue-600 text-xs">3. Export & Analisis</div>
            <p class="text-xs text-gray-500 mt-1">Manager mengekspor KPI ke Excel untuk analisis, pelaporan, atau keperluan payroll.</p>
        </div>
    </div>

    {{-- P5: Manajemen User --}}
    <h3 class="font-semibold text-purple-600 mb-4">P5 — Manajemen Pengguna</h3>
    <p class="text-xs text-gray-500 mb-3">Aktor: Admin</p>
    <div class="mermaid-container bg-gray-50 rounded-lg p-4 mb-4 overflow-x-auto">
        <pre class="mermaid">
flowchart LR
    A["Daftar User<br/>Admin melihat<br/>seluruh pengguna"] ==>
    B{"Aksi?<br/>Tambah / Ubah /<br/>Nonaktifkan"}
    B -->|"Tambah"| C["Form User<br/>Isi data dan<br/>atur role"]
    B -->|"Batch"| D["Export Excel<br/>Download data<br/>seluruh user"]
    B -->|"Ubah"| E["Edit User<br/>Perbarui data<br/>dan status"]
    C ==> F["Simpan<br/>Akun tersimpan<br/>di sistem"]
    D ==> F
    E ==> F
        </pre>
    </div>
    <div class="grid grid-cols-3 gap-3 mb-8">
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #9333EA;">
            <div class="font-semibold text-purple-600 text-xs">1. Daftar & Cari</div>
            <p class="text-xs text-gray-500 mt-1">Admin melihat daftar pengguna dengan filter dan pencarian untuk manajemen akun.</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #9333EA;">
            <div class="font-semibold text-purple-600 text-xs">2. Tambah/Edit</div>
            <p class="text-xs text-gray-500 mt-1">Admin menambahkan pengguna baru atau mengubah data, role, dan status akun.</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #9333EA;">
            <div class="font-semibold text-purple-600 text-xs">3. Export Data</div>
            <p class="text-xs text-gray-500 mt-1">Admin mengekspor data profil seluruh user ke Excel untuk pelaporan, backup, atau integrasi sistem.</p>
        </div>
    </div>

    {{-- P6: Auto-Submit --}}
    <h3 class="font-semibold text-orange-600 mb-4">P6 — Auto-Submit & Perhitungan</h3>
    <p class="text-xs text-gray-500 mb-3">Aktor: Sistem (Scheduler)</p>
    <div class="mermaid-container bg-gray-50 rounded-lg p-4 mb-4 overflow-x-auto">
        <pre class="mermaid">
flowchart LR
    A["Batas Waktu<br/>14 Apr / 14 Jul /<br/>14 Okt / 14 Jan"] ==>
    B["Auto-Submit<br/>Sistem otomatis<br/>submit Draft"] ==>
    C["Atur Approver<br/>current_approver_id<br/>diatur sesuai role"]
    C ==> D["Masuk Alur Review<br/>KPI masuk ke<br/>Lead / Lead HR"]
    D ==> E["Final Score<br/>70% Hasil + 30%<br/>Perilaku = Final"]
        </pre>
    </div>
    <div class="grid grid-cols-3 gap-3 mb-8">
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #EA580C;">
            <div class="font-semibold text-orange-600 text-xs">1. Batas Waktu</div>
            <p class="text-xs text-gray-500 mt-1">Setiap quarter memiliki batas waktu submit (14 Apr, 14 Jul, 14 Okt, 14 Jan).</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #EA580C;">
            <div class="font-semibold text-orange-600 text-xs">2. Auto-Submit</div>
            <p class="text-xs text-gray-500 mt-1">Sistem otomatis mengubah status Draft → Submitted untuk KPI yang belum disubmit manual.</p>
        </div>
        <div class="p-3 bg-gray-50 rounded kpi-border-primary" style="border-left-color: #EA580C;">
            <div class="font-semibold text-orange-600 text-xs">3. Perhitungan Otomatis</div>
            <p class="text-xs text-gray-500 mt-1">Final Score dihitung otomatis: 70% kinerja hasil + 30% kinerja perilaku, dengan predikat sesuai range.</p>
        </div>
    </div>

</div>

{{-- Navigasi Cepat --}}
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-red-700 mb-4">Navigasi Cepat</h2>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('dashboard') }}" class="btn-primary text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Kembali ke Dashboard
        </a>
        <a href="{{ route('kpi.create') }}" class="btn-secondary text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Form KPI
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    mermaid.initialize({
        startOnLoad: true,
        theme: "base",
        themeVariables: {
            primaryColor:       "#B91C1C",
            primaryTextColor:   "#FFFFFF",
            primaryBorderColor: "#7F1D1D",
            lineColor:          "#64748B",
            secondaryColor:     "#F8FAFC",
            tertiaryColor:      "#F1F5F9",
            background:         "#FFFFFF",
            mainBkg:            "#B91C1C",
            nodeBorder:         "#7F1D1D",
            clusterBkg:         "#F8FAFC",
            titleColor:         "#1E293B",
            edgeLabelBackground:"#FFFFFF",
        },
        flowchart: { htmlLabels: true, curve: "basis" },
    });
</script>
@endpush
