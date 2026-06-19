@extends('layouts.app')
@section('title', 'Review KPI')
@section('content')
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="{{ route('dashboard') }}" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li class="text-gray-700">Review KPI</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Review KPI</h1>
    <p class="text-gray-600">Daftar KPI bawahan yang menunggu persetujuan</p>
</header>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" class="flex flex-col md:flex-row gap-3 mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari karyawan..." class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700">
        <button type="submit" class="btn-primary">Cari</button>
        @if(request('search'))
            <a href="{{ route('review.index') }}" class="btn-secondary">Reset</a>
        @endif
    </form>

    <div class="flex gap-3 mb-4">
        <button type="button" class="text-sm text-blue-600 hover:underline" onclick="selectAllReview()">Select All</button>
        <button type="button" class="text-sm text-blue-600 hover:underline" onclick="deselectAllReview()">Deselect All</button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase"><input type="checkbox" id="select-all-review" onchange="toggleSelectAllReview()"></th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($forms as $form)
                <tr>
                    <td class="px-4 py-4"><input type="checkbox" class="row-checkbox-review" value="{{ $form->id }}"></td>
                    <td class="px-4 py-4 font-medium text-gray-800">{{ $form->user->name ?? 'N/A' }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $form->user->role_label ?? '' }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $form->period_year }}</td>
                    <td class="px-4 py-4"><span class="badge {{ $form->status_badge_class }}">{{ $form->status_label }}</span></td>
                    <td class="px-4 py-4 text-right">
                        <a href="{{ route('review.show', $form->id) }}" class="text-red-700 hover:underline text-sm">Review KPI</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada dokumen KPI untuk direview.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-end gap-3 mt-4 pt-4 border-t">
        <button type="button" onclick="bulkApproveReview()" class="btn-primary">Approve Selected</button>
        <button type="button" onclick="bulkRejectReview()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Reject Selected</button>
    </div>
</div>

@if($forms instanceof \Illuminate\Pagination\LengthAwarePaginator && $forms->hasPages())
<div class="mt-4">{{ $forms->links() }}</div>
@endif

<div id="bulk-modal-review" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold text-gray-800 mb-2" id="bulk-title-review">Konfirmasi Bulk Action</h3>
        <p class="text-sm text-gray-600 mb-4" id="bulk-message-review">Apakah Anda yakin?</p>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Komentar (untuk semua data terpilih)</label>
            <textarea id="bulk-komentar-review" class="w-full border border-gray-300 rounded px-3 py-2" rows="2" placeholder="Tambahkan komentar..."></textarea>
        </div>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeBulkModalReview()" class="btn-secondary">Batal</button>
            <button type="button" onclick="confirmBulkActionReview()" class="btn-primary" id="bulk-confirm-btn-review">Konfirmasi</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentBulkActionReview = null;

function toggleSelectAllReview() {
    const checked = document.getElementById('select-all-review').checked;
    document.querySelectorAll('.row-checkbox-review').forEach(cb => cb.checked = checked);
}

function selectAllReview() {
    document.querySelectorAll('.row-checkbox-review').forEach(cb => cb.checked = true);
}

function deselectAllReview() {
    document.querySelectorAll('.row-checkbox-review').forEach(cb => cb.checked = false);
}

function getSelectedReviewIds() {
    return Array.from(document.querySelectorAll('.row-checkbox-review:checked')).map(cb => cb.value);
}

function bulkApproveReview() {
    const ids = getSelectedReviewIds();
    if (ids.length === 0) { alert('Pilih minimal 1 data terlebih dahulu.'); return; }
    currentBulkActionReview = 'approve';
    document.getElementById('bulk-title-review').textContent = 'Konfirmasi Approve Selected';
    document.getElementById('bulk-message-review').textContent = 'Apakah Anda yakin ingin menyetujui ' + ids.length + ' KPI terpilih?';
    document.getElementById('bulk-confirm-btn-review').textContent = 'Approve';
    document.getElementById('bulk-modal-review').classList.remove('hidden');
}

function bulkRejectReview() {
    const ids = getSelectedReviewIds();
    if (ids.length === 0) { alert('Pilih minimal 1 data terlebih dahulu.'); return; }
    currentBulkActionReview = 'reject';
    document.getElementById('bulk-title-review').textContent = 'Konfirmasi Reject Selected';
    document.getElementById('bulk-message-review').textContent = 'Apakah Anda yakin ingin menolak ' + ids.length + ' KPI terpilih?';
    document.getElementById('bulk-confirm-btn-review').textContent = 'Reject';
    document.getElementById('bulk-modal-review').classList.remove('hidden');
}

function closeBulkModalReview() {
    document.getElementById('bulk-modal-review').classList.add('hidden');
    document.getElementById('bulk-komentar-review').value = '';
}

function confirmBulkActionReview() {
    const komentar = document.getElementById('bulk-komentar-review').value;
    if (currentBulkActionReview === 'reject' && !komentar) {
        alert('Harap isi komentar alasan penolakan.');
        return;
    }
    const ids = getSelectedReviewIds();
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = currentBulkActionReview === 'approve' ? '{{ route("review.bulk-approve") }}' : '{{ route("review.bulk-reject") }}';
    form.style.display = 'none';

    // CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    form.appendChild(csrfInput);

    // IDs
    const idsInput = document.createElement('input');
    idsInput.type = 'hidden';
    idsInput.name = 'ids';
    idsInput.value = JSON.stringify(ids);
    form.appendChild(idsInput);

    // Komentar
    if (komentar) {
        const komentarInput = document.createElement('input');
        komentarInput.type = 'hidden';
        komentarInput.name = 'komentar';
        komentarInput.value = komentar;
        form.appendChild(komentarInput);
    }

    document.body.appendChild(form);
    form.submit();
}
</script>
@endpush
