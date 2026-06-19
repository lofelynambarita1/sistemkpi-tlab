@extends('layouts.app')

@section('title', 'Edit KPI ' . $kpiDocument->period_year)

@push('styles')
<style>
.subform-table th { background:#f8fafc; font-size:.75rem; font-weight:600; text-transform:uppercase; color:#64748b; white-space:nowrap; padding:0.5rem 0.75rem; }
.subform-table td { padding:0.5rem 0.75rem; vertical-align:middle; }
.subform-table input, .subform-table select { font-size:.85rem; }
.calc-field { cursor:not-allowed; }
.btn-add-row { border-style:dashed; }
.tab-form-nav .nav-link { border-radius:8px 8px 0 0; font-weight:500; padding:0.5rem 1rem; color:#6b7280; border:1px solid transparent; }
.tab-form-nav .nav-link.active { background:#fff; color:#B91C1C; border-bottom:2px solid #B91C1C; font-weight:600; }
</style>
@endpush

@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="{{ route('dashboard') }}" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li><a href="{{ route('kpi.show', $kpiDocument->id) }}" class="text-red-700 hover:underline">Detail KPI</a></li>
        <li>/</li>
        <li class="text-gray-700 font-semibold">Edit KPI</li>
    </ol>
</nav>

<header class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Edit KPI — {{ $kpiDocument->period_year }}</h1>
        <p class="text-gray-600">{{ $user->name }} · {{ $user->role_label }}</p>
    </div>
    <a href="{{ route('kpi.show', $kpiDocument->id) }}" class="btn-secondary">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
</header>

<form method="POST" action="{{ route('kpi.update', $kpiDocument->id) }}" id="kpiForm">
    @csrf
    @method('PUT')

    {{-- Header Info --}}
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="bg-red-700 text-white px-5 py-3 font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Informasi Dokumen KPI
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Periode Tahun</label>
                    <input type="text" class="form-input bg-gray-100 font-bold" value="{{ $kpiDocument->period_year }}" readonly>
                    <input type="hidden" name="period_year" value="{{ $kpiDocument->period_year }}">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                    <input type="text" name="notes" class="form-input" placeholder="Catatan tambahan..."
                           value="{{ old('notes', $kpiDocument->notes) }}">
                </div>
            </div>
        </div>
    </div>

    {{-- TAB NAVIGATION --}}
    <div class="border-b border-gray-200 bg-gray-50 rounded-t-lg px-4 pt-3">
        <ul class="flex gap-1 tab-form-nav">
            <li><a class="nav-link active inline-block" data-bs-toggle="tab" href="#tab-hasil">Penilaian Kinerja Hasil</a></li>
            <li><a class="nav-link inline-block" data-bs-toggle="tab" href="#tab-perilaku">Penilaian Kinerja Perilaku</a></li>
        </ul>
    </div>

    <div class="bg-gray-50 border border-t-0 border-gray-200 rounded-b-lg p-5">

        {{-- ========== TAB 1: HASIL ========== --}}
        <div class="tab-pane fade show active" id="tab-hasil">

            {{-- JOBDESC --}}
            <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
                <div class="bg-red-700 text-white px-5 py-3 font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Sub Form 1: Jobdesc
                </div>
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 subform-table" id="jobdescTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Penilaian Koef. On Time &amp; On Budget</th>
                                    <th>Penilaian Grade Project</th>
                                    <th>Nama Kegiatan dan Bukti</th>
                                    <th>Mandays Proyek</th>
                                    <th class="text-blue-600">Jml Koefisien <svg class="w-3 h-3 inline mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th class="text-blue-600">Total Mandays Penugasan <svg class="w-3 h-3 inline mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="jobdescBody" class="divide-y divide-gray-200">
                                @forelse($kpiDocument->jobdescs as $i => $jd)
                                    <tr class="jobdesc-row">
                                        @include('kpi.partials.jobdesc_row', ['index' => $i, 'row' => $jd])
                                    </tr>
                                @empty
                                    <tr class="jobdesc-row">
                                        @include('kpi.partials.jobdesc_row', ['index' => 0, 'row' => null])
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 flex items-center gap-3">
                        <button type="button" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded border border-dashed border-gray-400 text-gray-600 hover:border-red-400 hover:text-red-700 transition"
                                onclick="addJobdescRow()">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Tambah Baris
                        </button>
                        <span class="text-xs text-gray-500">
                            Total Mandays: <strong class="text-red-700" id="jobdescTotal">0.00</strong>
                        </span>
                    </div>
                </div>
            </div>

            {{-- CI --}}
            <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
                <div class="bg-green-700 text-white px-5 py-3 font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Sub Form 2: Continues Improvement
                </div>
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 subform-table" id="ciTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis Kegiatan / Bukti</th>
                                    <th>Kegiatan</th>
                                    <th>Mandays</th>
                                    <th class="text-green-600">Koefisien <svg class="w-3 h-3 inline mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th class="text-green-600">Point <svg class="w-3 h-3 inline mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="ciBody" class="divide-y divide-gray-200">
                                @forelse($kpiDocument->continuesImprovements as $i => $ci)
                                    <tr class="ci-row">
                                        @include('kpi.partials.ci_row', ['index' => $i, 'row' => $ci, 'ciOptions' => $ciOptions])
                                    </tr>
                                @empty
                                    <tr class="ci-row">
                                        @include('kpi.partials.ci_row', ['index' => 0, 'row' => null, 'ciOptions' => $ciOptions])
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 flex items-center gap-3">
                        <button type="button" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded border border-dashed border-gray-400 text-gray-600 hover:border-green-400 hover:text-green-700 transition"
                                onclick="addCIRow()">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Tambah Baris
                        </button>
                        <span class="text-xs text-gray-500">
                            Total Point: <strong class="text-green-700" id="ciTotal">0.00</strong>
                        </span>
                    </div>
                </div>
            </div>

            {{-- SD --}}
            <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
                <div class="bg-yellow-600 text-white px-5 py-3 font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Sub Form 3: Self Development
                </div>
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 subform-table" id="sdTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis SD</th>
                                    <th>Kegiatan</th>
                                    <th>Mandays</th>
                                    <th class="text-yellow-600">Koefisien <svg class="w-3 h-3 inline mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th class="text-yellow-600">Point <svg class="w-3 h-3 inline mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="sdBody" class="divide-y divide-gray-200">
                                @forelse($kpiDocument->selfDevelopments as $i => $sd)
                                    <tr class="sd-row">
                                        @include('kpi.partials.sd_row', ['index' => $i, 'row' => $sd, 'sdOptions' => $sdOptions])
                                    </tr>
                                @empty
                                    <tr class="sd-row">
                                        @include('kpi.partials.sd_row', ['index' => 0, 'row' => null, 'sdOptions' => $sdOptions])
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 flex items-center gap-3">
                        <button type="button" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded border border-dashed border-gray-400 text-gray-600 hover:border-yellow-500 hover:text-yellow-700 transition"
                                onclick="addSDRow()">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Tambah Baris
                        </button>
                        <span class="text-xs text-gray-500">
                            Total Point: <strong class="text-yellow-600" id="sdTotal">0.00</strong>
                        </span>
                    </div>
                </div>
            </div>

            {{-- HRA --}}
            <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
                <div class="bg-purple-700 text-white px-5 py-3 font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Sub Form 4: HR Activity
                </div>
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 subform-table" id="hrTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>Kegiatan</th>
                                    <th>Mandays</th>
                                    <th class="text-purple-600">Koefisien <svg class="w-3 h-3 inline mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th class="text-purple-600">Point <svg class="w-3 h-3 inline mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="hrBody" class="divide-y divide-gray-200">
                                @forelse($kpiDocument->hrActivities as $i => $hr)
                                    <tr class="hr-row">
                                        @include('kpi.partials.hr_row', ['index' => $i, 'row' => $hr, 'hrOptions' => $hrOptions])
                                    </tr>
                                @empty
                                    <tr class="hr-row">
                                        @include('kpi.partials.hr_row', ['index' => 0, 'row' => null, 'hrOptions' => $hrOptions])
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 flex items-center gap-3">
                        <button type="button" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded border border-dashed border-gray-400 text-gray-600 hover:border-purple-400 hover:text-purple-700 transition"
                                onclick="addHRRow()">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Tambah Baris
                        </button>
                        <span class="text-xs text-gray-500">
                            Total Point: <strong class="text-purple-700" id="hrTotal">0.00</strong>
                        </span>
                    </div>
                </div>
            </div>

        </div>{{-- end tab-hasil --}}

        {{-- ========== TAB 2: PERILAKU ========== --}}
        <div class="tab-pane fade" id="tab-perilaku">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-cyan-700 text-white px-5 py-3 font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    Sub Form: Kinerja Perilaku
                </div>
                <div class="p-5">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4 text-sm text-blue-700 flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Kolom bertanda <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg> tidak dapat diubah. Isi hanya kolom <strong>Score</strong>.</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 subform-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Aspek Kinerja <svg class="w-3 h-3 inline mb-0.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th>Definisi <svg class="w-3 h-3 inline mb-0.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th>Min. Capaian <svg class="w-3 h-3 inline mb-0.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th>Indikator <svg class="w-3 h-3 inline mb-0.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th>Deskripsi <svg class="w-3 h-3 inline mb-0.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10"/></svg></th>
                                    <th>Score <span class="text-red-500">*</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php $masterPerilaku = \App\Models\KpiKinerjaPerilaku::getMasterData(); @endphp
                                @foreach($masterPerilaku as $i => $master)
                                @php
                                    $existing = $kpiDocument->kinerjaPerilakus->get($i);
                                    $scoreVal = $existing ? $existing->score : old("perilaku.$i.score", 0);
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-sm text-gray-500">{{ $i + 1 }}</td>
                                    <td class="px-3 py-2 text-sm font-semibold text-gray-800">{{ $master['aspek_kinerja'] }}</td>
                                    <td class="px-3 py-2 text-xs text-gray-500">{{ $master['definisi'] }}</td>
                                    <td class="px-3 py-2 text-center">
                                        <span class="badge badge-draft text-[10px]">≥ {{ $master['minimum_capaian'] }}</span>
                                    </td>
                                    <td class="px-3 py-2 text-xs text-gray-500">{{ $master['indikator'] }}</td>
                                    <td class="px-3 py-2 text-xs text-gray-500">{{ $master['deskripsi'] }}</td>
                                    <td class="px-3 py-2">
                                        <input type="number"
                                               name="perilaku[{{ $i }}][score]"
                                               class="form-input perilaku-score w-20"
                                               min="0" max="100" step="0.01"
                                               placeholder="0-100"
                                               value="{{ number_format((float)$scoreVal, 2, '.', '') }}"
                                               data-min="{{ $master['minimum_capaian'] }}"
                                               oninput="updatePerilakuTotal()">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 bg-cyan-50 rounded p-3 text-sm flex items-center gap-2">
                        <span class="font-medium text-gray-700">Total Score Perilaku:</span>
                        <strong class="text-cyan-700" id="perilakuTotal">0.00</strong>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- end tab-content --}}

    {{-- SUMMARY & ACTIONS --}}
    <div class="bg-white rounded-lg shadow mt-6 border-t-4 border-red-700">
        <div class="p-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 text-center flex-1">
                    <div>
                        <p class="text-xs text-gray-500">Jobdesc</p>
                        <strong class="text-red-700" id="summJobdesc">0.00</strong>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">CI</p>
                        <strong class="text-green-700" id="summCI">0.00</strong>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Self Dev</p>
                        <strong class="text-yellow-600" id="summSD">0.00</strong>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">HR Act</p>
                        <strong class="text-purple-700" id="summHR">0.00</strong>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Perilaku</p>
                        <strong class="text-cyan-700" id="summPerilaku">0.00</strong>
                    </div>
                    <div class="border-l border-gray-200 pl-3">
                        <p class="text-xs text-gray-500 font-semibold">TOTAL</p>
                        <strong class="text-lg text-gray-800" id="summTotal">0.00</strong>
                    </div>
                </div>
                <div class="flex gap-2 shrink-0">
                    <button type="submit" name="action" value="draft" class="btn-secondary text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan Draft
                    </button>
                    <button type="submit" name="action" value="submit" class="btn-primary text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Submit KPI
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
const CI_KOEFISIEN = @json(\App\Models\KpiContinuesImprovement::$koefisienMap);
const SD_KOEFISIEN = @json(\App\Models\KpiSelfDevelopment::$koefisienMap);
const HR_KOEFISIEN = @json(\App\Models\KpiHrActivity::$koefisienMap);

let jobdescRowCount = {{ $kpiDocument->jobdescs->count() ?: 1 }};
let ciRowCount      = {{ $kpiDocument->continuesImprovements->count() ?: 1 }};
let sdRowCount      = {{ $kpiDocument->selfDevelopments->count() ?: 1 }};
let hrRowCount      = {{ $kpiDocument->hrActivities->count() ?: 1 }};

function calcJobdescRow(row) {
    const otb     = parseFloat(row.querySelector('.jd-otb').value) || 0;
    const grade   = parseFloat(row.querySelector('.jd-grade').value) || 0;
    const mandays = parseFloat(row.querySelector('.jd-mandays').value) || 0;
    const jumlah  = otb + grade;
    row.querySelector('.jd-jumlah').value = jumlah.toFixed(2);
    row.querySelector('.jd-total').value  = (jumlah * mandays).toFixed(2);
    updateJobdescTotal();
}
function updateJobdescTotal() {
    let s = 0; document.querySelectorAll('.jd-total').forEach(e => s += parseFloat(e.value)||0);
    document.getElementById('jobdescTotal').textContent = s.toFixed(2);
    document.getElementById('summJobdesc').textContent  = s.toFixed(2);
    updateGrandTotal();
}
function addJobdescRow() {
    const idx = jobdescRowCount++;
    const tr  = document.createElement('tr'); tr.className = 'jobdesc-row';
    tr.innerHTML = `<td class="px-3 py-2 text-sm text-gray-500">${idx+1}</td>
        <td class="px-3 py-2"><input type="number" name="jobdesc[${idx}][penilaian_koefisien_ontime_onbudget]" class="form-input jd-otb" min="0" step="0.01" value="0" oninput="calcJobdescRow(this.closest('tr'))"></td>
        <td class="px-3 py-2"><input type="number" name="jobdesc[${idx}][penilaian_grade_project]" class="form-input jd-grade" min="0" step="0.01" value="0" oninput="calcJobdescRow(this.closest('tr'))"></td>
        <td class="px-3 py-2"><input type="text" name="jobdesc[${idx}][nama_kegiatan_bukti]" class="form-input" placeholder="Nama kegiatan & bukti..."></td>
        <td class="px-3 py-2"><input type="number" name="jobdesc[${idx}][mandays_proyek]" class="form-input jd-mandays" min="0" step="0.01" value="0" oninput="calcJobdescRow(this.closest('tr'))"></td>
        <td class="px-3 py-2"><input type="text" class="form-input calc-field jd-jumlah" value="0.00" readonly tabindex="-1" style="background:#eff6ff!important;color:#2563eb;font-weight:600;"></td>
        <td class="px-3 py-2"><input type="text" class="form-input calc-field jd-total" value="0.00" readonly tabindex="-1" style="background:#eff6ff!important;color:#2563eb;font-weight:600;"></td>
        <td class="px-3 py-2"><button type="button" class="px-2 py-1 text-xs text-red-600 hover:bg-red-50 rounded border border-red-200" onclick="this.closest('tr').remove();updateJobdescTotal();"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>`;
    document.getElementById('jobdescBody').appendChild(tr);
}

function calcCIRow(row) {
    const jenis = row.querySelector('.ci-jenis').value;
    const md    = parseFloat(row.querySelector('.ci-mandays').value)||0;
    const koef  = CI_KOEFISIEN[jenis]||0.5;
    row.querySelector('.ci-koef').value  = koef.toFixed(4);
    row.querySelector('.ci-point').value = (koef*md).toFixed(4);
    updateCITotal();
}
function updateCITotal() {
    let s=0; document.querySelectorAll('.ci-point').forEach(e=>s+=parseFloat(e.value)||0);
    document.getElementById('ciTotal').textContent = s.toFixed(2);
    document.getElementById('summCI').textContent  = s.toFixed(2);
    updateGrandTotal();
}
function getCIOptions() { return Object.keys(CI_KOEFISIEN).map(k=>`<option value="${k}">${k}</option>`).join(''); }
function addCIRow() {
    const idx = ciRowCount++;
    const tr  = document.createElement('tr'); tr.className='ci-row';
    tr.innerHTML = `<td class="px-3 py-2 text-sm text-gray-500">${idx+1}</td>
        <td class="px-3 py-2"><select name="ci[${idx}][jenis_kegiatan_bukti]" class="form-input ci-jenis" onchange="calcCIRow(this.closest('tr'))"><option value="">-- Pilih --</option>${getCIOptions()}</select></td>
        <td class="px-3 py-2"><input type="text" name="ci[${idx}][kegiatan]" class="form-input" placeholder="Nama kegiatan..."></td>
        <td class="px-3 py-2"><input type="number" name="ci[${idx}][mandays]" class="form-input ci-mandays" min="0" step="0.01" value="0" oninput="calcCIRow(this.closest('tr'))"></td>
        <td class="px-3 py-2"><input type="text" class="form-input calc-field ci-koef" value="0.0000" readonly tabindex="-1" style="background:#f0fdf4!important;color:#16a34a;font-weight:600;"></td>
        <td class="px-3 py-2"><input type="text" class="form-input calc-field ci-point" value="0.0000" readonly tabindex="-1" style="background:#f0fdf4!important;color:#16a34a;font-weight:600;"></td>
        <td class="px-3 py-2"><button type="button" class="px-2 py-1 text-xs text-red-600 hover:bg-red-50 rounded border border-red-200" onclick="this.closest('tr').remove();updateCITotal();"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>`;
    document.getElementById('ciBody').appendChild(tr);
}

function calcSDRow(row) {
    const jenis = row.querySelector('.sd-jenis').value;
    const md    = parseFloat(row.querySelector('.sd-mandays').value)||0;
    const koef  = SD_KOEFISIEN[jenis]||0.5;
    row.querySelector('.sd-koef').value  = koef.toFixed(4);
    row.querySelector('.sd-point').value = (koef*md).toFixed(4);
    updateSDTotal();
}
function updateSDTotal() {
    let s=0; document.querySelectorAll('.sd-point').forEach(e=>s+=parseFloat(e.value)||0);
    document.getElementById('sdTotal').textContent = s.toFixed(2);
    document.getElementById('summSD').textContent  = s.toFixed(2);
    updateGrandTotal();
}
function getSDOptions() { return Object.keys(SD_KOEFISIEN).map(k=>`<option value="${k}">${k}</option>`).join(''); }
function addSDRow() {
    const idx = sdRowCount++;
    const tr  = document.createElement('tr'); tr.className='sd-row';
    tr.innerHTML = `<td class="px-3 py-2 text-sm text-gray-500">${idx+1}</td>
        <td class="px-3 py-2"><select name="sd[${idx}][jenis_sd]" class="form-input sd-jenis" onchange="calcSDRow(this.closest('tr'))"><option value="">-- Pilih --</option>${getSDOptions()}</select></td>
        <td class="px-3 py-2"><input type="text" name="sd[${idx}][kegiatan]" class="form-input" placeholder="Nama kegiatan..."></td>
        <td class="px-3 py-2"><input type="number" name="sd[${idx}][mandays]" class="form-input sd-mandays" min="0" step="0.01" value="0" oninput="calcSDRow(this.closest('tr'))"></td>
        <td class="px-3 py-2"><input type="text" class="form-input calc-field sd-koef" value="0.0000" readonly tabindex="-1" style="background:#fefce8!important;color:#ca8a04;font-weight:600;"></td>
        <td class="px-3 py-2"><input type="text" class="form-input calc-field sd-point" value="0.0000" readonly tabindex="-1" style="background:#fefce8!important;color:#ca8a04;font-weight:600;"></td>
        <td class="px-3 py-2"><button type="button" class="px-2 py-1 text-xs text-red-600 hover:bg-red-50 rounded border border-red-200" onclick="this.closest('tr').remove();updateSDTotal();"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>`;
    document.getElementById('sdBody').appendChild(tr);
}

function calcHRRow(row) {
    const jenis = row.querySelector('.hr-jenis').value;
    const md    = parseFloat(row.querySelector('.hr-mandays').value)||0;
    const koef  = HR_KOEFISIEN[jenis]||0.5;
    row.querySelector('.hr-koef').value  = koef.toFixed(4);
    row.querySelector('.hr-point').value = (koef*md).toFixed(4);
    updateHRTotal();
}
function updateHRTotal() {
    let s=0; document.querySelectorAll('.hr-point').forEach(e=>s+=parseFloat(e.value)||0);
    document.getElementById('hrTotal').textContent = s.toFixed(2);
    document.getElementById('summHR').textContent  = s.toFixed(2);
    updateGrandTotal();
}
function getHROptions() { return Object.keys(HR_KOEFISIEN).map(k=>`<option value="${k}">${k}</option>`).join(''); }
function addHRRow() {
    const idx = hrRowCount++;
    const tr  = document.createElement('tr'); tr.className='hr-row';
    tr.innerHTML = `<td class="px-3 py-2 text-sm text-gray-500">${idx+1}</td>
        <td class="px-3 py-2"><select name="hr[${idx}][jenis_kegiatan]" class="form-input hr-jenis" onchange="calcHRRow(this.closest('tr'))"><option value="">-- Pilih --</option>${getHROptions()}</select></td>
        <td class="px-3 py-2"><input type="text" name="hr[${idx}][kegiatan]" class="form-input" placeholder="Nama kegiatan..."></td>
        <td class="px-3 py-2"><input type="number" name="hr[${idx}][mandays]" class="form-input hr-mandays" min="0" step="0.01" value="0" oninput="calcHRRow(this.closest('tr'))"></td>
        <td class="px-3 py-2"><input type="text" class="form-input calc-field hr-koef" value="0.0000" readonly tabindex="-1" style="background:#f5f3ff!important;color:#7c3aed;font-weight:600;"></td>
        <td class="px-3 py-2"><input type="text" class="form-input calc-field hr-point" value="0.0000" readonly tabindex="-1" style="background:#f5f3ff!important;color:#7c3aed;font-weight:600;"></td>
        <td class="px-3 py-2"><button type="button" class="px-2 py-1 text-xs text-red-600 hover:bg-red-50 rounded border border-red-200" onclick="this.closest('tr').remove();updateHRTotal();"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></td>`;
    document.getElementById('hrBody').appendChild(tr);
}

function updatePerilakuTotal() {
    let s=0; document.querySelectorAll('.perilaku-score').forEach(e=>s+=parseFloat(e.value)||0);
    document.getElementById('perilakuTotal').textContent = s.toFixed(2);
    document.getElementById('summPerilaku').textContent  = s.toFixed(2);
    updateGrandTotal();
}
function updateGrandTotal() {
    const j=parseFloat(document.getElementById('summJobdesc').textContent)||0;
    const c=parseFloat(document.getElementById('summCI').textContent)||0;
    const s=parseFloat(document.getElementById('summSD').textContent)||0;
    const h=parseFloat(document.getElementById('summHR').textContent)||0;
    const p=parseFloat(document.getElementById('summPerilaku').textContent)||0;
    document.getElementById('summTotal').textContent=(j+c+s+h+p).toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    updateJobdescTotal(); updateCITotal(); updateSDTotal(); updateHRTotal(); updatePerilakuTotal();
    document.querySelectorAll('.perilaku-score').forEach(el=>el.addEventListener('input',updatePerilakuTotal));
    document.querySelectorAll('.jobdesc-row').forEach(row=>{
        row.querySelectorAll('.jd-otb,.jd-grade,.jd-mandays').forEach(inp=>{
            inp.addEventListener('input',()=>calcJobdescRow(row));
        });
    });
    document.querySelectorAll('.ci-row').forEach(row=>{
        row.querySelectorAll('.ci-jenis,.ci-mandays').forEach(inp=>{
            inp.addEventListener('change',()=>calcCIRow(row));
            inp.addEventListener('input',()=>calcCIRow(row));
        });
    });
    document.querySelectorAll('.sd-row').forEach(row=>{
        row.querySelectorAll('.sd-jenis,.sd-mandays').forEach(inp=>{
            inp.addEventListener('change',()=>calcSDRow(row));
            inp.addEventListener('input',()=>calcSDRow(row));
        });
    });
    document.querySelectorAll('.hr-row').forEach(row=>{
        row.querySelectorAll('.hr-jenis,.hr-mandays').forEach(inp=>{
            inp.addEventListener('change',()=>calcHRRow(row));
            inp.addEventListener('input',()=>calcHRRow(row));
        });
    });
});
</script>
@endpush
