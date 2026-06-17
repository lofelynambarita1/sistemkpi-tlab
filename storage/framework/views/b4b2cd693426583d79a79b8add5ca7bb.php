<?php $__env->startSection('title', 'Profil Saya'); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
    <p class="text-gray-500 text-sm mt-1">Kelola informasi akun Anda</p>
</div>
<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <div class="flex items-center gap-4 mb-6">
        <div class="bg-indigo-100 text-indigo-700 rounded-full w-16 h-16 flex items-center justify-center text-2xl font-bold">
            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800"><?php echo e($user->name); ?></h2>
            <span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full text-xs"><?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?></span>
        </div>
    </div>
    <form method="POST" action="<?php echo e(request()->route()->getPrefix() ? url(request()->route()->getPrefix() . '/profile') : route('admin.profile.update')); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="grid grid-cols-1 gap-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="text" value="<?php echo e($user->email); ?>" disabled class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-500">
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                <input type="text" name="jabatan" value="<?php echo e(old('jabatan', $user->jabatan)); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Divisi</label>
                <input type="text" name="divisi" value="<?php echo e(old('divisi', $user->divisi)); ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <input type="text" value="<?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?>" disabled class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-500">
            </div>
            <hr class="my-2">
            <p class="text-sm font-medium text-gray-700">Ubah Password <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin mengubah)</span></p>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\kpi-system\resources\views/profile/show.blade.php ENDPATH**/ ?>