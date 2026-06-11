@extends('layouts.app')

@section('title', 'Buat Dokumen KPI Baru')

@push('styles')
<style>
.form-section { background:#fff; border-radius:12px; border:1px solid #e2e8f0; margin-bottom:1.5rem; overflow:hidden; }
.form-section-header { background: linear-gradient(90deg,#2563eb,#1d4ed8); color:#fff; padding:.9rem 1.25rem; font-weight:600; display:flex; align-items:center; gap:.5rem; }
.form-section-body { padding:1.25rem; }
.subform-table th { background:#f8fafc; font-size:.8rem; font-weight:600; text-transform:uppercase; color:#64748b; white-space:nowrap; }
.subform-table td { vertical-align:middle; }
.subform-table input, .subform-table select { font-size:.85rem; }
.calc-field { background:#eff6ff !important; color:#2563eb; font-weight:600; border-color:#bfdbfe !important; }
.btn-add-row { border-style:dashed; }
.tab-form-nav .nav-link { border-radius:8px 8px 0 0; font-weight:500; }
.tab-form-nav .nav-link.active { background:#fff; color:#2563eb; border-bottom:2px solid #2563eb; font-weight:600; }
</style>
@endpush

@section('content')
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0"><i class="bi bi-file-earmark-plus text-primary me-2"></i>Buat Dokumen KPI Baru</h4>
        <small class="text-muted">{{ $user->name }} · {{ $user->role_label }}</small>
    </div>
    <div class="col-auto">
        <a href="{{ route('kpi.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<form method="POST" action="{{ route('kpi.store') }}" id="kpiForm">
    @csrf

    {{-- Header Info --}}
    <div class="form-section">
        <div class="form-section-header">
            <i class="bi bi-info-circle"></i> Informasi Dokumen KPI
        </div>
        <div class="form-section-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Periode Tahun <span class="text-danger">*</span></label>
                    <select name="period_year" class="form-select @error('period_year') is-invalid @enderror" required>
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ old('period_year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-9">
                    <label class="form-label fw-semibold">Catatan (Opsional)</label>
                    <input type="text" name="notes" class="form-control" placeholder="Catatan tambahan..."
                           value="{{ old('notes') }}">
                </div>
            </div>
        </div>
    </div>

    {{-- TAB NAVIGATION --}}
    <ul class="nav tab-form-nav border-bottom mb-0" style="background:#f8fafc; padding:.75rem 1rem 0; border-radius:12px 12px 0 0; border:1px solid #e2e8f0; border-bottom:none;">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-hasil">Penilaian Kinerja Hasil</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-perilaku">Penilaian Kinerja Perilaku</a></li>
    </ul>

    <div class="tab-content" style="background:#f8fafc; border:1px solid #e2e8f0; border-top:none; border-radius:0 0 12px 12px; padding:1.25rem;">

        {{-- ========== TAB 1: PENILAIAN KINERJA HASIL ========== --}}
        <div class="tab-pane fade show active" id="tab-hasil">

            {{-- SUBFORM 1: JOBDESC --}}
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#1d4ed8,#2563eb);">
                    <i class="bi bi-briefcase"></i> Sub Form 1: Jobdesc
                </div>
                <div class="form-section-body">
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered" id="jobdescTable">
                            <thead>
                                <tr>
                                    <th style="min-width:50px">#</th>
                                    <th style="min-width:180px">Penilaian Koefisien On Time &amp; On Budget <span class="text-danger">*</span></th>
                                    <th style="min-width:160px">Penilaian Grade Project <span class="text-danger">*</span></th>
                                    <th style="min-width:200px">Nama Kegiatan dan Bukti</th>
                                    <th style="min-width:120px">Mandays Proyek</th>
                                    <th style="min-width:200px" class="text-info">Jumlah Koefisien (OTB + Grade) <i class="bi bi-lock-fill ms-1" title="Otomatis"></i></th>
                                    <th style="min-width:200px" class="text-info">Total Mandays Penugasan <i class="bi bi-lock-fill ms-1" title="Otomatis"></i></th>
                                    <th style="min-width:50px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="jobdescBody">
                                <tr class="jobdesc-row" data-row="0">
                                    @include('kpi.partials.jobdesc_row', ['index' => 0, 'row' => null])
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8" class="bg-light">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-add-row" onclick="addJobdescRow()">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Baris
                                        </button>
                                        <span class="ms-3 text-muted small">
                                            Total Mandays: <strong class="text-primary" id="jobdescTotal">0.00</strong>
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- SUBFORM 2: CONTINUES IMPROVEMENT --}}
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#16a34a,#22c55e);">
                    <i class="bi bi-arrow-repeat"></i> Sub Form 2: Continues Improvement
                </div>
                <div class="form-section-body">
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered" id="ciTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:220px">Jenis Kegiatan / Bukti <span class="text-danger">*</span></th>
                                    <th style="min-width:200px">Kegiatan</th>
                                    <th style="min-width:110px">Mandays</th>
                                    <th style="min-width:110px" class="text-info">Koefisien <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th style="min-width:110px" class="text-info">Point <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="ciBody">
                                <tr class="ci-row">
                                    @include('kpi.partials.ci_row', ['index' => 0, 'row' => null, 'ciOptions' => $ciOptions])
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="bg-light">
                                        <button type="button" class="btn btn-outline-success btn-sm btn-add-row" onclick="addCIRow()">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Baris
                                        </button>
                                        <span class="ms-3 text-muted small">
                                            Total Point: <strong class="text-success" id="ciTotal">0.00</strong>
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- SUBFORM 3: SELF DEVELOPMENT --}}
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#ca8a04,#fbbf24);">
                    <i class="bi bi-person-check"></i> Sub Form 3: Self Development
                </div>
                <div class="form-section-body">
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered" id="sdTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:220px">Jenis SD <span class="text-danger">*</span></th>
                                    <th style="min-width:200px">Kegiatan</th>
                                    <th style="min-width:110px">Mandays</th>
                                    <th style="min-width:110px" class="text-info">Koefisien <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th style="min-width:110px" class="text-info">Point <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="sdBody">
                                <tr class="sd-row">
                                    @include('kpi.partials.sd_row', ['index' => 0, 'row' => null, 'sdOptions' => $sdOptions])
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="bg-light">
                                        <button type="button" class="btn btn-outline-warning btn-sm btn-add-row" onclick="addSDRow()">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Baris
                                        </button>
                                        <span class="ms-3 text-muted small">
                                            Total Point: <strong class="text-warning" id="sdTotal">0.00</strong>
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- SUBFORM 4: HR ACTIVITY --}}
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#7c3aed,#8b5cf6);">
                    <i class="bi bi-people"></i> Sub Form 4: HR Activity
                </div>
                <div class="form-section-body">
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered" id="hrTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:220px">Jenis Kegiatan <span class="text-danger">*</span></th>
                                    <th style="min-width:200px">Kegiatan</th>
                                    <th style="min-width:110px">Mandays</th>
                                    <th style="min-width:110px" class="text-info">Koefisien <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th style="min-width:110px" class="text-info">Point <i class="bi bi-lock-fill ms-1"></i></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="hrBody">
                                <tr class="hr-row">
                                    @include('kpi.partials.hr_row', ['index' => 0, 'row' => null, 'hrOptions' => $hrOptions])
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="bg-light">
                                        <button type="button" class="btn btn-outline-secondary btn-sm btn-add-row" onclick="addHRRow()">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Baris
                                        </button>
                                        <span class="ms-3 text-muted small">
                                            Total Point: <strong class="text-secondary" id="hrTotal">0.00</strong>
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>{{-- end tab-hasil --}}

        {{-- ========== TAB 2: PENILAIAN KINERJA PERILAKU ========== --}}
        <div class="tab-pane fade" id="tab-perilaku">
            <div class="form-section">
                <div class="form-section-header" style="background:linear-gradient(90deg,#0891b2,#22d3ee);">
                    <i class="bi bi-star-half"></i> Sub Form: Kinerja Perilaku
                </div>
                <div class="form-section-body">
                    <div class="alert alert-info py-2">
                        <i class="bi bi-info-circle me-2"></i>
                        Kolom Aspek Kinerja, Definisi, Minimum Capaian, Indikator, dan Deskripsi sudah ditentukan dan tidak dapat diubah.
                        Isi hanya kolom <strong>Score</strong> untuk setiap aspek.
                    </div>
                    <div class="table-responsive">
                        <table class="table subform-table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:160px">Aspek Kinerja <i class="bi bi-lock-fill ms-1 text-info"></i></th>
                                    <th style="min-width:250px">Definisi <i class="bi bi-lock-fill ms-1 text-info"></i></th>
                                    <th style="min-width:100px">Min. Capaian <i class="bi bi-lock-fill ms-1 text-info"></i></th>
                                    <th style="min-width:220px">Indikator <i class="bi bi-lock-fill ms-1 text-info"></i></th>
                                    <th style="min-width:250px">Deskripsi <i class="bi bi-lock-fill ms-1 text-info"></i></th>
                                    <th style="min-width:100px">Score <span class="text-danger">*</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($masterPerilaku as $i => $p)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><span class="fw-semibold">{{ $p['aspek_kinerja'] }}</span></td>
                                        <td><small>{{ $p['definisi'] }}</small></td>
                                        <td class="text-center">
                                            <span class="badge bg-warning text-dark">≥ {{ $p['minimum_capaian'] }}</span>
                                        </td>
                                        <td><small>{{ $p['indikator'] }}</small></td>
                                        <td><small>{{ $p['deskripsi'] }}</small></td>
                                        <td>
                                            <input type="number" name="perilaku[{{ $i }}][score]"
                                                   class="form-control perilaku-score"
                                                   min="0" max="100" step="0.01"
                                                   placeholder="0 - 100"
                                                   value="{{ old('perilaku.'.$i.'.score', 0) }}"
                                                   data-min="{{ $p['minimum_capaian'] }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-info">
                                    <td colspan="6" class="text-end fw-bold">Total Score Perilaku:</td>
                                    <td><strong class="text-primary" id="perilakuTotal">0.00</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- end tab-content --}}

    {{-- SUMMARY & ACTIONS --}}
    <div class="card border-primary mt-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="row g-2 text-center">
                        <div class="col">
                            <small class="text-muted d-block">Jobdesc</small>
                            <strong class="text-primary" id="summJobdesc">0.00</strong>
                        </div>
                        <div class="col">
                            <small class="text-muted d-block">CI</small>
                            <strong class="text-success" id="summCI">0.00</strong>
                        </div>
                        <div class="col">
                            <small class="text-muted d-block">Self Dev</small>
                            <strong class="text-warning" id="summSD">0.00</strong>
                        </div>
                        <div class="col">
                            <small class="text-muted d-block">HR Act</small>
                            <strong class="text-secondary" id="summHR">0.00</strong>
                        </div>
                        <div class="col">
                            <small class="text-muted d-block">Perilaku</small>
                            <strong class="text-info" id="summPerilaku">0.00</strong>
                        </div>
                        <div class="col border-start">
                            <small class="text-muted d-block">TOTAL</small>
                            <strong class="text-dark fs-5" id="summTotal">0.00</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex justify-content-end gap-2 mt-3 mt-md-0">
                    <button type="submit" name="action" value="draft" class="btn btn-outline-secondary">
                        <i class="bi bi-floppy me-1"></i>Simpan Draft
                    </button>
                    <button type="submit" name="action" value="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i>Submit KPI
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// ==============================
// KOEFISIEN MAPS (from PHP)
// ==============================
const CI_KOEFISIEN = @json(\App\Models\KpiContinuesImprovement::$koefisienMap);
const SD_KOEFISIEN = @json(\App\Models\KpiSelfDevelopment::$koefisienMap);
const HR_KOEFISIEN = @json(\App\Models\KpiHrActivity::$koefisienMap);

// ==============================
// JOBDESC LOGIC
// ==============================
let jobdescRowCount = 1;

function calcJobdescRow(row) {
    const otb     = parseFloat(row.querySelector('.jd-otb').value) || 0;
    const grade   = parseFloat(row.querySelector('.jd-grade').value) || 0;
    const mandays = parseFloat(row.querySelector('.jd-mandays').value) || 0;

    const jumlah = otb + grade;
    const total  = jumlah * mandays;

    row.querySelector('.jd-jumlah').value = jumlah.toFixed(2);
    row.querySelector('.jd-total').value  = total.toFixed(2);
    updateJobdescTotal();
}

function updateJobdescTotal() {
    let sum = 0;
    document.querySelectorAll('.jd-total').forEach(el => sum += parseFloat(el.value) || 0);
    document.getElementById('jobdescTotal').textContent = sum.toFixed(2);
    document.getElementById('summJobdesc').textContent  = sum.toFixed(2);
    updateGrandTotal();
}

function addJobdescRow() {
    const idx  = jobdescRowCount++;
    const tbody = document.getElementById('jobdescBody');
    const tr    = document.createElement('tr');
    tr.className = 'jobdesc-row';
    tr.innerHTML = `
        <td>${idx + 1}</td>
        <td><input type="number" name="jobdesc[${idx}][penilaian_koefisien_ontime_onbudget]" class="form-control jd-otb" min="0" step="0.01" value="0" oninput="calcJobdescRow(this.closest('tr'))"></td>
        <td><input type="number" name="jobdesc[${idx}][penilaian_grade_project]" class="form-control jd-grade" min="0" step="0.01" value="0" oninput="calcJobdescRow(this.closest('tr'))"></td>
        <td><input type="text" name="jobdesc[${idx}][nama_kegiatan_bukti]" class="form-control" placeholder="Nama kegiatan & bukti..."></td>
        <td><input type="number" name="jobdesc[${idx}][mandays_proyek]" class="form-control jd-mandays" min="0" step="0.01" value="0" oninput="calcJobdescRow(this.closest('tr'))"></td>
        <td><input type="text" class="form-control calc-field jd-jumlah" value="0.00" readonly tabindex="-1"></td>
        <td><input type="text" class="form-control calc-field jd-total" value="0.00" readonly tabindex="-1"></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove(); updateJobdescTotal();"><i class="bi bi-trash3"></i></button></td>`;
    tbody.appendChild(tr);
}

// ==============================
// CI LOGIC
// ==============================
let ciRowCount = 1;

function calcCIRow(row) {
    const jenis   = row.querySelector('.ci-jenis').value;
    const mandays = parseFloat(row.querySelector('.ci-mandays').value) || 0;
    const koef    = CI_KOEFISIEN[jenis] || 0.5;
    const point   = koef * mandays;

    row.querySelector('.ci-koef').value  = koef.toFixed(4);
    row.querySelector('.ci-point').value = point.toFixed(4);
    updateCITotal();
}

function updateCITotal() {
    let sum = 0;
    document.querySelectorAll('.ci-point').forEach(el => sum += parseFloat(el.value) || 0);
    document.getElementById('ciTotal').textContent = sum.toFixed(2);
    document.getElementById('summCI').textContent  = sum.toFixed(2);
    updateGrandTotal();
}

function getCIOptions() {
    return Object.keys(CI_KOEFISIEN).map(k => `<option value="${k}">${k}</option>`).join('');
}

function addCIRow() {
    const idx   = ciRowCount++;
    const tbody = document.getElementById('ciBody');
    const tr    = document.createElement('tr');
    tr.className = 'ci-row';
    tr.innerHTML = `
        <td>${idx + 1}</td>
        <td><select name="ci[${idx}][jenis_kegiatan_bukti]" class="form-select ci-jenis" onchange="calcCIRow(this.closest('tr'))"><option value="">-- Pilih --</option>${getCIOptions()}</select></td>
        <td><input type="text" name="ci[${idx}][kegiatan]" class="form-control" placeholder="Nama kegiatan..."></td>
        <td><input type="number" name="ci[${idx}][mandays]" class="form-control ci-mandays" min="0" step="0.01" value="0" oninput="calcCIRow(this.closest('tr'))"></td>
        <td><input type="text" class="form-control calc-field ci-koef" value="0.0000" readonly tabindex="-1"></td>
        <td><input type="text" class="form-control calc-field ci-point" value="0.0000" readonly tabindex="-1"></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove(); updateCITotal();"><i class="bi bi-trash3"></i></button></td>`;
    tbody.appendChild(tr);
}

// ==============================
// SD LOGIC
// ==============================
let sdRowCount = 1;

function calcSDRow(row) {
    const jenis   = row.querySelector('.sd-jenis').value;
    const mandays = parseFloat(row.querySelector('.sd-mandays').value) || 0;
    const koef    = SD_KOEFISIEN[jenis] || 0.5;
    const point   = koef * mandays;

    row.querySelector('.sd-koef').value  = koef.toFixed(4);
    row.querySelector('.sd-point').value = point.toFixed(4);
    updateSDTotal();
}

function updateSDTotal() {
    let sum = 0;
    document.querySelectorAll('.sd-point').forEach(el => sum += parseFloat(el.value) || 0);
    document.getElementById('sdTotal').textContent = sum.toFixed(2);
    document.getElementById('summSD').textContent  = sum.toFixed(2);
    updateGrandTotal();
}

function getSDOptions() {
    return Object.keys(SD_KOEFISIEN).map(k => `<option value="${k}">${k}</option>`).join('');
}

function addSDRow() {
    const idx   = sdRowCount++;
    const tbody = document.getElementById('sdBody');
    const tr    = document.createElement('tr');
    tr.className = 'sd-row';
    tr.innerHTML = `
        <td>${idx + 1}</td>
        <td><select name="sd[${idx}][jenis_sd]" class="form-select sd-jenis" onchange="calcSDRow(this.closest('tr'))"><option value="">-- Pilih --</option>${getSDOptions()}</select></td>
        <td><input type="text" name="sd[${idx}][kegiatan]" class="form-control" placeholder="Nama kegiatan..."></td>
        <td><input type="number" name="sd[${idx}][mandays]" class="form-control sd-mandays" min="0" step="0.01" value="0" oninput="calcSDRow(this.closest('tr'))"></td>
        <td><input type="text" class="form-control calc-field sd-koef" value="0.0000" readonly tabindex="-1"></td>
        <td><input type="text" class="form-control calc-field sd-point" value="0.0000" readonly tabindex="-1"></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove(); updateSDTotal();"><i class="bi bi-trash3"></i></button></td>`;
    tbody.appendChild(tr);
}

// ==============================
// HR ACTIVITY LOGIC
// ==============================
let hrRowCount = 1;

function calcHRRow(row) {
    const jenis   = row.querySelector('.hr-jenis').value;
    const mandays = parseFloat(row.querySelector('.hr-mandays').value) || 0;
    const koef    = HR_KOEFISIEN[jenis] || 0.5;
    const point   = koef * mandays;

    row.querySelector('.hr-koef').value  = koef.toFixed(4);
    row.querySelector('.hr-point').value = point.toFixed(4);
    updateHRTotal();
}

function updateHRTotal() {
    let sum = 0;
    document.querySelectorAll('.hr-point').forEach(el => sum += parseFloat(el.value) || 0);
    document.getElementById('hrTotal').textContent = sum.toFixed(2);
    document.getElementById('summHR').textContent  = sum.toFixed(2);
    updateGrandTotal();
}

function getHROptions() {
    return Object.keys(HR_KOEFISIEN).map(k => `<option value="${k}">${k}</option>`).join('');
}

function addHRRow() {
    const idx   = hrRowCount++;
    const tbody = document.getElementById('hrBody');
    const tr    = document.createElement('tr');
    tr.className = 'hr-row';
    tr.innerHTML = `
        <td>${idx + 1}</td>
        <td><select name="hr[${idx}][jenis_kegiatan]" class="form-select hr-jenis" onchange="calcHRRow(this.closest('tr'))"><option value="">-- Pilih --</option>${getHROptions()}</select></td>
        <td><input type="text" name="hr[${idx}][kegiatan]" class="form-control" placeholder="Nama kegiatan..."></td>
        <td><input type="number" name="hr[${idx}][mandays]" class="form-control hr-mandays" min="0" step="0.01" value="0" oninput="calcHRRow(this.closest('tr'))"></td>
        <td><input type="text" class="form-control calc-field hr-koef" value="0.0000" readonly tabindex="-1"></td>
        <td><input type="text" class="form-control calc-field hr-point" value="0.0000" readonly tabindex="-1"></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove(); updateHRTotal();"><i class="bi bi-trash3"></i></button></td>`;
    tbody.appendChild(tr);
}

// ==============================
// PERILAKU LOGIC
// ==============================
function updatePerilakuTotal() {
    let sum = 0;
    document.querySelectorAll('.perilaku-score').forEach(el => sum += parseFloat(el.value) || 0);
    document.getElementById('perilakuTotal').textContent = sum.toFixed(2);
    document.getElementById('summPerilaku').textContent  = sum.toFixed(2);
    updateGrandTotal();
}

// ==============================
// GRAND TOTAL
// ==============================
function updateGrandTotal() {
    const j = parseFloat(document.getElementById('summJobdesc').textContent) || 0;
    const c = parseFloat(document.getElementById('summCI').textContent) || 0;
    const s = parseFloat(document.getElementById('summSD').textContent) || 0;
    const h = parseFloat(document.getElementById('summHR').textContent) || 0;
    const p = parseFloat(document.getElementById('summPerilaku').textContent) || 0;
    document.getElementById('summTotal').textContent = (j + c + s + h + p).toFixed(2);
}

// ==============================
// INIT
// ==============================
document.addEventListener('DOMContentLoaded', function () {
    // Bind perilaku
    document.querySelectorAll('.perilaku-score').forEach(el => {
        el.addEventListener('input', updatePerilakuTotal);
    });

    // Bind existing jobdesc rows
    document.querySelectorAll('.jobdesc-row').forEach(row => {
        row.querySelectorAll('.jd-otb,.jd-grade,.jd-mandays').forEach(inp => {
            inp.addEventListener('input', () => calcJobdescRow(row));
        });
    });
});
</script>
@endpush
