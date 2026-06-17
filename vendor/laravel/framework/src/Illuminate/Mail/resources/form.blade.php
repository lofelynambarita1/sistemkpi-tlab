@extends('layouts.app')
@section('title', 'Form KPI')

@section('content')
<div x-data="kpiForm()" x-init="init()">

{{-- Header & Status --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Form KPI — Periode {{ date('Y') }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $user->name }} · {{ ucfirst($user->role) }}</p>
    </div>
    @if($form)
        <span class="px-3 py-1 rounded-full text-sm font-medium status-{{ $form->status }}">
            {{ $form->statusLabel() }}
        </span>
    @endif
</div>

{{-- Score Summary --}}
@if($form)
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Final KPI Score</p>
        <p class="text-3xl font-bold text-indigo-600 mt-1">{{ number_format($form->final_kpi_score, 2) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Score Kinerja Hasil</p>
        <p class="text-3xl font-bold text-teal-600 mt-1">{{ number_format($form->final_score_kinerja_hasil, 2) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Score Kinerja Perilaku</p>
        <p class="text-3xl font-bold text-purple-600 mt-1">{{ number_format($form->final_score_kinerja_perilaku, 2) }}</p>
    </div>
</div>
@endif

@if(!$form || $form->isEditable())
<form method="POST" id="kpiFormEl">
    @csrf

{{-- ── Total Cuti ──────────────────────────────────────────────────── --}}
<div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
    <h2 class="text-lg font-semibold mb-4 text-gray-800">Total Cuti</h2>
    <div class="flex items-center gap-4">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Jumlah Hari Cuti Diambil</label>
            <input type="number" name="total_cuti" min="0" max="12"
                   value="{{ $form?->total_cuti ?? 0 }}"
                   x-model.number="totalCuti"
                   @change="recalcTargets()"
                   class="border border-gray-300 rounded-lg px-3 py-2 w-32 text-sm focus:ring-2 focus:ring-indigo-500">
            <p class="text-xs text-gray-400 mt-1">Maksimum: 12 hari</p>
        </div>
        <div class="ml-6 space-y-1 text-sm text-gray-600">
            <p>Hari Kerja Efektif: <strong x-text="hariKerjaEfektif"></strong> hari</p>
            <p>Target Minimal 1 Tahun: <strong x-text="targetTotal" class="text-indigo-600"></strong> poin</p>
        </div>
    </div>

    {{-- Target breakdown --}}
    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500">Target Job Desk</p>
            <p class="font-semibold text-gray-800" x-text="targetJobdesk"></p>
        </div>
        <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500">Target Self Dev</p>
            <p class="font-semibold text-gray-800" x-text="targetSD"></p>
        </div>
        <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500">Target HR Activity</p>
            <p class="font-semibold text-gray-800" x-text="targetHRA"></p>
        </div>
        <div class="bg-gray-50 rounded-lg p-3 text-center">
            <p class="text-xs text-gray-500">Target CI</p>
            <p class="font-semibold text-gray-800" x-text="targetCI"></p>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- FORM 1: PENILAIAN KINERJA HASIL --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
<div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
    <h2 class="text-lg font-semibold mb-6 text-gray-800 border-b pb-2">Form 1: Penilaian Kinerja Hasil</h2>

    {{-- ── Subform: Job Desc ── --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-medium text-gray-700">A. Job Desc</h3>
            <button type="button" @click="addJobdesc()"
                    class="text-sm bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Baris
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-xs text-gray-500 border-b">
                        <th class="text-left py-2 pr-3 font-medium">Penilaian On Time & On Budget</th>
                        <th class="text-left py-2 pr-3 font-medium">Grade Project</th>
                        <th class="text-left py-2 pr-3 font-medium">Jumlah Koefisien</th>
                        <th class="text-left py-2 pr-3 font-medium">Nama Kegiatan & Bukti</th>
                        <th class="text-left py-2 pr-3 font-medium">Mandays</th>
                        <th class="text-left py-2 pr-3 font-medium">Total Mandays</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(row, i) in jobdescs" :key="i">
                        <tr class="border-b">
                            <td class="py-2 pr-3">
                                <select :name="`jobdescs[${i}][penilaian_ontime_onbudget]`"
                                        x-model="row.penilaian" @change="calcJobdesc(i)"
                                        class="border border-gray-300 rounded px-2 py-1.5 text-xs w-full focus:ring-1 focus:ring-indigo-400">
                                    <option value="">-- Pilih --</option>
                                    @foreach(\App\Models\KpiJobdesc::$ontimeOptions as $label => $val)
                                        <option value="{{ $label }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="py-2 pr-3">
                                <select :name="`jobdescs[${i}][grade_project]`"
                                        x-model="row.grade" @change="calcJobdesc(i)"
                                        class="border border-gray-300 rounded px-2 py-1.5 text-xs w-20 focus:ring-1 focus:ring-indigo-400">
                                    <option value="">--</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" readonly :value="row.jumlahKoef.toFixed(3)"
                                       class="bg-gray-50 border border-gray-200 rounded px-2 py-1.5 text-xs w-24 text-center text-gray-600">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" :name="`jobdescs[${i}][nama_kegiatan_bukti]`"
                                       x-model="row.kegiatan" placeholder="Nama kegiatan..."
                                       class="border border-gray-300 rounded px-2 py-1.5 text-xs w-full focus:ring-1 focus:ring-indigo-400">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="number" :name="`jobdescs[${i}][mandays_proyek]`"
                                       x-model.number="row.mandays" min="1" @input="calcJobdesc(i)"
                                       placeholder="0"
                                       class="border border-gray-300 rounded px-2 py-1.5 text-xs w-20 focus:ring-1 focus:ring-indigo-400">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" readonly :value="row.totalMandays.toFixed(3)"
                                       class="bg-gray-50 border border-gray-200 rounded px-2 py-1.5 text-xs w-28 text-center text-gray-600">
                            </td>
                            <td class="py-2">
                                <button type="button" @click="removeJobdesc(i)"
                                        class="text-red-400 hover:text-red-600 transition text-xs">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <p x-show="jobdescs.length === 0" class="text-sm text-gray-400 text-center py-4">
                Belum ada data. Klik "Tambah Baris" untuk menambah.
            </p>
        </div>
    </div>

    {{-- ── Subform: Continuous Improvement ── --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-medium text-gray-700">B. Continuous Improvement</h3>
            <button type="button" @click="addCI()"
                    class="text-sm bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Baris
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-xs text-gray-500 border-b">
                        <th class="text-left py-2 pr-3 font-medium">Jenis Kegiatan / Bukti CI</th>
                        <th class="text-left py-2 pr-3 font-medium">Kegiatan CI</th>
                        <th class="text-left py-2 pr-3 font-medium">Koefisien</th>
                        <th class="text-left py-2 pr-3 font-medium">Mandays CI</th>
                        <th class="text-left py-2 pr-3 font-medium">Point CI</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(row, i) in ciRows" :key="i">
                        <tr class="border-b">
                            <td class="py-2 pr-3">
                                <select :name="`continuous_improvements[${i}][jenis_kegiatan_bukti]`"
                                        x-model="row.jenis" @change="calcCI(i)"
                                        class="border border-gray-300 rounded px-2 py-1.5 text-xs w-full focus:ring-1 focus:ring-indigo-400">
                                    <option value="">-- Pilih --</option>
                                    @foreach(\App\Models\KpiContinuousImprovement::$jenisOptions as $label => $val)
                                        <option value="{{ $label }}">{{ Str::limit($label, 60) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" :name="`continuous_improvements[${i}][kegiatan_ci]`"
                                       x-model="row.kegiatan" placeholder="Kegiatan..."
                                       class="border border-gray-300 rounded px-2 py-1.5 text-xs w-full focus:ring-1 focus:ring-indigo-400">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" readonly :value="row.koefisien"
                                       class="bg-gray-50 border border-gray-200 rounded px-2 py-1.5 text-xs w-20 text-center text-gray-600">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="number" :name="`continuous_improvements[${i}][mandays_ci]`"
                                       x-model.number="row.mandays" min="1" @input="calcCI(i)"
                                       class="border border-gray-300 rounded px-2 py-1.5 text-xs w-20 focus:ring-1 focus:ring-indigo-400">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" readonly :value="row.point.toFixed(3)"
                                       class="bg-gray-50 border border-gray-200 rounded px-2 py-1.5 text-xs w-20 text-center text-gray-600">
                            </td>
                            <td>
                                <button type="button" @click="removeCI(i)"
                                        class="text-red-400 hover:text-red-600 text-xs transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Subform: Self Development ── --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-medium text-gray-700">C. Self Development</h3>
            <button type="button" @click="addSD()"
                    class="text-sm bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Baris
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-xs text-gray-500 border-b">
                        <th class="text-left py-2 pr-3 font-medium">Jenis Kegiatan SD</th>
                        <th class="text-left py-2 pr-3 font-medium">Kegiatan</th>
                        <th class="text-left py-2 pr-3 font-medium">Koefisien</th>
                        <th class="text-left py-2 pr-3 font-medium">Mandays SD</th>
                        <th class="text-left py-2 pr-3 font-medium">Point SD</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(row, i) in sdRows" :key="i">
                        <tr class="border-b">
                            <td class="py-2 pr-3">
                                <select :name="`self_developments[${i}][jenis_kegiatan_sd]`"
                                        x-model="row.jenis" @change="calcSD(i)"
                                        class="border border-gray-300 rounded px-2 py-1.5 text-xs w-full focus:ring-1 focus:ring-indigo-400">
                                    <option value="">-- Pilih --</option>
                                    @foreach(\App\Models\KpiSelfDevelopment::$jenisOptions as $label => $val)
                                        <option value="{{ $label }}">{{ Str::limit($label, 60) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" :name="`self_developments[${i}][kegiatan_sd]`"
                                       x-model="row.kegiatan" placeholder="Kegiatan..."
                                       class="border border-gray-300 rounded px-2 py-1.5 text-xs w-full focus:ring-1 focus:ring-indigo-400">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" readonly :value="row.koefisien"
                                       class="bg-gray-50 border border-gray-200 rounded px-2 py-1.5 text-xs w-20 text-center text-gray-600">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="number" :name="`self_developments[${i}][mandays_sd]`"
                                       x-model.number="row.mandays" min="1" @input="calcSD(i)"
                                       class="border border-gray-300 rounded px-2 py-1.5 text-xs w-20 focus:ring-1 focus:ring-indigo-400">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" readonly :value="row.point.toFixed(3)"
                                       class="bg-gray-50 border border-gray-200 rounded px-2 py-1.5 text-xs w-20 text-center text-gray-600">
                            </td>
                            <td>
                                <button type="button" @click="removeSD(i)"
                                        class="text-red-400 hover:text-red-600 text-xs transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Subform: HR Activity ── --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-medium text-gray-700">D. HR Activity</h3>
            <button type="button" @click="addHRA()"
                    class="text-sm bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Baris
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-xs text-gray-500 border-b">
                        <th class="text-left py-2 pr-3 font-medium">Jenis Kegiatan HRA</th>
                        <th class="text-left py-2 pr-3 font-medium">Kegiatan HRA</th>
                        <th class="text-left py-2 pr-3 font-medium">Koefisien</th>
                        <th class="text-left py-2 pr-3 font-medium">Mandays HRA</th>
                        <th class="text-left py-2 pr-3 font-medium">Point HRA</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(row, i) in hraRows" :key="i">
                        <tr class="border-b">
                            <td class="py-2 pr-3">
                                <select :name="`hr_activities[${i}][jenis_kegiatan_hra]`"
                                        x-model="row.jenis" @change="calcHRA(i)"
                                        class="border border-gray-300 rounded px-2 py-1.5 text-xs w-full focus:ring-1 focus:ring-indigo-400">
                                    <option value="">-- Pilih --</option>
                                    @foreach(\App\Models\KpiHrActivity::$jenisOptions as $label => $val)
                                        <option value="{{ $label }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" :name="`hr_activities[${i}][kegiatan_hra]`"
                                       x-model="row.kegiatan" placeholder="Contoh: Rafting TLab..."
                                       class="border border-gray-300 rounded px-2 py-1.5 text-xs w-full focus:ring-1 focus:ring-indigo-400">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" readonly :value="row.koefisien"
                                       class="bg-gray-50 border border-gray-200 rounded px-2 py-1.5 text-xs w-20 text-center text-gray-600">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="number" :name="`hr_activities[${i}][mandays_hra]`"
                                       x-model.number="row.mandays" min="1" @input="calcHRA(i)"
                                       class="border border-gray-300 rounded px-2 py-1.5 text-xs w-20 focus:ring-1 focus:ring-indigo-400">
                            </td>
                            <td class="py-2 pr-3">
                                <input type="text" readonly :value="row.point.toFixed(3)"
                                       class="bg-gray-50 border border-gray-200 rounded px-2 py-1.5 text-xs w-20 text-center text-gray-600">
                            </td>
                            <td>
                                <button type="button" @click="removeHRA(i)"
                                        class="text-red-400 hover:text-red-600 text-xs transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════════ --}}
{{-- FORM 2: PENILAIAN KINERJA PERILAKU --}}
{{-- ════════════════════════════════════════════════════════════════ --}}
<div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 w-full">Form 2: Penilaian Kinerja Perilaku</h2>
    </div>
    <div class="flex items-center justify-between mb-3">
        <h3 class="font-medium text-gray-700">Kinerja Perilaku</h3>
        <button type="button" @click="addPerilaku()"
                class="text-sm bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition flex items-center gap-1">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Baris
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs text-gray-500 border-b">
                    <th class="text-left py-2 pr-3 font-medium">Aspek</th>
                    <th class="text-left py-2 pr-3 font-medium">Deskripsi</th>
                    <th class="text-left py-2 pr-3 font-medium">Nilai (0–100)</th>
                    <th class="text-left py-2 pr-3 font-medium">Catatan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(row, i) in perilakuRows" :key="i">
                    <tr class="border-b">
                        <td class="py-2 pr-3">
                            <input type="text" :name="`kinerja_perilakus[${i}][aspek]`"
                                   x-model="row.aspek" placeholder="Aspek perilaku..."
                                   class="border border-gray-300 rounded px-2 py-1.5 text-xs w-full focus:ring-1 focus:ring-indigo-400">
                        </td>
                        <td class="py-2 pr-3">
                            <input type="text" :name="`kinerja_perilakus[${i}][deskripsi]`"
                                   x-model="row.deskripsi" placeholder="Deskripsi..."
                                   class="border border-gray-300 rounded px-2 py-1.5 text-xs w-full focus:ring-1 focus:ring-indigo-400">
                        </td>
                        <td class="py-2 pr-3">
                            <input type="number" :name="`kinerja_perilakus[${i}][nilai]`"
                                   x-model.number="row.nilai" min="0" max="100"
                                   class="border border-gray-300 rounded px-2 py-1.5 text-xs w-20 focus:ring-1 focus:ring-indigo-400">
                        </td>
                        <td class="py-2 pr-3">
                            <input type="text" :name="`kinerja_perilakus[${i}][catatan]`"
                                   x-model="row.catatan" placeholder="Catatan..."
                                   class="border border-gray-300 rounded px-2 py-1.5 text-xs w-full focus:ring-1 focus:ring-indigo-400">
                        </td>
                        <td>
                            <button type="button" @click="removePerilaku(i)"
                                    class="text-red-400 hover:text-red-600 text-xs transition">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

{{-- ── Action Buttons ───────────────────────────────────────────────── --}}
<div class="flex gap-3 flex-wrap">
    <button type="button" @click="saveDraft()"
            class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium px-5 py-2.5 rounded-lg transition text-sm">
        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Draft
    </button>
    <button type="button" @click="confirmSubmit()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-lg transition text-sm">
        <i class="fa-solid fa-paper-plane mr-1"></i> Submit KPI
    </button>
</div>

</form>
@else
    {{-- Read-only view when submitted --}}
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-800">
        <i class="fa-solid fa-lock mr-2"></i>
        Form sudah disubmit dan terkunci. Status: <strong>{{ $form->statusLabel() }}</strong>
    </div>
@endif

{{-- Submit Confirm Modal --}}
<div x-show="showConfirm" x-cloak
     class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 max-w-sm w-full mx-4 shadow-xl">
        <h3 class="font-semibold text-gray-900 mb-2">Konfirmasi Submit KPI</h3>
        <p class="text-sm text-gray-600 mb-5">
            Form KPI Hasil dan Perilaku akan disubmit bersamaan. Setelah disubmit, data tidak dapat diubah.
        </p>
        <div class="flex gap-3">
            <button @click="showConfirm = false"
                    class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
                Batal
            </button>
            <form method="POST" action="{{ $form ? route(auth()->user()->role === 'lead_hr' ? 'leadhr.kpi.submit' : (auth()->user()->role === 'lead' ? 'lead.kpi.submit' : (auth()->user()->role === 'principle' ? 'principle.kpi.submit' : 'employee.kpi.submit'))) : '#' }}" class="flex-1">
                @csrf
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
                    Ya, Submit
                </button>
            </form>
        </div>
    </div>
</div>

</div>{{-- end x-data --}}
@endsection

@push('scripts')
<script>
// Koefisien maps (from PHP to JS)
const ontimeMap = @json(\App\Models\KpiJobdesc::$ontimeOptions);
const ciMap     = @json(\App\Models\KpiContinuousImprovement::$jenisOptions);
const sdMap     = @json(\App\Models\KpiSelfDevelopment::$jenisOptions);
const hraMap    = @json(\App\Models\KpiHrActivity::$jenisOptions);
const gradeMap  = @json(collect(['A','B','C'])->mapWithKeys(fn($g) => [$g => auth()->user()->gradeProjectCoefficient($g)]));
const roleCoef  = {{ auth()->user()->roleCoefficient() }};

// Existing data (edit mode)
const existingJobdescs = @json($form?->jobdescs ?? []);
const existingCI       = @json($form?->continuousImprovements ?? []);
const existingSD       = @json($form?->selfDevelopments ?? []);
const existingHRA      = @json($form?->hrActivities ?? []);
const existingPerilaku = @json($form?->kinerjaPerilakus ?? []);
const savedCuti        = {{ $form?->total_cuti ?? 0 }};

function kpiForm() {
    return {
        totalCuti: savedCuti,
        hariKerjaEfektif: 240 - savedCuti,
        targetJobdesk: 0, targetSD: 0, targetHRA: 0, targetCI: 0, targetTotal: 0,
        jobdescs: [],
        ciRows: [],
        sdRows: [],
        hraRows: [],
        perilakuRows: [],
        showConfirm: false,

        init() {
            this.recalcTargets();
            existingJobdescs.forEach(r => this.jobdescs.push({
                penilaian: r.penilaian_ontime_onbudget, grade: r.grade_project,
                kegiatan: r.nama_kegiatan_bukti, mandays: r.mandays_proyek,
                koefOntime: r.koefisien_ontime_onbudget, koefGrade: r.koefisien_grade_project,
                jumlahKoef: parseFloat(r.jumlah_koefisien), totalMandays: parseFloat(r.total_mandays_penugasan)
            }));
            existingCI.forEach(r => this.ciRows.push({
                jenis: r.jenis_kegiatan_bukti, kegiatan: r.kegiatan_ci,
                koefisien: r.koefisien, mandays: r.mandays_ci, point: parseFloat(r.point_ci)
            }));
            existingSD.forEach(r => this.sdRows.push({
                jenis: r.jenis_kegiatan_sd, kegiatan: r.kegiatan_sd,
                koefisien: r.koefisien_sd, mandays: r.mandays_sd, point: parseFloat(r.point_sd)
            }));
            existingHRA.forEach(r => this.hraRows.push({
                jenis: r.jenis_kegiatan_hra, kegiatan: r.kegiatan_hra,
                koefisien: r.koefisien_hra, mandays: r.mandays_hra, point: parseFloat(r.point_hra)
            }));
            existingPerilaku.forEach(r => this.perilakuRows.push({
                aspek: r.aspek, deskripsi: r.deskripsi, nilai: r.nilai, catatan: r.catatan
            }));
        },

        recalcTargets() {
            const hke = 240 - this.totalCuti;
            this.hariKerjaEfektif = hke;
            this.targetJobdesk = Math.round(0.85 * hke * roleCoef);
            this.targetSD      = Math.round(0.05 * hke * roleCoef);
            this.targetHRA     = Math.round(0.05 * hke);
            this.targetCI      = Math.round(0.05 * hke * roleCoef);
            this.targetTotal   = this.targetJobdesk + this.targetSD + this.targetHRA + this.targetCI;
        },

        // ── Jobdesc ─────────────────────────────────────
        addJobdesc() { this.jobdescs.push({ penilaian:'', grade:'', kegiatan:'', mandays:0, koefOntime:0, koefGrade:0, jumlahKoef:0, totalMandays:0 }); },
        removeJobdesc(i) { this.jobdescs.splice(i,1); },
        calcJobdesc(i) {
            const r = this.jobdescs[i];
            r.koefOntime  = ontimeMap[r.penilaian] ?? 0;
            r.koefGrade   = gradeMap[r.grade] ?? 0;
            r.jumlahKoef  = r.koefOntime + r.koefGrade;
            r.totalMandays = (r.mandays * r.jumlahKoef) / 2;
        },

        // ── CI ───────────────────────────────────────────
        addCI() { this.ciRows.push({ jenis:'', kegiatan:'', koefisien:0, mandays:0, point:0 }); },
        removeCI(i) { this.ciRows.splice(i,1); },
        calcCI(i) {
            const r = this.ciRows[i];
            r.koefisien = ciMap[r.jenis] ?? 0;
            r.point = r.koefisien * r.mandays;
        },

        // ── SD ───────────────────────────────────────────
        addSD() { this.sdRows.push({ jenis:'', kegiatan:'', koefisien:0, mandays:0, point:0 }); },
        removeSD(i) { this.sdRows.splice(i,1); },
        calcSD(i) {
            const r = this.sdRows[i];
            r.koefisien = sdMap[r.jenis] ?? 0;
            r.point = r.koefisien * r.mandays;
        },

        // ── HRA ──────────────────────────────────────────
        addHRA() { this.hraRows.push({ jenis:'', kegiatan:'', koefisien:0, mandays:0, point:0 }); },
        removeHRA(i) { this.hraRows.splice(i,1); },
        calcHRA(i) {
            const r = this.hraRows[i];
            r.koefisien = hraMap[r.jenis] ?? 0;
            r.point = r.koefisien * r.mandays;
        },

        // ── Perilaku ─────────────────────────────────────
        addPerilaku() { this.perilakuRows.push({ aspek:'', deskripsi:'', nilai:0, catatan:'' }); },
        removePerilaku(i) { this.perilakuRows.splice(i,1); },

        // ── Save / Submit ─────────────────────────────────
        saveDraft() {
            const form = document.getElementById('kpiFormEl');
            form.action = '{{ $form ? route(auth()->user()->role === "lead_hr" ? "leadhr.kpi.draft" : (auth()->user()->role === "lead" ? "lead.kpi.draft" : (auth()->user()->role === "principle" ? "principle.kpi.draft" : "employee.kpi.draft"))) : "#" }}';
            form.submit();
        },
        confirmSubmit() { this.showConfirm = true; },
    };
}
</script>
@endpush