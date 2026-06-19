@extends('layouts.app')

@section('title', 'Dokumen KPI Saya')

@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="{{ route('dashboard') }}" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li class="text-gray-700 font-semibold">Dokumen KPI Saya</li>
    </ol>
</nav>

<header class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dokumen KPI Saya</h1>
        <p class="text-gray-600">{{ $user->name }} · {{ $user->role_label }}</p>
    </div>
    <a href="{{ route('kpi.create') }}" class="btn-primary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Buat KPI Baru
    </a>
</header>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Score</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Disubmit</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($documents as $doc)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4 text-sm font-semibold text-gray-800">{{ $doc->period_year }}</td>
                        <td class="px-4 py-4">
                            <span class="badge {{ $doc->status_badge_class }}">{{ $doc->status_label }}</span>
                        </td>
                        <td class="px-4 py-4 text-sm font-semibold text-red-700">{{ number_format($doc->total_score, 2) }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $doc->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            @if($doc->submitted_at)
                                {{ $doc->submitted_at->format('d M Y') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('kpi.show', $doc->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded border border-gray-300 text-gray-700 hover:bg-gray-50 transition"
                                   title="Lihat">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat
                                </a>
                                @if($doc->status === 'draft')
                                    <a href="{{ route('kpi.edit', $doc->id) }}"
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded border border-gray-300 text-yellow-700 hover:bg-yellow-50 transition"
                                       title="Edit">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 mb-4">Belum ada dokumen KPI</p>
                            <a href="{{ route('kpi.create') }}" class="btn-primary text-sm">Buat Sekarang</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
