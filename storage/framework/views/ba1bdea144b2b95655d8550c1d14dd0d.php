<?php $__env->startSection('title', 'Dashboard HR/Manager'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-speedometer2 text-primary me-2"></i>Dashboard <?php echo e($user->role_label); ?>

        </h4>
        <small class="text-muted">Kelola & Review Dokumen KPI Staff · Periode <?php echo e($year); ?></small>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-6 col-xl-2-4">
        <div class="stat-card" style="background: linear-gradient(135deg,#2563eb,#3b82f6);">
            <i class="bi bi-people stat-icon"></i>
            <div class="stat-value"><?php echo e($stats['total_staff']); ?></div>
            <div class="stat-label">Total Staff</div>
        </div>
    </div>
    <div class="col-6 col-xl-2-4">
        <div class="stat-card" style="background: linear-gradient(135deg,#475569,#64748b);">
            <i class="bi bi-files stat-icon"></i>
            <div class="stat-value"><?php echo e($stats['total_documents']); ?></div>
            <div class="stat-label">Total Dokumen</div>
        </div>
    </div>
    <div class="col-6 col-xl-2-4">
        <div class="stat-card" style="background: linear-gradient(135deg,#f59e0b,#fbbf24);">
            <i class="bi bi-hourglass-split stat-icon"></i>
            <div class="stat-value"><?php echo e($stats['submitted']); ?></div>
            <div class="stat-label">Menunggu Review</div>
        </div>
    </div>
    <div class="col-6 col-xl-2-4">
        <div class="stat-card" style="background: linear-gradient(135deg,#0891b2,#22d3ee);">
            <i class="bi bi-eye-fill stat-icon"></i>
            <div class="stat-value"><?php echo e($stats['reviewed']); ?></div>
            <div class="stat-label">Sudah Ditinjau</div>
        </div>
    </div>
    <div class="col-6 col-xl-2-4">
        <div class="stat-card" style="background: linear-gradient(135deg,#16a34a,#22c55e);">
            <i class="bi bi-check-circle-fill stat-icon"></i>
            <div class="stat-value"><?php echo e($stats['approved']); ?></div>
            <div class="stat-label">Disetujui</div>
        </div>
    </div>
</div>

<style>.col-xl-2-4 { flex: 0 0 20%; max-width: 20%; } @media(max-width:768px){.col-xl-2-4{flex:0 0 50%;max-width:50%;}}</style>


<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <span class="fw-semibold"><i class="bi bi-collection text-primary me-2"></i>Dokumen KPI Staff</span>
        <a href="<?php echo e(route('hr.kpi.index')); ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-list-ul me-1"></i>Lihat Semua
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-kpi table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Total Score</th>
                        <th>Diperbarui</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle-sm"><?php echo e(strtoupper(substr($doc->user->name, 0, 2))); ?></div>
                                    <span class="fw-semibold"><?php echo e($doc->user->name); ?></span>
                                </div>
                            </td>
                            <td><span class="badge bg-secondary"><?php echo e($doc->user->role_label); ?></span></td>
                            <td><?php echo e($doc->period_year); ?></td>
                            <td><span class="status-badge <?php echo e($doc->status_badge_class); ?>"><?php echo e($doc->status_label); ?></span></td>
                            <td class="fw-semibold text-primary"><?php echo e(number_format($doc->total_score, 2)); ?></td>
                            <td><small class="text-muted"><?php echo e($doc->updated_at->diffForHumans()); ?></small></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="<?php echo e(route('hr.kpi.show', $doc->id)); ?>"
                                       class="btn btn-sm btn-outline-info btn-action" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('hr.kpi.edit', $doc->id)); ?>"
                                       class="btn btn-sm btn-outline-warning btn-action" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger btn-action"
                                            data-delete-url="<?php echo e(route('hr.kpi.destroy', $doc->id)); ?>"
                                            data-delete-desc="Dokumen KPI milik <?php echo e($doc->user->name); ?> (<?php echo e($doc->period_year); ?>) akan dihapus."
                                            title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size:2rem;"></i>
                                <p class="mt-2 mb-0">Belum ada dokumen KPI yang disubmit</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($documents->hasPages()): ?>
        <div class="card-footer bg-white">
            <?php echo e($documents->links()); ?>

        </div>
    <?php endif; ?>
</div>

<style>
.avatar-circle-sm {
    width:30px;height:30px;border-radius:50%;
    background:linear-gradient(135deg,#2563eb,#0891b2);
    color:#fff;display:flex;align-items:center;
    justify-content:center;font-size:.7rem;font-weight:700;flex-shrink:0;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\kpi-system\resources\views/dashboard/hr_manager.blade.php ENDPATH**/ ?>