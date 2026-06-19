<?php $__env->startSection('title', 'Kelola Dokumen KPI Staff'); ?>
<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="<?php echo e(route('dashboard')); ?>" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li class="text-gray-700">Kelola Dokumen KPI</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Kelola Dokumen KPI Staff</h1>
    <p class="text-gray-600"><?php echo e(auth()->user()->name); ?> · <?php echo e(auth()->user()->role_label); ?></p>
</header>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" action="<?php echo e(route('hr.kpi.index')); ?>">
        <div class="flex flex-col md:flex-row gap-3 mb-4">
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-600 mb-1">Cari Nama Staff</label>
                <input type="text" name="search" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700" placeholder="Nama staff..." value="<?php echo e(request('search')); ?>">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700">
                    <option value="">Semua Status</option>
                    <option value="draft" <?php echo e(request('status')=='draft' ? 'selected':''); ?>>Draft</option>
                    <option value="submitted" <?php echo e(request('status')=='submitted' ? 'selected':''); ?>>Disubmit</option>
                    <option value="reviewed" <?php echo e(request('status')=='reviewed' ? 'selected':''); ?>>Ditinjau</option>
                    <option value="approved" <?php echo e(request('status')=='approved' ? 'selected':''); ?>>Disetujui</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Role</label>
                <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700">
                    <option value="">Semua Role</option>
                    <option value="associate" <?php echo e(request('role')=='associate' ? 'selected':''); ?>>Associate</option>
                    <option value="intermediate" <?php echo e(request('role')=='intermediate' ? 'selected':''); ?>>Intermediate</option>
                    <option value="senior" <?php echo e(request('role')=='senior' ? 'selected':''); ?>>Senior</option>
                    <option value="lead" <?php echo e(request('role')=='lead' ? 'selected':''); ?>>Lead</option>
                    <option value="principle" <?php echo e(request('role')=='principle' ? 'selected':''); ?>>Principle</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
                <select name="year" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700">
                    <option value="">Semua Tahun</option>
                    <?php $__currentLoopData = $years ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($y); ?>" <?php echo e(request('year')==$y ? 'selected':''); ?>><?php echo e($y); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="btn-primary">Filter</button>
                <a href="<?php echo e(route('hr.kpi.index')); ?>" class="btn-secondary">Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <span class="font-semibold text-gray-800">
            Daftar Dokumen KPI
            <span class="badge badge-diproses ms-2"><?php echo e($documents->total()); ?> dokumen</span>
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Staff</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Score</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Disubmit</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diperbarui</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-4 py-4 text-sm text-gray-600"><?php echo e(($documents->currentPage()-1)*$documents->perPage() + $loop->iteration); ?></td>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full avatar-primary flex items-center justify-center text-white text-xs font-bold">
                                <?php echo e(strtoupper(substr($doc->user->name, 0, 2))); ?>

                            </div>
                            <span class="font-medium text-gray-800"><?php echo e($doc->user->name); ?></span>
                        </div>
                    </td>
                    <td class="px-4 py-4"><span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-xs"><?php echo e($doc->user->role_label); ?></span></td>
                    <td class="px-4 py-4 font-medium"><?php echo e($doc->period_year); ?></td>
                    <td class="px-4 py-4"><span class="badge <?php echo e($doc->status_badge_class); ?>"><?php echo e($doc->status_label); ?></span></td>
                    <td class="px-4 py-4 font-semibold text-red-700"><?php echo e(number_format($doc->total_score, 2)); ?></td>
                    <td class="px-4 py-4 text-sm text-gray-500">
                        <?php if($doc->submitted_at): ?>
                            <?php echo e($doc->submitted_at->format('d M Y')); ?>

                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-500"><?php echo e($doc->updated_at->diffForHumans()); ?></td>
                    <td class="px-4 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="<?php echo e(route('hr.kpi.show', $doc->id)); ?>" class="text-blue-600 hover:underline text-sm" title="Lihat Detail">Detail</a>
                            <a href="<?php echo e(route('hr.kpi.edit', $doc->id)); ?>" class="text-yellow-600 hover:underline text-sm" title="Edit">Edit</a>
                            <button type="button"
                                class="text-red-600 hover:underline text-sm"
                                data-delete-url="<?php echo e(route('hr.kpi.destroy', $doc->id)); ?>"
                                data-delete-desc="Dokumen KPI milik <?php echo e($doc->user->name); ?> (<?php echo e($doc->period_year); ?>) akan dihapus permanen.">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" class="px-4 py-8 text-center text-gray-400">
                        Tidak ada dokumen KPI ditemukan
                        <?php if(request()->anyFilled(['search','status','role','year'])): ?>
                        <br><a href="<?php echo e(route('hr.kpi.index')); ?>" class="text-red-700 hover:underline text-sm mt-2 inline-block">Reset Filter</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($documents->hasPages()): ?>
    <div class="px-6 py-4 border-t border-gray-200 bg-white flex justify-between items-center">
        <small class="text-gray-500">Menampilkan <?php echo e($documents->firstItem()); ?>–<?php echo e($documents->lastItem()); ?> dari <?php echo e($documents->total()); ?> dokumen</small>
        <?php echo e($documents->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/hr/index.blade.php ENDPATH**/ ?>