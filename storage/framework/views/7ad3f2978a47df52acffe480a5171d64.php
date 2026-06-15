

<?php $__env->startSection('title', 'Riwayat Aktivitas'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1">Riwayat Aktivitas</h4>
        <p class="text-muted small mb-0">Semua aktivitas dokumen KPI Anda</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if($histories->isEmpty()): ?>
            <div class="text-center py-5">
                <i class="bi bi-clock-history text-muted" style="font-size:3rem;"></i>
                <p class="text-muted mt-3">Belum ada riwayat aktivitas.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Dokumen KPI</th>
                            <th>Aksi</th>
                            <th>Keterangan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="ps-4">
                                <div class="fw-semibold" style="font-size:.875rem;">
                                    <?php echo e($history->kpiDocument->title ?? '-'); ?>

                                </div>
                                <small class="text-muted"><?php echo e($history->kpiDocument->code ?? ''); ?></small>
                            </td>
                            <td>
                                <?php
                                    $badges = [
                                        'created'   => 'bg-success',
                                        'updated'   => 'bg-primary',
                                        'submitted' => 'bg-warning text-dark',
                                        'approved'  => 'bg-success',
                                        'rejected'  => 'bg-danger',
                                        'revised'   => 'bg-secondary',
                                    ];
                                    $badge = $badges[$history->action] ?? 'bg-secondary';
                                ?>
                                <span class="badge <?php echo e($badge); ?>"><?php echo e(ucfirst($history->action)); ?></span>
                            </td>
                            <td>
                                <span class="text-muted small"><?php echo e($history->description ?? '-'); ?></span>
                            </td>
                            <td>
                                <span class="small text-muted">
                                    <?php echo e($history->created_at->format('d M Y, H:i')); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <?php if($histories->hasPages()): ?>
                <div class="px-4 py-3 border-top">
                    <?php echo e($histories->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\kpi-system\resources\views/kpi/history.blade.php ENDPATH**/ ?>