@extends('layouts.app')
@section('title', 'Detail Review KPI')
@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="{{ route('dashboard') }}" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li><a href="{{ route('review.index') }}" class="text-red-700 hover:underline">Review</a></li>
        <li>/</li>
        <li class="text-gray-700">Detail Review</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Detail KPI — {{ $form->user->name ?? 'N/A' }}</h1>
    <p class="text-gray-600">{{ $form->period_year }} | Role: {{ $form->user->role_label ?? '' }}</p>
    <span class="badge {{ $form->status_badge_class }} mt-2 inline-block">{{ $form->status_label }}</span>
</header>

{{-- A. Kinerja Hasil — Jobdesc --}}
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">A. Kinerja Hasil — Subform Jobdesc</h2>
    @if($form->jobdescs->isEmpty())
        <p class="text-gray-400 text-sm">Tidak ada data Jobdesc.</p>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Koefisien OnTime</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Koef. Grade</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kegiatan & Bukti</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mandays</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jml Koef</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total Mandays</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($form->jobdescs as $jd)
                <tr>
                    <td class="px-3 py-2 text-sm">{{ number_format($jd->penilaian_koefisien_ontime_onbudget, 2) }}</td>
                    <td class="px-3 py-2 text-sm">{{ $jd->penilaian_grade_project ?? '-' }}</td>
                    <td class="px-3 py-2 text-sm">{{ number_format($jd->jumlah_koefisien - $jd->penilaian_koefisien_ontime_onbudget, 3) }}</td>
                    <td class="px-3 py-2 text-sm">{{ $jd->nama_kegiatan_bukti ?? '-' }}</td>
                    <td class="px-3 py-2 text-sm">{{ number_format($jd->mandays_proyek, 0) }}</td>
                    <td class="px-3 py-2 text-sm">{{ number_format($jd->jumlah_koefisien, 3) }}</td>
                    <td class="px-3 py-2 text-sm">{{ number_format($jd->total_mandays_penugasan, 3) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @php $jdTotal = $form->jobdescs->sum('total_mandays_penugasan'); @endphp
    <div class="mt-3 bg-gray-50 rounded p-3 text-sm">
        <p class="font-medium text-gray-700">Total Mandays Jobdesc: <span class="font-bold text-red-700">{{ number_format($jdTotal, 3) }}</span></p>
    </div>
    @endif
</div>

{{-- B. Kinerja Hasil — CI, SD, HRA --}}
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">B. Kinerja Hasil — Subform CI, SD, HRA</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- CI --}}
        <div class="border rounded-lg p-4">
            <h3 class="font-medium text-gray-700 mb-2">Continuous Improvement (CI)</h3>
            @forelse($form->continuesImprovements as $ci)
            <div class="text-sm text-gray-600 mb-1">Jenis: {{ $ci->jenis_kegiatan_bukti }}</div>
            <div class="text-sm text-gray-600 mb-1">Koefisien: <span class="font-medium">{{ number_format($ci->koefisien, 3) }}</span></div>
            <div class="text-sm text-gray-600 mb-1">Kegiatan: {{ $ci->kegiatan }}</div>
            <div class="text-sm text-gray-600 mb-1">Mandays: {{ number_format($ci->mandays, 0) }}</div>
            <div class="text-sm text-gray-600">Point: <span class="font-medium text-red-700">{{ number_format($ci->point, 2) }}</span></div>
            @if(!$loop->last)<hr class="my-2">@endif
            @empty
            <p class="text-gray-400 text-sm">Tidak ada data CI</p>
            @endforelse
        </div>
        {{-- SD --}}
        <div class="border rounded-lg p-4">
            <h3 class="font-medium text-gray-700 mb-2">Self Development (SD)</h3>
            @forelse($form->selfDevelopments as $sd)
            <div class="text-sm text-gray-600 mb-1">Jenis: {{ $sd->jenis_sd }}</div>
            <div class="text-sm text-gray-600 mb-1">Koefisien: <span class="font-medium">{{ number_format($sd->koefisien, 3) }}</span></div>
            <div class="text-sm text-gray-600 mb-1">Kegiatan: {{ $sd->kegiatan }}</div>
            <div class="text-sm text-gray-600 mb-1">Mandays: {{ number_format($sd->mandays, 0) }}</div>
            <div class="text-sm text-gray-600">Point: <span class="font-medium text-red-700">{{ number_format($sd->point, 2) }}</span></div>
            @if(!$loop->last)<hr class="my-2">@endif
            @empty
            <p class="text-gray-400 text-sm">Tidak ada data SD</p>
            @endforelse
        </div>
        {{-- HRA --}}
        <div class="border rounded-lg p-4">
            <h3 class="font-medium text-gray-700 mb-2">HR Activity (HRA)</h3>
            @forelse($form->hrActivities as $hra)
            <div class="text-sm text-gray-600 mb-1">Jenis: {{ $hra->jenis_kegiatan }}</div>
            <div class="text-sm text-gray-600 mb-1">Koefisien: <span class="font-medium">{{ number_format($hra->koefisien, 3) }}</span></div>
            <div class="text-sm text-gray-600 mb-1">Kegiatan: {{ $hra->kegiatan }}</div>
            <div class="text-sm text-gray-600 mb-1">Mandays: {{ number_format($hra->mandays, 0) }}</div>
            <div class="text-sm text-gray-600">Point: <span class="font-medium text-red-700">{{ number_format($hra->point, 2) }}</span></div>
            @if(!$loop->last)<hr class="my-2">@endif
            @empty
            <p class="text-gray-400 text-sm">Tidak ada data HRA</p>
            @endforelse
        </div>
    </div>
    @php
        $ciTotal = $form->continuesImprovements->sum('point');
        $sdTotal = $form->selfDevelopments->sum('point');
        $hraTotal = $form->hrActivities->sum('point');
        $totalPoint = $jdTotal + $ciTotal + $sdTotal + $hraTotal;
    @endphp
    <div class="mt-4 bg-gray-50 rounded-lg p-3 text-sm">
        <p class="font-medium text-gray-700">Total Point Semua Subform: <span class="font-bold text-red-700">{{ number_format($totalPoint, 3) }}</span> (Jobdesc {{ number_format($jdTotal, 3) }} + CI {{ number_format($ciTotal, 2) }} + SD {{ number_format($sdTotal, 2) }} + HRA {{ number_format($hraTotal, 2) }})</p>
    </div>
</div>

{{-- C. Total Cuti & Target --}}
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">C. Total Cuti & Target Point</h2>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="text-center bg-gray-50 rounded p-3">
            <p class="text-xs text-gray-500">Total Cuti</p>
            <p class="font-bold text-lg">{{ $form->total_cuti ?? 0 }}</p>
        </div>
        <div class="text-center bg-gray-50 rounded p-3">
            <p class="text-xs text-gray-500">Hari Kerja Efektif</p>
            <p class="font-bold text-lg">{{ $form->hari_kerja_efektif ?? 238 }}</p>
        </div>
        <div class="text-center bg-gray-50 rounded p-3">
            <p class="text-xs text-gray-500">Koefisien Role</p>
            <p class="font-bold text-lg">{{ number_format($form->koefisien_role ?? 1.000, 3) }}</p>
        </div>
        <div class="text-center bg-gray-50 rounded p-3">
            <p class="text-xs text-gray-500">Target Point Minimal</p>
            <p class="font-bold text-lg">{{ number_format($form->target_point_minimal ?? 238, 0) }}</p>
        </div>
        <div class="text-center bg-red-50 rounded p-3 border border-red-200">
            <p class="text-xs text-red-600">Total Point Diperoleh</p>
            <p class="font-bold text-lg text-red-700">{{ number_format($totalPoint, 3) }}</p>
        </div>
    </div>
</div>

{{-- D. Penilaian Perilaku --}}
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">D. Penilaian Kinerja Perilaku (14 Aspek)</h2>
    @if($form->kinerjaPerilakus->isEmpty())
        <p class="text-gray-400 text-sm">Tidak ada data Kinerja Perilaku.</p>
    @else
    <div class="space-y-3">
        @foreach($form->kinerjaPerilakus as $kp)
        <div class="flex justify-between items-center border-b pb-2">
            <div>
                <p class="font-medium text-sm">{{ $loop->iteration }}. {{ $kp->aspek_kinerja }}</p>
                <p class="text-xs text-gray-500">Score: {{ number_format($kp->score, 2) }} / Min: {{ $kp->minimum_capaian }}</p>
            </div>
            <span class="text-sm text-gray-600 max-w-md text-right">{{ $kp->deskripsi }}</span>
        </div>
        @endforeach
    </div>
    @php $avgPerilaku = $form->kinerjaPerilakus->avg('score'); @endphp
    <div class="mt-4 bg-gray-50 rounded p-3 text-sm">
        <p class="font-medium text-gray-700">Rata-Rata Score Kinerja Perilaku: <span class="font-bold text-red-700">{{ number_format($avgPerilaku, 2) }}</span></p>
    </div>
    @endif
</div>

{{-- E. Preview Final Score --}}
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">E. Preview Final Score</h2>
    @php
        $totalCuti = $form->total_cuti ?? 0;
        $hariKerja = $form->hari_kerja_efektif ?? 238;
        $koefRole = $form->koefisien_role ?? 1.000;
        $targetPoint = $form->target_point_minimal ?? ($hariKerja * $koefRole);
        $finalScoreHasil = $targetPoint > 0 ? (70/100) * 5 * ($totalPoint / $targetPoint) : 0;
        $finalScorePerilaku = (30/100) * 5 * $avgPerilaku;
        $finalKPIScore = $finalScoreHasil + $finalScorePerilaku;
        $predikat = $finalKPIScore >= 8.5 ? 'Excellent' : ($finalKPIScore >= 7.5 ? 'Baik Sekali' : ($finalKPIScore >= 6.25 ? 'Baik' : ($finalKPIScore >= 5 ? 'Cukup' : 'Kurang')));
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-500">Final Score Hasil</p>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($finalScoreHasil, 2) }}</p>
            <p class="text-xs text-gray-500">70% × 5 × ({{ number_format($totalPoint, 2) }} ÷ {{ number_format($targetPoint, 0) }})</p>
        </div>
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-500">Final Score Perilaku</p>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($finalScorePerilaku, 2) }}</p>
            <p class="text-xs text-gray-500">30% × 5 × {{ number_format($avgPerilaku, 2) }}</p>
        </div>
        <div class="text-center p-4 bg-red-50 rounded-lg border border-red-200">
            <p class="text-sm text-red-600">Final KPI Score</p>
            <p class="text-2xl font-bold text-red-700">{{ number_format($finalKPIScore, 2) }}</p>
            <p class="text-xs text-red-600">Hasil + Perilaku</p>
        </div>
        <div class="text-center p-4 bg-red-50 rounded-lg border border-red-200">
            <p class="text-sm text-red-600">Predikat</p>
            <p class="text-2xl font-bold text-red-700">{{ $predikat }}</p>
            <p class="text-xs text-red-600">Skor akhir KPI</p>
        </div>
    </div>
</div>

{{-- F. Komentar Reviewer --}}
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">F. Komentar Reviewer</h2>
    @forelse($form->approvals as $approval)
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
        <p class="text-sm font-medium text-blue-800">{{ $approval->actor->name ?? 'System' }} ({{ $approval->actor->role_label ?? '' }}) — {{ $approval->created_at->format('d/m/Y H:i') }}</p>
        @if($approval->komentar)
        <p class="text-sm text-blue-700">"{{ $approval->komentar }}"</p>
        @endif
        <span class="inline-block mt-1 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded">{{ ucfirst($approval->action) }}</span>
    </div>
    @empty
    <p class="text-gray-400 text-sm">Belum ada komentar reviewer.</p>
    @endforelse
</div>

{{-- G. Keputusan Review --}}
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">G. Keputusan Review</h2>

    {{-- Approve Form --}}
    <form method="POST" action="{{ route('review.approve', $form->id) }}" class="mb-4">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Komentar (opsional)</label>
            <textarea name="komentar" class="w-full border border-gray-300 rounded px-3 py-2" rows="3" placeholder="Tambahkan komentar..."></textarea>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('review.index') }}" class="btn-secondary">Kembali</a>
            <button type="submit" formaction="{{ route('review.reject', $form->id) }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="return confirm('Apakah Anda yakin ingin menolak KPI ini?')">Reject</button>
            <button type="submit" class="btn-primary" onclick="return confirm('Apakah Anda yakin ingin menyetujui KPI ini?')">Approve</button>
        </div>
    </form>
</div>
@endsection
