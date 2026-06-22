<?php $__env->startSection('title', 'Review KPI'); ?>
<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="<?php echo e(route('dashboard')); ?>" class="text-red-700 hover:underline">Home</a></li>
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
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari karyawan..." class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700">
        <button type="submit" class="btn-primary">Cari</button>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('search')): ?>
            <a href="<?php echo e(route('review.index')); ?>" class="btn-secondary">Reset</a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td class="px-4 py-4"><input type="checkbox" class="row-checkbox-review" value="<?php echo e($form->id); ?>"></td>
                    <td class="px-4 py-4 font-medium text-gray-800"><?php echo e($form->user->name ?? 'N/A'); ?></td>
                    <td class="px-4 py-4 text-gray-600"><?php echo e($form->user->role_label ?? ''); ?></td>
                    <td class="px-4 py-4 text-gray-600"><?php echo e($form->period_year); ?></td>
                    <td class="px-4 py-4"><span class="badge <?php echo e($form->status_badge_class); ?>"><?php echo e($form->status_label); ?></span></td>
                    <td class="px-4 py-4 text-right">
                        <a href="<?php echo e(route('review.show', $form->id)); ?>" class="text-red-700 hover:underline text-sm">Review KPI</a>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada dokumen KPI untuk direview.</td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="flex justify-end gap-3 mt-4 pt-4 border-t">
        <button type="button" onclick="bulkApproveReview()" class="btn-primary">Approve Selected</button>
        <button type="button" onclick="bulkRejectReview()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Reject Selected</button>
    </div>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($forms instanceof \Illuminate\Pagination\LengthAwarePaginator && $forms->hasPages()): ?>
<div class="mt-4"><?php echo e($forms->links()); ?></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
    form.action = currentBulkActionReview === 'approve' ? '<?php echo e(route("review.bulk-approve")); ?>' : '<?php echo e(route("review.bulk-reject")); ?>';
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/review/index.blade.php ENDPATH**/ ?>