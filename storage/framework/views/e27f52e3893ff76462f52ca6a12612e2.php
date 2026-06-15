

<?php $__env->startSection('title', 'Dashboard Karyawan'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-speedometer2 text-primary me-2"></i>Dashboard KPI
        </h4>
        <small class="text-muted">Selamat datang, <?php echo e($user->name); ?> · <?php echo e($user->role_label); ?></small>
    </div>
    <div class="col-auto">
        <a href="<?php echo e(route('kpi.create')); ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>Buat Dokumen KPI
        </a>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#2563eb,#3b82f6);">
            <i class="bi bi-files stat-icon"></i>
            <div class="stat-value"><?php echo e($totalKpi); ?></div>
            <div class="stat-label">Total Dokumen KPI</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#16a34a,#22c55e);">
            <i class="bi bi-check-circle-fill stat-icon"></i>
            <div class="stat-value"><?php echo e($approved); ?></div>
            <div class="stat-label">Disetujui</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#f59e0b,#fbbf24);">
            <i class="bi bi-hourglass-split stat-icon"></i>
            <div class="stat-value"><?php echo e($submitted); ?></div>
            <div class="stat-label">Menunggu Review</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#dc2626,#f87171);">
            <i class="bi bi-arrow-counterclockwise stat-icon"></i>
            <div class="stat-value"><?php echo e($needRevision); ?></div>
            <div class="stat-label">Perlu Revisi</div>
        </div>
    </div>
</div>

<div class="row g-3">
    
    <?php if($latestKpi): ?>
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header fw-semibold">
                <i class="bi bi-file-earmark-text text-primary me-2"></i>Dokumen KPI Terbaru
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="fw-bold">KPI <?php echo e($latestKpi->period_year); ?></div>
                        <small class="text-muted">Dibuat <?php echo e($latestKpi->created_at->diffForHumans()); ?></small>
                    </div>
                    <span class="status-badge <?php echo e($latestKpi->status_badge_class); ?>"><?php echo e($latestKpi->status_label); ?></span>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('kpi.show', $latestKpi->id)); ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye me-1"></i>Lihat
                    </a>
                    <?php if(in_array($latestKpi->status, ['draft', 'need_revision'])): ?>
                    <a href="<?php echo e(route('kpi.edit', $latestKpi->id)); ?>" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <?php endif; ?>
                </div>

                <?php if($draft > 0): ?>
                <div class="alert alert-warning mt-3 mb-0 py-2 small">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Kamu punya <strong><?php echo e($draft); ?></strong> dokumen draft yang belum disubmit.
                </div>
                <?php endif; ?>
                <?php if($needRevision > 0): ?>
                <div class="alert alert-danger mt-3 mb-0 py-2 small">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    <strong><?php echo e($needRevision); ?></strong> dokumen perlu direvisi.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="col-lg-<?php echo e($latestKpi ? '7' : '12'); ?>">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fw-semibold"><i class="bi bi-clock-history text-primary me-2"></i>Semua Dokumen KPI</span>
                <a href="<?php echo e(route('kpi.index')); ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $myKpis->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex align-items-center px-3 py-3 border-bottom">
                        <div class="flex-grow-1">
                            <div class="fw-semibold small">KPI <?php echo e($doc->period_year); ?></div>
                            <div class="text-muted" style="font-size:.8rem;">
                                Diperbarui <?php echo e($doc->updated_at->diffForHumans()); ?>

                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="status-badge <?php echo e($doc->status_badge_class); ?>"><?php echo e($doc->status_label); ?></span>
                            <a href="<?php echo e(route('kpi.show', $doc->id)); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-file-earmark-x" style="font-size:2.5rem;"></i>
                        <p class="mt-2 mb-0">Belum ada dokumen KPI</p>
                        <a href="<?php echo e(route('kpi.create')); ?>" class="btn btn-primary btn-sm mt-3">
                            <i class="bi bi-plus-lg me-1"></i>Buat Sekarang
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\kpi-system\resources\views/dashboard/employee.blade.php ENDPATH**/ ?>