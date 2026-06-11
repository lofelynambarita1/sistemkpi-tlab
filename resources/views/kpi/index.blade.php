@extends('layouts.app')

@section('title', 'Dokumen KPI Saya')

@section('content')
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0"><i class="bi bi-file-earmark-text text-primary me-2"></i>Dokumen KPI Saya</h4>
        <small class="text-muted">{{ $user->name }} · {{ $user->role_label }}</small>
    </div>
    <div class="col-auto">
        <a href="{{ route('kpi.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>Buat KPI Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-kpi table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Total Score</th>
                        <th>Dibuat</th>
                        <th>Disubmit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $doc->period_year }}</strong></td>
                            <td><span class="status-badge {{ $doc->status_badge_class }}">{{ $doc->status_label }}</span></td>
                            <td class="fw-semibold text-primary">{{ number_format($doc->total_score, 2) }}</td>
                            <td><small class="text-muted">{{ $doc->created_at->format('d M Y') }}</small></td>
                            <td>
                                @if($doc->submitted_at)
                                    <small class="text-muted">{{ $doc->submitted_at->format('d M Y') }}</small>
                                @else
                                    <small class="text-muted">—</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('kpi.show', $doc->id) }}"
                                       class="btn btn-sm btn-outline-info btn-action" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($doc->status === 'draft')
                                        <a href="{{ route('kpi.edit', $doc->id) }}"
                                           class="btn btn-sm btn-outline-warning btn-action" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-file-earmark-x" style="font-size:2.5rem;"></i>
                                <p class="mt-2">Belum ada dokumen KPI</p>
                                <a href="{{ route('kpi.create') }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-lg me-1"></i>Buat Sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
