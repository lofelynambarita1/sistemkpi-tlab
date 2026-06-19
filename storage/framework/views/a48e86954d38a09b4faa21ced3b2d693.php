<?php $__env->startSection('title', 'Dashboard Principle'); ?>
<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li class="text-gray-700 font-semibold">Dashboard</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard KPI</h1>
    <p class="text-gray-600">Ringkasan penilaian kinerja karyawan</p>
    <p class="text-sm text-gray-500 mt-1">Login sebagai: <strong><?php echo e($user->name); ?></strong> (<?php echo e($user->role_label); ?>)</p>
</header>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total KPI</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($totalKpi); ?></p>
        <p class="text-sm text-gray-400">Total dokumen KPI</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Disetujui</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($approved); ?></p>
        <p class="text-sm text-gray-400">KPI telah di-approve</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Menunggu Review</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($submitted); ?></p>
        <p class="text-sm text-gray-400">Menunggu persetujuan</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
        <p class="text-sm text-gray-500">Perlu Revisi</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($needRevision); ?></p>
        <p class="text-sm text-gray-400">Dokumen perlu direvisi</p>
    </div>
</div>

<?php if($latestKpi): ?>
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumen KPI Terbaru</h3>
    <div class="flex items-center justify-between mb-3">
        <div>
            <p class="font-semibold text-gray-800">KPI <?php echo e($latestKpi->period_year); ?></p>
            <p class="text-sm text-gray-500">Dibuat <?php echo e($latestKpi->created_at->diffForHumans()); ?></p>
        </div>
        <span class="badge badge-<?php echo e($latestKpi->status); ?>"><?php echo e($latestKpi->status_label); ?></span>
    </div>
    <div class="flex gap-2">
        <a href="<?php echo e(route('kpi.show', $latestKpi->id)); ?>" class="btn-primary">Lihat</a>
        <?php if(in_array($latestKpi->status, ['draft', 'need_revision'])): ?>
        <a href="<?php echo e(route('kpi.edit', $latestKpi->id)); ?>" class="btn-secondary">Edit</a>
        <?php endif; ?>
    </div>
    <?php if($draft > 0): ?>
    <div class="mt-3 px-4 py-3 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-lg text-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Kamu punya <strong><?php echo e($draft); ?></strong> dokumen draft yang belum disubmit.
    </div>
    <?php endif; ?>
    <?php if($needRevision > 0): ?>
    <div class="mt-3 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <strong><?php echo e($needRevision); ?></strong> dokumen perlu direvisi.
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
    <div class="flex flex-wrap gap-3">
        <a href="<?php echo e(route('kpi.create')); ?>" class="btn-primary">Isi Form KPI</a>
        <a href="<?php echo e(route('kpi.index')); ?>" class="btn-secondary">Lihat History</a>
        <a href="<?php echo e(route('profile.show')); ?>" class="btn-secondary">Profil Saya</a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Semua Dokumen KPI</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diperbarui</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $myKpis->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">KPI <?php echo e($doc->period_year); ?></td>
                    <td class="px-4 py-3 text-sm"><span class="badge badge-<?php echo e($doc->status); ?>"><?php echo e($doc->status_label); ?></span></td>
                    <td class="px-4 py-3 text-sm text-gray-500"><?php echo e($doc->updated_at->diffForHumans()); ?></td>
                    <td class="px-4 py-3 text-sm">
                        <a href="<?php echo e(route('kpi.show', $doc->id)); ?>" class="btn-primary" style="padding:0.25rem 0.75rem;">Lihat</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="mb-3">Belum ada dokumen KPI</p>
                        <a href="<?php echo e(route('kpi.create')); ?>" class="btn-primary">Buat Sekarang</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/dashboard/principle.blade.php ENDPATH**/ ?>