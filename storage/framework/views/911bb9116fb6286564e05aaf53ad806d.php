<?php $__env->startSection('title', 'Dashboard Lead HR'); ?>
<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li class="text-gray-700 font-semibold">Dashboard</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard <?php echo e($user->role_label); ?></h1>
    <p class="text-gray-600">Kelola &amp; Review Dokumen KPI Seluruh Bawahan</p>
    <p class="text-sm text-gray-500 mt-1">Login sebagai: <strong><?php echo e($user->name); ?></strong> (<?php echo e($user->role_label); ?>)</p>
</header>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total Bawahan</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($totalBawahan); ?></p>
        <p class="text-sm text-gray-400">Seluruh staff di bawah kamu</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Menunggu Review</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($kpiMenunggu); ?></p>
        <p class="text-sm text-gray-400">Perlu ditinjau</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Disetujui</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($kpiApproved); ?></p>
        <p class="text-sm text-gray-400">Telah di-approve</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
        <p class="text-sm text-gray-500">Perlu Revisi</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($kpiDitolak); ?></p>
        <p class="text-sm text-gray-400">Ditolak / perlu revisi</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Rekap Status KPI Bawahan</h3>
    <?php
    $statusColors = [
        'draft' => '#475569', 'submitted' => '#f59e0b',
        'approved' => '#16a34a', 'need_revision' => '#dc2626',
    ];
    $statusLabels = [
        'draft' => 'Draft', 'submitted' => 'Menunggu Review',
        'approved' => 'Disetujui', 'need_revision' => 'Perlu Revisi',
    ];
    $total = max($statusStats->sum(), 1);
    ?>
    <?php $__empty_1 = true; $__currentLoopData = $statusStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
    $color = $statusColors[$status] ?? '#6b7280';
    $label = $statusLabels[$status] ?? ucfirst($status);
    $pct = round(($count / $total) * 100);
    ?>
    <div class="mb-4 last:mb-0">
        <div class="flex items-center justify-between mb-1">
            <span class="text-sm font-medium text-gray-700"><?php echo e($label); ?></span>
            <span class="text-sm font-bold" style="color:<?php echo e($color); ?>"><?php echo e($count); ?> (<?php echo e($pct); ?>%)</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="h-2.5 rounded-full" style="width:<?php echo e($pct); ?>%; background:<?php echo e($color); ?>;"></div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="text-gray-500 text-sm">Belum ada dokumen KPI dari bawahan.</p>
    <?php endif; ?>
    <?php if($kpiMenunggu > 0): ?>
    <div class="mt-4">
        <a href="<?php echo e(route('hr.kpi.index')); ?>" class="btn-primary">Review <?php echo e($kpiMenunggu); ?> Dokumen Sekarang</a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/dashboard/lead_hr.blade.php ENDPATH**/ ?>