@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="{{ route('dashboard') }}" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li class="text-gray-700 font-semibold">Riwayat Aktivitas</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Riwayat Aktivitas</h1>
    <p class="text-gray-600">Semua aktivitas dokumen KPI Anda</p>
</header>

<div class="bg-white rounded-lg shadow p-6">
    @if($histories->isEmpty())
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-500">Belum ada riwayat aktivitas.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokumen KPI</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($histories as $history)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-800">
                            {{ $history->kpiDocument->title ?? '-' }}
                            <div class="text-xs text-gray-500">{{ $history->kpiDocument->code ?? '' }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $badgeMap = [
                                    'created'   => 'badge-aktif',
                                    'updated'   => 'badge-diproses',
                                    'submitted' => 'badge-draft',
                                    'approved'  => 'badge-aktif',
                                    'rejected'  => 'badge-rejected',
                                    'revised'   => 'badge-expired',
                                ];
                                $badgeClass = $badgeMap[$history->action] ?? 'badge-expired';
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($history->action) }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $history->description ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 text-right whitespace-nowrap">
                            {{ $history->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($histories->hasPages())
            <div class="mt-4 pt-4 border-t border-gray-200">
                {{ $histories->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
