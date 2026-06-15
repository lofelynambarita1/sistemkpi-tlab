@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">Riwayat Aktivitas</h4>
        <p class="text-muted small mb-0">Semua aktivitas dokumen KPI Anda</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($histories->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-clock-history text-muted" style="font-size:3rem;"></i>
                <p class="text-muted mt-3">Belum ada riwayat aktivitas.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Dokumen KPI</th>
                            <th>Aksi</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $history)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-semibold" style="font-size:.875rem;">
                                    {{ $history->kpiDocument->title ?? '-' }}
                                </div>
                                <small class="text-muted">{{ $history->kpiDocument->code ?? '' }}</small>
                            </td>
                            <td>
                                @php
                                    $badges = [
                                        'created'   => 'bg-success',
                                        'updated'   => 'bg-primary',
                                        'submitted' => 'bg-warning text-dark',
                                        'approved'  => 'bg-success',
                                        'rejected'  => 'bg-danger',
                                        'revised'   => 'bg-secondary',
                                    ];
                                    $badge = $badges[$history->action] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $badge }}">{{ ucfirst($history->action) }}</span>
                            </td>
                            <td>
                                <span class="text-muted small">{{ $history->description ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="small text-muted">
                                    {{ $history->created_at->format('d M Y, H:i') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($histories->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $histories->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection