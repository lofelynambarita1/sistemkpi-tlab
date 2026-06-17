<?php $__env->startSection('title', 'Management User'); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Management User</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola seluruh akun pengguna sistem</p>
    </div>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition">
        <i class="fa-solid fa-plus"></i> Tambah Pengguna
    </a>
</div>
<form method="GET" class="mb-4 flex gap-2">
    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama, email, divisi..." class="border border-gray-300 rounded-lg px-3 py-2 text-sm flex-1 focus:outline-none focus:ring-2 focus:ring-indigo-300">
    <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm"><i class="fa-solid fa-search"></i></button>
</form>
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">Role</th>
                <th class="px-4 py-3 text-left">Divisi</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium text-gray-800"><?php echo e($user->name); ?></td>
                <td class="px-4 py-3 text-gray-600"><?php echo e($user->email); ?></td>
                <td class="px-4 py-3"><span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full text-xs font-medium"><?php echo e($user->role); ?></span></td>
                <td class="px-4 py-3 text-gray-600"><?php echo e($user->divisi ?? '-'); ?></td>
                <td class="px-4 py-3">
                    <?php if($user->is_active): ?>
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs">Aktif</span>
                    <?php else: ?>
                        <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs">Nonaktif</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-center gap-2">
                        <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="text-gray-500 hover:text-indigo-600"><i class="fa-solid fa-eye"></i></a>
                        <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="text-gray-500 hover:text-yellow-600"><i class="fa-solid fa-pen"></i></a>
                        <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" class="inline"><?php echo csrf_field(); ?><button type="submit" class="text-gray-500 hover:text-blue-600"><i class="fa-solid <?php echo e($user->is_active ? 'fa-toggle-on' : 'fa-toggle-off'); ?>"></i></button></form>
                        <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" class="inline" onsubmit="return confirm('Hapus pengguna ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit" class="text-gray-500 hover:text-red-600"><i class="fa-solid fa-trash"></i></button></form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada pengguna.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="mt-4"><?php echo e($users->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\kpi-system\resources\views/admin/users/index.blade.php ENDPATH**/ ?>