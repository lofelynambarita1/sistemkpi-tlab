<?php $__env->startSection('title', 'Detail KPI ' . $kpiDocument->period_year); ?>

<?php $__env->startPush('styles'); ?>
<style>
.subform-view-table th { background:#f1f5f9; font-size:.8rem; font-weight:600; text-transform:uppercase; letter-spacing:.3px; color:#64748b; }
.subform-view-table td { vertical-align:middle; font-size:.9rem; }
.calc-cell { background:#eff6ff; color:#2563eb; font-weight:600; }
.section-tab-btn { border-radius:8px; font-weight:500; font-size:.88rem; }
.section-tab-btn.active { background:#2563eb; color:#fff; border-color:#2563eb; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row mt-4 mb-3 align-items-center flex-wrap gap-2">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-file-earmark-text text-primary me-2"></i>
            Detail KPI — <?php echo e($kpiDocument->user->name); ?> (<?php echo e($kpiDocument->period_year); ?>)
        </h4>
        <small class="text-muted">
            <?php echo e($kpiDocument->user->role_label); ?> &nbsp;·&nbsp;
            Dibuat: <?php echo e($kpiDocument->created_at->format('d M Y')); ?>

            <?php if($kpiDocument->submitted_at): ?>
                &nbsp;·&nbsp; Disubmit: <?php echo e($kpiDocument->submitted_at->format('d M Y H:i')); ?>

            <?php endif; ?>
        </small>
    </div>
    <div class="col-auto d-flex gap-2 flex-wrap">
        <?php if(auth()->user()->isStaff()): ?>
            <a href="<?php echo e(route('kpi.index')); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
            <?php if($kpiDocument->status === 'draft'): ?>
                <a href="<?php echo e(route('kpi.edit', $kpiDocument->id)); ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
            <?php endif; ?>
        <?php else: ?>
            <a href="<?php echo e(route('hr.kpi.index')); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
            <a href="<?php echo e(route('hr.kpi.edit', $kpiDocument->id)); ?>" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil me-1"></i>Edit/Review
            </a>
            <button class="btn btn-danger btn-sm"
                    data-delete-url="<?php echo e(route('hr.kpi.destroy', $kpiDocument->id)); ?>"
                    data-delete-desc="Dokumen KPI milik <?php echo e($kpiDocument->user->name); ?> (<?php echo e($kpiDocument->period_year); ?>) akan dihapus permanen.">
                <i class="bi bi-trash3 me-1"></i>Hapus
            </button>
        <?php endif; ?>
        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-printer me-1"></i>Cetak
        </button>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                <div class="mb-2">
                    <span class="status-badge <?php echo e($kpiDocument->status_badge_class); ?> fs-6 px-3 py-2">
                        <?php echo e($kpiDocument->status_label); ?>

                    </span>
                </div>
                <small class="text-muted">Status Dokumen</small>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-body">
                <div class="row g-2 text-center">
                    <?php
                        $jdTotal  = $kpiDocument->jobdescs->sum('total_mandays_penugasan');
                        $ciTotal  = $kpiDocument->continuesImprovements->sum('point');
                        $sdTotal  = $kpiDocument->selfDevelopments->sum('point');
                        $hrTotal  = $kpiDocument->hrActivities->sum('point');
                        $pkTotal  = $kpiDocument->kinerjaPerilakus->sum('score');
                    ?>
                    <div class="col border-end">
                        <div class="text-muted small">Jobdesc</div>
                        <div class="fw-bold text-primary fs-5"><?php echo e(number_format($jdTotal, 2)); ?></div>
                    </div>
                    <div class="col border-end">
                        <div class="text-muted small">Cont. Improvement</div>
                        <div class="fw-bold text-success fs-5"><?php echo e(number_format($ciTotal, 2)); ?></div>
                    </div>
                    <div class="col border-end">
                        <div class="text-muted small">Self Development</div>
                        <div class="fw-bold text-warning fs-5"><?php echo e(number_format($sdTotal, 2)); ?></div>
                    </div>
                    <div class="col border-end">
                        <div class="text-muted small">HR Activity</div>
                        <div class="fw-bold" style="color:#7c3aed; font-size:1.25rem;"><?php echo e(number_format($hrTotal, 2)); ?></div>
                    </div>
                    <div class="col border-end">
                        <div class="text-muted small">Kinerja Perilaku</div>
                        <div class="fw-bold text-info fs-5"><?php echo e(number_format($pkTotal, 2)); ?></div>
                    </div>
                    <div class="col">
                        <div class="text-muted small fw-semibold">TOTAL SCORE</div>
                        <div class="fw-bold text-dark" style="font-size:1.5rem;"><?php echo e(number_format($kpiDocument->total_score, 2)); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<ul class="nav nav-tabs kpi-tabs mb-0" style="border-bottom:none;">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#view-jobdesc">Jobdesc</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#view-ci">Continues Improvement</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#view-sd">Self Development</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#view-hr">HR Activity</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#view-perilaku">Kinerja Perilaku</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#view-history">
        <i class="bi bi-clock-history me-1"></i>History
        <span class="badge bg-secondary ms-1"><?php echo e($kpiDocument->histories->count()); ?></span>
    </a></li>
</ul>

<div class="tab-content card border-top-0 rounded-0 rounded-bottom">
    <div class="card-body">

        
        <div class="tab-pane fade show active" id="view-jobdesc">
            <div class="section-header"><i class="bi bi-briefcase"></i> Jobdesc</div>
            <?php if($kpiDocument->jobdescs->isEmpty()): ?>
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data Jobdesc</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Penilaian Koef. On Time & On Budget</th>
                            <th>Penilaian Grade Project</th>
                            <th>Nama Kegiatan dan Bukti</th>
                            <th>Mandays Proyek</th>
                            <th class="calc-cell">Jumlah Koefisien (OTB+Grade)</th>
                            <th class="calc-cell">Total Mandays Penugasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $kpiDocument->jobdescs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $jd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i+1); ?></td>
                            <td><?php echo e(number_format($jd->penilaian_koefisien_ontime_onbudget, 2)); ?></td>
                            <td><?php echo e(number_format($jd->penilaian_grade_project, 2)); ?></td>
                            <td><?php echo e($jd->nama_kegiatan_bukti ?: '—'); ?></td>
                            <td><?php echo e(number_format($jd->mandays_proyek, 2)); ?></td>
                            <td class="calc-cell"><?php echo e(number_format($jd->jumlah_koefisien, 2)); ?></td>
                            <td class="calc-cell"><?php echo e(number_format($jd->total_mandays_penugasan, 2)); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="table-primary">
                        <tr>
                            <td colspan="6" class="text-end fw-bold">Total Mandays Penugasan:</td>
                            <td class="fw-bold"><?php echo e(number_format($jdTotal, 2)); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="tab-pane fade" id="view-ci">
            <div class="section-header"><i class="bi bi-arrow-repeat"></i> Continues Improvement</div>
            <?php if($kpiDocument->continuesImprovements->isEmpty()): ?>
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data Continues Improvement</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr><th>#</th><th>Jenis Kegiatan / Bukti</th><th>Kegiatan</th><th>Mandays</th><th class="calc-cell">Koefisien</th><th class="calc-cell">Point</th></tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $kpiDocument->continuesImprovements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ci): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i+1); ?></td>
                            <td><span class="badge bg-success-subtle text-success"><?php echo e($ci->jenis_kegiatan_bukti); ?></span></td>
                            <td><?php echo e($ci->kegiatan); ?></td>
                            <td><?php echo e(number_format($ci->mandays, 2)); ?></td>
                            <td class="calc-cell"><?php echo e(number_format($ci->koefisien, 4)); ?></td>
                            <td class="calc-cell"><?php echo e(number_format($ci->point, 4)); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="table-success">
                        <tr><td colspan="5" class="text-end fw-bold">Total Point:</td><td class="fw-bold"><?php echo e(number_format($ciTotal, 4)); ?></td></tr>
                    </tfoot>
                </table>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="tab-pane fade" id="view-sd">
            <div class="section-header"><i class="bi bi-person-check"></i> Self Development</div>
            <?php if($kpiDocument->selfDevelopments->isEmpty()): ?>
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data Self Development</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr><th>#</th><th>Jenis SD</th><th>Kegiatan</th><th>Mandays</th><th class="calc-cell">Koefisien</th><th class="calc-cell">Point</th></tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $kpiDocument->selfDevelopments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i+1); ?></td>
                            <td><span class="badge bg-warning-subtle text-warning"><?php echo e($sd->jenis_sd); ?></span></td>
                            <td><?php echo e($sd->kegiatan); ?></td>
                            <td><?php echo e(number_format($sd->mandays, 2)); ?></td>
                            <td class="calc-cell"><?php echo e(number_format($sd->koefisien, 4)); ?></td>
                            <td class="calc-cell"><?php echo e(number_format($sd->point, 4)); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="table-warning">
                        <tr><td colspan="5" class="text-end fw-bold">Total Point:</td><td class="fw-bold"><?php echo e(number_format($sdTotal, 4)); ?></td></tr>
                    </tfoot>
                </table>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="tab-pane fade" id="view-hr">
            <div class="section-header"><i class="bi bi-people"></i> HR Activity</div>
            <?php if($kpiDocument->hrActivities->isEmpty()): ?>
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data HR Activity</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr><th>#</th><th>Jenis Kegiatan</th><th>Kegiatan</th><th>Mandays</th><th class="calc-cell">Koefisien</th><th class="calc-cell">Point</th></tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $kpiDocument->hrActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $hr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i+1); ?></td>
                            <td><span class="badge" style="background:#ede9fe;color:#7c3aed;"><?php echo e($hr->jenis_kegiatan); ?></span></td>
                            <td><?php echo e($hr->kegiatan); ?></td>
                            <td><?php echo e(number_format($hr->mandays, 2)); ?></td>
                            <td class="calc-cell"><?php echo e(number_format($hr->koefisien, 4)); ?></td>
                            <td class="calc-cell"><?php echo e(number_format($hr->point, 4)); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot style="background:#ede9fe;">
                        <tr><td colspan="5" class="text-end fw-bold">Total Point:</td><td class="fw-bold"><?php echo e(number_format($hrTotal, 4)); ?></td></tr>
                    </tfoot>
                </table>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="tab-pane fade" id="view-perilaku">
            <div class="section-header"><i class="bi bi-star-half"></i> Kinerja Perilaku</div>
            <?php if($kpiDocument->kinerjaPerilakus->isEmpty()): ?>
                <p class="text-muted text-center py-3"><i class="bi bi-inbox me-2"></i>Belum ada data Kinerja Perilaku</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table subform-view-table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Aspek Kinerja</th>
                            <th>Definisi</th>
                            <th class="text-center">Min. Capaian</th>
                            <th>Indikator</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Score</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $kpiDocument->kinerjaPerilakus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $kp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i+1); ?></td>
                            <td><strong><?php echo e($kp->aspek_kinerja); ?></strong></td>
                            <td><small><?php echo e($kp->definisi); ?></small></td>
                            <td class="text-center"><span class="badge bg-warning text-dark">≥ <?php echo e($kp->minimum_capaian); ?></span></td>
                            <td><small><?php echo e($kp->indikator); ?></small></td>
                            <td><small><?php echo e($kp->deskripsi); ?></small></td>
                            <td class="text-center">
                                <span class="fw-bold fs-5 <?php echo e($kp->score >= $kp->minimum_capaian ? 'text-success' : 'text-danger'); ?>">
                                    <?php echo e(number_format($kp->score, 2)); ?>

                                </span>
                            </td>
                            <td class="text-center">
                                <?php if($kp->score >= $kp->minimum_capaian): ?>
                                    <span class="badge bg-success"><i class="bi bi-check-lg me-1"></i>Tercapai</span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><i class="bi bi-x-lg me-1"></i>Belum Tercapai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="table-info">
                        <tr>
                            <td colspan="6" class="text-end fw-bold">Total Score Kinerja Perilaku:</td>
                            <td class="text-center fw-bold fs-5"><?php echo e(number_format($pkTotal, 2)); ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="tab-pane fade" id="view-history">
            <div class="section-header"><i class="bi bi-clock-history"></i> Riwayat Perubahan</div>
            <?php if($kpiDocument->histories->isEmpty()): ?>
                <p class="text-muted text-center py-3"><i class="bi bi-clock me-2"></i>Belum ada riwayat perubahan</p>
            <?php else: ?>
                <?php $__currentLoopData = $kpiDocument->histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="history-item">
                    <div class="history-dot <?php echo e(match($hist->action) { 'create' => 'bg-success', 'update' => 'bg-warning', 'delete' => 'bg-danger', 'submit' => 'bg-primary', default => 'bg-secondary' }); ?>"></div>
                    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-1">
                        <div>
                            <span class="badge <?php echo e($hist->action_badge_class); ?> me-1"><?php echo e($hist->action_label); ?></span>
                            <?php if($hist->section): ?>
                                <span class="badge bg-light text-dark border me-1"><?php echo e($hist->section_label); ?></span>
                            <?php endif; ?>
                            <span class="text-dark small"><?php echo e($hist->description); ?></span>
                        </div>
                        <small class="text-muted"><?php echo e($hist->created_at->format('d M Y H:i')); ?></small>
                    </div>
                    <small class="text-muted">
                        <i class="bi bi-person-circle me-1"></i>
                        Oleh: <strong><?php echo e($hist->changedBy->name); ?></strong> (<?php echo e($hist->changedBy->role_label); ?>)
                    </small>
                    <?php if($hist->old_data && $hist->action === 'update'): ?>
                        <div class="mt-1">
                            <a class="btn btn-xs btn-outline-secondary btn-sm py-0 px-2" data-bs-toggle="collapse"
                               href="#histDetail<?php echo e($hist->id); ?>">
                                <i class="bi bi-code-slash me-1"></i>Detail Perubahan
                            </a>
                            <div class="collapse mt-2" id="histDetail<?php echo e($hist->id); ?>">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <small class="text-muted fw-semibold d-block mb-1">Data Sebelum:</small>
                                        <pre class="bg-light rounded p-2" style="font-size:.75rem; max-height:150px; overflow:auto;"><?php echo e(json_encode($hist->old_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted fw-semibold d-block mb-1">Data Sesudah:</small>
                                        <pre class="bg-light rounded p-2" style="font-size:.75rem; max-height:150px; overflow:auto;"><?php echo e(json_encode($hist->new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php if($kpiDocument->notes): ?>
<div class="alert alert-light border mt-3">
    <i class="bi bi-chat-text me-2"></i><strong>Catatan:</strong> <?php echo e($kpiDocument->notes); ?>

</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\kpi-system\resources\views/kpi/show.blade.php ENDPATH**/ ?>