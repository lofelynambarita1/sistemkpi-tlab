<?php $__env->startSection('title', 'Dashboard Admin'); ?>
<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li class="text-gray-700 font-semibold">Dashboard</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-600">Ringkasan jumlah pengguna berdasarkan role</p>
</header>

<div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-600 mb-6">
    <p class="text-sm text-gray-500">Total Pengguna</p>
    <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($roleCounts->sum()); ?></p>
    <p class="text-sm text-gray-400">Semua role terdaftar</p>
</div>

<?php
$roleLabels = [
    'admin' => 'Admin', 'manager' => 'Manager', 'lead_hr' => 'Lead HR',
    'lead' => 'Lead', 'principle' => 'Principle', 'senior' => 'Senior',
    'intermediate' => 'Intermediate', 'associate' => 'Associate',
];
$roleIcons = [
    'admin' => 'shield', 'manager' => 'briefcase', 'lead_hr' => 'users',
    'lead' => 'star', 'principle' => 'award', 'senior' => 'graduation-cap',
    'intermediate' => 'check-circle', 'associate' => 'user',
];
$roleColors = [
    'admin' => 'bg-purple-100 text-purple-700', 'manager' => 'bg-blue-100 text-blue-700',
    'lead_hr' => 'bg-cyan-100 text-cyan-700', 'lead' => 'bg-yellow-100 text-yellow-700',
    'principle' => 'bg-orange-100 text-orange-700', 'senior' => 'bg-green-100 text-green-700',
    'intermediate' => 'bg-teal-100 text-teal-700', 'associate' => 'bg-gray-100 text-gray-700',
];
?>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $roleLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <div class="bg-white rounded-lg shadow p-5 flex flex-col items-center gap-2 border border-gray-100">
        <div class="rounded-full p-3 <?php echo e($roleColors[$role]); ?>">
            <i class="fa-solid fa-<?php echo e($roleIcons[$role]); ?> text-xl"></i>
        </div>
        <p class="text-gray-500 text-xs font-medium uppercase tracking-wide"><?php echo e($label); ?></p>
        <p class="text-3xl font-bold text-gray-800"><?php echo e($roleCounts[$role] ?? 0); ?></p>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>