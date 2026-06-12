<?php $__env->startSection('title', 'Dashboard — KPI ' . $year); ?>

<?php $__env->startSection('content'); ?>
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-speedometer2 text-primary me-2"></i>Dashboard KPI
        </h4>
        <small class="text-muted">Periode <?php echo e($year); ?> · <?php echo e($user->role_label); ?> · <?php echo e($user->name); ?></small>
    </div>
    <div class="col-auto">
        <a href="<?php echo e(route('kpi.create')); ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>Buat Dokumen KPI
        </a>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#2563eb,#3b82f6);">
            <i class="bi bi-bullseye stat-icon"></i>
            <div class="stat-value"><?php echo e(number_format($target->target_total, 0)); ?></div>
            <div class="stat-label">Total Target Tahunan</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#16a34a,#22c55e);">
            <i class="bi bi-check2-circle stat-icon"></i>
            <div class="stat-value"><?php echo e(number_format($target->capaian_total, 0)); ?></div>
            <div class="stat-label">Total Capaian</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#ca8a04,#fbbf24);">
            <i class="bi bi-percent stat-icon"></i>
            <div class="stat-value"><?php echo e($target->persentase_total); ?>%</div>
            <div class="stat-label">Persentase Capaian</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#0891b2,#22d3ee);">
            <i class="bi bi-file-earmark-text stat-icon"></i>
            <div class="stat-value"><?php echo e($recentDocs->count()); ?></div>
            <div class="stat-label">Dokumen KPI</div>
        </div>
    </div>
</div>

<div class="row g-3">
    
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fw-semibold"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Target Capaian Tahunan <?php echo e($year); ?></span>
                <span class="badge bg-primary-subtle text-primary"><?php echo e($user->role_label); ?></span>
            </div>
            <div class="card-body">
                <?php
                    $items = [
                        ['label' => 'Jobdesc',              'color' => '#2563eb', 'pct' => $target->persentase_jobdesc,  'capaian' => $target->capaian_jobdesc,               'target' => $target->target_jobdesc,               'icon' => 'bi-briefcase'],
                        ['label' => 'Continues Improvement','color' => '#16a34a', 'pct' => $target->persentase_ci,       'capaian' => $target->capaian_continues_improvement, 'target' => $target->target_continues_improvement, 'icon' => 'bi-arrow-repeat'],
                        ['label' => 'Self Development',     'color' => '#ca8a04', 'pct' => $target->persentase_sd,       'capaian' => $target->capaian_self_development,      'target' => $target->target_self_development,      'icon' => 'bi-person-check'],
                        ['label' => 'HR Activity',          'color' => '#7c3aed', 'pct' => $target->persentase_hr,       'capaian' => $target->capaian_hr_activity,           'target' => $target->target_hr_activity,           'icon' => 'bi-people'],
                        ['label' => 'Kinerja Perilaku',     'color' => '#0891b2', 'pct' => $target->persentase_perilaku, 'capaian' => $target->capaian_kinerja_perilaku,      'target' => $target->target_kinerja_perilaku,      'icon' => 'bi-star'],
                    ];
                ?>

                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="target-item">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="target-label">
                                <i class="bi <?php echo e($item['icon']); ?> me-1" style="color:<?php echo e($item['color']); ?>"></i>
                                <?php echo e($item['label']); ?>

                            </span>
                            <span class="target-pct" style="color:<?php echo e($item['color']); ?>"><?php echo e($item['pct']); ?>%</span>
                        </div>
                        <div class="progress-kpi">
                            <div class="progress-bar"
                                 style="width:<?php echo e($item['pct']); ?>%; background:<?php echo e($item['color']); ?>;"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Capaian: <strong><?php echo e(number_format($item['capaian'], 1)); ?></strong></small>
                            <small class="text-muted">Target: <strong><?php echo e(number_format($item['target'], 1)); ?></strong></small>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fw-semibold"><i class="bi bi-clock-history text-primary me-2"></i>Dokumen KPI Terbaru</span>
                <a href="<?php echo e(route('kpi.index')); ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $recentDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\kpi-system\resources\views/dashboard/staff.blade.php ENDPATH**/ ?>