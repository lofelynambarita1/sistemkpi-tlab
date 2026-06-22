<?php $__env->startSection('title', 'Profil Saya'); ?>
<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="<?php echo e(route('dashboard')); ?>" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li class="text-gray-700 font-semibold">Profil Saya</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
    <p class="text-gray-600">Informasi profil dan pengaturan akun</p>
</header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="bg-white rounded-lg shadow p-6 lg:col-span-1">
        <div class="text-center mb-6">
            <div class="w-24 h-24 bg-red-100 rounded-full mx-auto mb-3 flex items-center justify-center text-3xl font-bold text-red-700">
                <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

            </div>
            <h2 class="text-lg font-semibold text-gray-800"><?php echo e($user->name); ?></h2>
            <p class="text-sm text-gray-500"><?php echo e($user->email); ?></p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->is_active): ?>
                <span class="badge badge-aktif mt-2">AKTIF</span>
            <?php else: ?>
                <span class="badge badge-dicabut mt-2">NONAKTIF</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Role</span>
                <span class="font-medium text-gray-800"><?php echo e($user->role_label ?? ucfirst(str_replace('_', ' ', $user->role))); ?></span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Jabatan</span>
                <span class="font-medium text-gray-800"><?php echo e($user->jabatan ?? '-'); ?></span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Divisi</span>
                <span class="font-medium text-gray-800"><?php echo e($user->divisi ?? '-'); ?></span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Atasan</span>
                <span class="font-medium text-gray-800"><?php echo e($user->atasan->name ?? '—'); ?></span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500">Tanggal Bergabung</span>
                <span class="font-medium text-gray-800"><?php echo e($user->created_at ? $user->created_at->format('d M Y') : '-'); ?></span>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Ubah Password</h2>
        <form method="POST" action="<?php echo e(route('profile.update')); ?>" class="max-w-lg">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="mb-4">
                <label for="password_lama" class="block text-sm font-medium text-gray-700 mb-1">Password Lama <span class="text-red-500">*</span></label>
                <input type="password" id="password_lama" name="password_lama" required minlength="8"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 <?php $__errorArgs = ['password_lama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="Masukkan password lama">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password_lama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="password_baru" class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-red-500">*</span></label>
                <input type="password" id="password_baru" name="password_baru" required minlength="8"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 <?php $__errorArgs = ['password_baru'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="Minimal 8 karakter">
                <p class="text-xs text-gray-500 mt-1">Password minimal 8 karakter, mengandung huruf dan angka.</p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password_baru'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="password_konfirmasi" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                <input type="password" id="password_konfirmasi" name="password_baru_confirmation" required minlength="8"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700"
                       placeholder="Ulangi password baru">
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <a href="<?php echo e(route('dashboard')); ?>" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Password</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/profile/show.blade.php ENDPATH**/ ?>