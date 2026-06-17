<?php $__env->startSection('title', 'Detail Pengguna'); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-800">Detail Pengguna</h1>
    <a href="<?php echo e(route('admin.users.index')); ?>" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm">
        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
    </a>
</div>
<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <div class="flex items-center gap-4 mb-6">
        <div class="bg-indigo-100 text-indigo-700 rounded-full w-16 h-16 flex items-center justify-center text-2xl font-bold">
            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800"><?php echo e($user->name); ?></h2>
            <p class="text-gray-500 text-sm"><?php echo e($user->email); ?></p>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div><p class="text-gray-500">Role</p><p class="font-medium"><?php echo e(ucfirst(str_replace('_',' ',$user->role))); ?></p></div>
        <div><p class="text-gray-500">Jabatan</p><p class="font-medium"><?php echo e($user->jabatan ?? '-'); ?></p></div>
        <div><p class="text-gray-500">Divisi</p><p class="font-medium"><?php echo e($user->divisi ?? '-'); ?></p></div>
        <div><p class="text-gray-500">Status</p>
            <?php if($user->is_active): ?>
                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs">Aktif</span>
            <?php else: ?>
                <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs">Nonaktif</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="mt-6 flex gap-3">
        <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">Edit</a>
        <form method="POST" action="<?php echo e(route('admin.users.reset-password', $user)); ?>" onsubmit="return confirm('Reset password ke password123?')">
            <?php echo csrf_field(); ?>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Reset Password</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\kpi-system\resources\views/admin/users/show.blade.php ENDPATH**/ ?>