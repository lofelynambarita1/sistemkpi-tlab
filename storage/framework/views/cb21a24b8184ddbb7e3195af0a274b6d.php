<?php $__env->startSection('title', 'Dokumen KPI Saya'); ?>

<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="<?php echo e(route('dashboard')); ?>" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li class="text-gray-700 font-semibold">Dokumen KPI Saya</li>
    </ol>
</nav>

<header class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dokumen KPI Saya</h1>
        <p class="text-gray-600"><?php echo e($user->name); ?> · <?php echo e($user->role_label); ?></p>
    </div>
    <a href="<?php echo e(route('kpi.create')); ?>" class="btn-primary">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Buat KPI Baru
    </a>
</header>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Score</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Disubmit</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 text-sm text-gray-500"><?php echo e($loop->iteration); ?></td>
                        <td class="px-4 py-4 text-sm font-semibold text-gray-800"><?php echo e($doc->period_year); ?></td>
                        <td class="px-4 py-4">
                            <span class="badge <?php echo e($doc->status_badge_class); ?>"><?php echo e($doc->status_label); ?></span>
                        </td>
                        <td class="px-4 py-4 text-sm font-semibold text-red-700"><?php echo e(number_format($doc->total_score, 2)); ?></td>
                        <td class="px-4 py-4 text-sm text-gray-500"><?php echo e($doc->created_at->format('d M Y')); ?></td>
                        <td class="px-4 py-4 text-sm text-gray-500">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($doc->submitted_at): ?>
                                <?php echo e($doc->submitted_at->format('d M Y')); ?>

                            <?php else: ?>
                                —
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="<?php echo e(route('kpi.show', $doc->id)); ?>"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded border border-gray-300 text-gray-700 hover:bg-gray-50 transition"
                                   title="Lihat">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat
                                </a>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($doc->status === 'draft'): ?>
                                    <a href="<?php echo e(route('kpi.edit', $doc->id)); ?>"
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded border border-gray-300 text-yellow-700 hover:bg-yellow-50 transition"
                                       title="Edit">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="7" class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 mb-4">Belum ada dokumen KPI</p>
                            <a href="<?php echo e(route('kpi.create')); ?>" class="btn-primary text-sm">Buat Sekarang</a>
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/kpi/index.blade.php ENDPATH**/ ?>