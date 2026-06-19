<?php $__env->startSection('title', 'Manajemen User'); ?>
<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="<?php echo e(route('dashboard')); ?>" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li class="text-gray-700">Manajemen User</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen User</h1>
    <p class="text-gray-600">Pengelolaan akun karyawan dan hierarki</p>
</header>

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex gap-3 mb-4">
        <form method="GET" class="flex-1 flex gap-3">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari karyawan..." class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700">
            <button type="submit" class="btn-primary">Cari</button>
            <?php if(request('search') || request('role') || request('status')): ?>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn-secondary">Reset</a>
            <?php endif; ?>
        </form>
        <a href="<?php echo e(route('admin.users.export')); ?>" class="btn-secondary">Export Excel</a>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn-primary">+ Tambah User</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Atasan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-4 py-4 font-medium text-gray-800"><?php echo e($u->name); ?></td>
                    <td class="px-4 py-4 text-gray-600"><?php echo e($u->email); ?></td>
                    <td class="px-4 py-4"><span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs"><?php echo e($u->role_label); ?></span></td>
                    <td class="px-4 py-4 text-gray-600"><?php echo e($u->jabatan ?? '-'); ?></td>
                    <td class="px-4 py-4 text-gray-600"><?php echo e($u->atasan->name ?? '-'); ?></td>
                    <td class="px-4 py-4">
                        <?php if($u->is_active): ?>
                            <span class="badge badge-aktif">AKTIF</span>
                        <?php else: ?>
                            <span class="badge badge-dicabut">NONAKTIF</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-4 text-right">
                        <a href="<?php echo e(route('admin.users.edit', $u)); ?>" class="text-blue-600 hover:underline text-sm mr-3">Edit</a>
                        <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $u)); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-red-600 hover:underline text-sm mr-3"><?php echo e($u->is_active ? 'Nonaktif' : 'Aktifkan'); ?></button>
                        </form>
                        <button type="button"
                            class="text-red-600 hover:underline text-sm"
                            data-delete-url="<?php echo e(route('admin.users.destroy', $u)); ?>"
                            data-delete-desc="User <?php echo e($u->name); ?> akan dihapus permanen.">
                            Hapus
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">Tidak ada pengguna ditemukan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->hasPages()): ?>
<div class="mt-4"><?php echo e($users->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/admin/users/index.blade.php ENDPATH**/ ?>