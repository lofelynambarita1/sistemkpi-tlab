<?php $__env->startSection('title', 'Dashboard Lead'); ?>
<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li class="text-gray-700 font-semibold">Dashboard</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard <?php echo e($user->role_label); ?></h1>
    <p class="text-gray-600">Pantau Status KPI Tim Kamu</p>
    <p class="text-sm text-gray-500 mt-1">Login sebagai: <strong><?php echo e($user->name); ?></strong> (<?php echo e($user->role_label); ?>)</p>
</header>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total Employee</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($totalEmployee); ?></p>
        <p class="text-sm text-gray-400">Bawahan yang diawasi</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">KPI Menunggu Review</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($totalSubmitted); ?></p>
        <p class="text-sm text-gray-400">Dokumen perlu direview</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Tim</h3>
    <p class="text-gray-600 mb-2">
        Terdapat <strong><?php echo e($totalEmployee); ?></strong> employee (Associate, Intermediate, Senior)
        di bawah pengawasan kamu.
    </p>
    <p class="text-gray-600 mb-4">
        Saat ini <strong class="text-yellow-600"><?php echo e($totalSubmitted); ?></strong> dokumen KPI sedang menunggu review.
    </p>
    <div class="flex flex-wrap gap-3">
        <?php if($totalSubmitted > 0): ?>
        <a href="<?php echo e(route('review.index')); ?>" class="btn-primary">Review Sekarang</a>
        <?php endif; ?>
        <a href="<?php echo e(route('kpi.create')); ?>" class="btn-secondary">Isi Form KPI</a>
        <a href="<?php echo e(route('kpi.index')); ?>" class="btn-secondary">History KPI</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/dashboard/lead.blade.php ENDPATH**/ ?>