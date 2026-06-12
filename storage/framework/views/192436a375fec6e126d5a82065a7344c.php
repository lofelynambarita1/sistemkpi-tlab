<?php $__env->startSection('title', 'Dokumen KPI Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0"><i class="bi bi-file-earmark-text text-primary me-2"></i>Dokumen KPI Saya</h4>
        <small class="text-muted"><?php echo e($user->name); ?> · <?php echo e($user->role_label); ?></small>
    </div>
    <div class="col-auto">
        <a href="<?php echo e(route('kpi.create')); ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>Buat KPI Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-kpi table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Total Score</th>
                        <th>Dibuat</th>
                        <th>Disubmit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><strong><?php echo e($doc->period_year); ?></strong></td>
                            <td><span class="status-badge <?php echo e($doc->status_badge_class); ?>"><?php echo e($doc->status_label); ?></span></td>
                            <td class="fw-semibold text-primary"><?php echo e(number_format($doc->total_score, 2)); ?></td>
                            <td><small class="text-muted"><?php echo e($doc->created_at->format('d M Y')); ?></small></td>
                            <td>
                                <?php if($doc->submitted_at): ?>
                                    <small class="text-muted"><?php echo e($doc->submitted_at->format('d M Y')); ?></small>
                                <?php else: ?>
                                    <small class="text-muted">—</small>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="<?php echo e(route('kpi.show', $doc->id)); ?>"
                                       class="btn btn-sm btn-outline-info btn-action" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if($doc->status === 'draft'): ?>
                                        <a href="<?php echo e(route('kpi.edit', $doc->id)); ?>"
                                           class="btn btn-sm btn-outline-warning btn-action" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-file-earmark-x" style="font-size:2.5rem;"></i>
                                <p class="mt-2">Belum ada dokumen KPI</p>
                                <a href="<?php echo e(route('kpi.create')); ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-lg me-1"></i>Buat Sekarang
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\kpi-system\resources\views/kpi/index.blade.php ENDPATH**/ ?>