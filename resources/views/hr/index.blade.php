@extends('layouts.app')

@section('title', 'Kelola Dokumen KPI Staff')

@section('content')
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-collection text-primary me-2"></i>Kelola Dokumen KPI Staff
        </h4>
        <small class="text-muted">{{ auth()->user()->name }} · {{ auth()->user()->role_label }}</small>
    </div>
</div>

{{-- FILTER --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('hr.kpi.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Cari Nama Staff</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Nama staff..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="draft"     {{ request('status')=='draft'     ? 'selected':'' }}>Draft</option>
                    <option value="submitted" {{ request('status')=='submitted' ? 'selected':'' }}>Disubmit</option>
                    <option value="reviewed"  {{ request('status')=='reviewed'  ? 'selected':'' }}>Ditinjau</option>
                    <option value="approved"  {{ request('status')=='approved'  ? 'selected':'' }}>Disetujui</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Role</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="">Semua Role</option>
                    <option value="associate"   {{ request('role')=='associate'   ? 'selected':'' }}>Associate</option>
                    <option value="intermediate"{{ request('role')=='intermediate'? 'selected':'' }}>Intermediate</option>
                    <option value="senior"      {{ request('role')=='senior'      ? 'selected':'' }}>Senior</option>
                    <option value="lead"        {{ request('role')=='lead'        ? 'selected':'' }}>Lead</option>
                    <option value="principle"   {{ request('role')=='principle'   ? 'selected':'' }}>Principle</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Tahun</label>
                <select name="year" class="form-select form-select-sm">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ request('year')==$y ? 'selected':'' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="{{ route('hr.kpi.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

{{-- TABLE --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span class="fw-semibold">
            <i class="bi bi-table text-primary me-2"></i>
            Daftar Dokumen KPI
            <span class="badge bg-secondary ms-2">{{ $documents->total() }} dokumen</span>
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-kpi table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Staff</th>
                        <th>Role</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Total Score</th>
                        <th>Disubmit</th>
                        <th>Diperbarui</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr>
                        <td>{{ ($documents->currentPage()-1)*$documents->perPage() + $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#0891b2);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(substr($doc->user->name,0,2)) }}
                                </div>
                                <span class="fw-semibold">{{ $doc->user->name }}</span>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $doc->user->role_label }}</span></td>
                        <td><strong>{{ $doc->period_year }}</strong></td>
                        <td>
                            <span class="status-badge {{ $doc->status_badge_class }}">
                                {{ $doc->status_label }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-semibold text-primary">{{ number_format($doc->total_score, 2) }}</span>
                        </td>
                        <td>
                            @if($doc->submitted_at)
                                <small class="text-muted">{{ $doc->submitted_at->format('d M Y') }}</small>
                            @else
                                <small class="text-muted">—</small>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $doc->updated_at->diffForHumans() }}</small></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1 flex-nowrap">
                                <a href="{{ route('hr.kpi.show', $doc->id) }}"
                                   class="btn btn-sm btn-outline-info btn-action" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('hr.kpi.edit', $doc->id) }}"
                                   class="btn btn-sm btn-outline-warning btn-action" title="Edit / Review">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger btn-action"
                                        data-delete-url="{{ route('hr.kpi.destroy', $doc->id) }}"
                                        data-delete-desc="Dokumen KPI milik {{ $doc->user->name }} ({{ $doc->period_year }}) akan dihapus permanen."
                                        title="Hapus">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            <i class="bi bi-inbox" style="font-size:2.5rem;"></i>
                            <p class="mt-2 mb-0">Tidak ada dokumen KPI ditemukan</p>
                            @if(request()->anyFilled(['search','status','role','year']))
                                <a href="{{ route('hr.kpi.index') }}" class="btn btn-sm btn-outline-secondary mt-2">
                                    Reset Filter
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($documents->hasPages())
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menampilkan {{ $documents->firstItem() }}–{{ $documents->lastItem() }} dari {{ $documents->total() }} dokumen
            </small>
            {{ $documents->links() }}
        </div>
    @endif
</div>
@endsection
