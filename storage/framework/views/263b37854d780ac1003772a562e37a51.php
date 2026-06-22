<?php $__env->startSection('title', 'Dashboard HR/Manager'); ?>
<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li class="text-gray-700 font-semibold">Dashboard</li>
    </ol>
</nav>

<header class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard <?php echo e($user->role_label); ?></h1>
    <p class="text-gray-600">Kelola &amp; Review Dokumen KPI Staff &middot; Periode <?php echo e($year); ?></p>
    <p class="text-sm text-gray-500 mt-1">Login sebagai: <strong><?php echo e($user->name); ?></strong> (<?php echo e($user->role_label); ?>)</p>
</header>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total Staff</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($stats['total_staff']); ?></p>
        <p class="text-sm text-gray-400">Seluruh staff</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-gray-500">
        <p class="text-sm text-gray-500">Total Dokumen</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($stats['total_documents']); ?></p>
        <p class="text-sm text-gray-400">Semua dokumen KPI</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Menunggu Review</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($stats['submitted']); ?></p>
        <p class="text-sm text-gray-400">Perlu ditinjau</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-cyan-500">
        <p class="text-sm text-gray-500">Sudah Ditinjau</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($stats['reviewed']); ?></p>
        <p class="text-sm text-gray-400">Telah direview</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Disetujui</p>
        <p class="text-3xl font-bold text-gray-800 mt-1"><?php echo e($stats['approved']); ?></p>
        <p class="text-sm text-gray-400">Final approved</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Dokumen KPI Staff</h3>
        <a href="<?php echo e(route('hr.kpi.index')); ?>" class="btn-secondary">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Score</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diperbarui</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-red-700 text-white flex items-center justify-center text-xs font-bold flex-shrink-0">
                                <?php echo e(strtoupper(substr($doc->user->name, 0, 2))); ?>

                            </div>
                            <?php echo e($doc->user->name); ?>

                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm"><span class="badge badge-diproses"><?php echo e($doc->user->role_label); ?></span></td>
                    <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($doc->period_year); ?></td>
                    <td class="px-4 py-3 text-sm"><span class="badge badge-<?php echo e($doc->status); ?>"><?php echo e($doc->status_label); ?></span></td>
                    <td class="px-4 py-3 text-sm font-semibold text-red-700"><?php echo e(number_format($doc->total_score, 2)); ?></td>
                    <td class="px-4 py-3 text-sm text-gray-500"><?php echo e($doc->updated_at->diffForHumans()); ?></td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex gap-1">
                            <a href="<?php echo e(route('hr.kpi.show', $doc->id)); ?>" class="btn-secondary text-xs" style="padding:0.25rem 0.5rem;" title="Lihat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="<?php echo e(route('hr.kpi.edit', $doc->id)); ?>" class="btn-secondary text-xs" style="padding:0.25rem 0.5rem;" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <button class="btn-secondary text-xs" style="padding:0.25rem 0.5rem;color:#dc2626;" data-delete-url="<?php echo e(route('hr.kpi.destroy', $doc->id)); ?>" data-delete-desc="Dokumen KPI milik <?php echo e($doc->user->name); ?> (<?php echo e($doc->period_year); ?>) akan dihapus." title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        <p>Belum ada dokumen KPI yang disubmit</p>
                    </td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($documents->hasPages()): ?>
    <div class="mt-4 border-t border-gray-200 pt-4">
        <?php echo e($documents->links()); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/dashboard/hr_manager.blade.php ENDPATH**/ ?>