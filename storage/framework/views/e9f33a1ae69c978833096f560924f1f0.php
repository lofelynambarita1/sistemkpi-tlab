<?php $__env->startSection('title', 'Kelola Dokumen KPI Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mt-4 mb-3 align-items-center">
    <div class="col">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-collection text-primary me-2"></i>Kelola Dokumen KPI Staff
        </h4>
        <small class="text-muted"><?php echo e(auth()->user()->name); ?> · <?php echo e(auth()->user()->role_label); ?></small>
    </div>
</div>


<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="<?php echo e(route('hr.kpi.index')); ?>" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold mb-1">Cari Nama Staff</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Nama staff..."
                           value="<?php echo e(request('search')); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="draft"     <?php echo e(request('status')=='draft'     ? 'selected':''); ?>>Draft</option>
                    <option value="submitted" <?php echo e(request('status')=='submitted' ? 'selected':''); ?>>Disubmit</option>
                    <option value="reviewed"  <?php echo e(request('status')=='reviewed'  ? 'selected':''); ?>>Ditinjau</option>
                    <option value="approved"  <?php echo e(request('status')=='approved'  ? 'selected':''); ?>>Disetujui</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Role</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="">Semua Role</option>
                    <option value="associate"   <?php echo e(request('role')=='associate'   ? 'selected':''); ?>>Associate</option>
                    <option value="intermediate"<?php echo e(request('role')=='intermediate'? 'selected':''); ?>>Intermediate</option>
                    <option value="senior"      <?php echo e(request('role')=='senior'      ? 'selected':''); ?>>Senior</option>
                    <option value="lead"        <?php echo e(request('role')=='lead'        ? 'selected':''); ?>>Lead</option>
                    <option value="principle"   <?php echo e(request('role')=='principle'   ? 'selected':''); ?>>Principle</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold mb-1">Tahun</label>
                <select name="year" class="form-select form-select-sm">
                    <option value="">Semua Tahun</option>
                    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($y); ?>" <?php echo e(request('year')==$y ? 'selected':''); ?>><?php echo e($y); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="<?php echo e(route('hr.kpi.index')); ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>


<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span class="fw-semibold">
            <i class="bi bi-table text-primary me-2"></i>
            Daftar Dokumen KPI
            <span class="badge bg-secondary ms-2"><?php echo e($documents->total()); ?> dokumen</span>
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-kpi table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Staff</th>
                        <th>Role</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Total Score</th>
                        <th>Disubmit</th>
                        <th>Diperbarui</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e(($documents->currentPage()-1)*$documents->perPage() + $loop->iteration); ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#0891b2);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;flex-shrink:0;">
                                    <?php echo e(strtoupper(substr($doc->user->name,0,2))); ?>

                                </div>
                                <span class="fw-semibold"><?php echo e($doc->user->name); ?></span>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border"><?php echo e($doc->user->role_label); ?></span></td>
                        <td><strong><?php echo e($doc->period_year); ?></strong></td>
                        <td>
                            <span class="status-badge <?php echo e($doc->status_badge_class); ?>">
                                <?php echo e($doc->status_label); ?>

                            </span>
                        </td>
                        <td>
                            <span class="fw-semibold text-primary"><?php echo e(number_format($doc->total_score, 2)); ?></span>
                        </td>
                        <td>
                            <?php if($doc->submitted_at): ?>
                                <small class="text-muted"><?php echo e($doc->submitted_at->format('d M Y')); ?></small>
                            <?php else: ?>
                                <small class="text-muted">—</small>
                            <?php endif; ?>
                        </td>
                        <td><small class="text-muted"><?php echo e($doc->updated_at->diffForHumans()); ?></small></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1 flex-nowrap">
                                <a href="<?php echo e(route('hr.kpi.show', $doc->id)); ?>"
                                   class="btn btn-sm btn-outline-info btn-action" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('hr.kpi.edit', $doc->id)); ?>"
                                   class="btn btn-sm btn-outline-warning btn-action" title="Edit / Review">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger btn-action"
                                        data-delete-url="<?php echo e(route('hr.kpi.destroy', $doc->id)); ?>"
                                        data-delete-desc="Dokumen KPI milik <?php echo e($doc->user->name); ?> (<?php echo e($doc->period_year); ?>) akan dihapus permanen."
                                        title="Hapus">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            <i class="bi bi-inbox" style="font-size:2.5rem;"></i>
                            <p class="mt-2 mb-0">Tidak ada dokumen KPI ditemukan</p>
                            <?php if(request()->anyFilled(['search','status','role','year'])): ?>
                                <a href="<?php echo e(route('hr.kpi.index')); ?>" class="btn btn-sm btn-outline-secondary mt-2">
                                    Reset Filter
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($documents->hasPages()): ?>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menampilkan <?php echo e($documents->firstItem()); ?>–<?php echo e($documents->lastItem()); ?> dari <?php echo e($documents->total()); ?> dokumen
            </small>
            <?php echo e($documents->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\kpi-system\resources\views/hr/index.blade.php ENDPATH**/ ?>