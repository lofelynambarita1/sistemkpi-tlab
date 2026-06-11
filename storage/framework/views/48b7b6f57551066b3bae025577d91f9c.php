<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Sistem KPI'); ?> — PT XYZ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?php echo e(route('dashboard')); ?>">
            <i class="bi bi-graph-up-arrow me-2"></i>Sistem KPI
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>"
                       href="<?php echo e(route('dashboard')); ?>">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                </li>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isStaff()): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('kpi.*') ? 'active' : ''); ?>"
                               href="<?php echo e(route('kpi.index')); ?>">
                                <i class="bi bi-file-earmark-text me-1"></i>Dokumen KPI Saya
                            </a>
                        </li>
                    <?php elseif(auth()->user()->isHROrManager()): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('hr.kpi.*') ? 'active' : ''); ?>"
                               href="<?php echo e(route('hr.kpi.index')); ?>">
                                <i class="bi bi-collection me-1"></i>Kelola Dokumen KPI
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                <?php if(auth()->guard()->check()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                           data-bs-toggle="dropdown">
                            <div class="avatar-circle">
                                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?>

                            </div>
                            <span class="d-none d-md-inline"><?php echo e(auth()->user()->name); ?></span>
                            <span class="badge bg-light text-primary small"><?php echo e(auth()->user()->role_label); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <div class="dropdown-header">
                                    <strong><?php echo e(auth()->user()->name); ?></strong><br>
                                    <small class="text-muted"><?php echo e(auth()->user()->email); ?></small>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<div class="container-fluid px-4 mt-3">
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('info')): ?>
        <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i><?php echo e(session('info')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
</div>


<main class="container-fluid px-4 pb-5">
    <?php echo $__env->yieldContent('content'); ?>
</main>


<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title">
                    <i class="bi bi-trash3-fill me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <div class="text-center mb-3">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size:3rem;"></i>
                </div>
                <p class="text-center fs-5 mb-1">Apakah Anda yakin ingin menghapus?</p>
                <p class="text-center text-muted small" id="deleteModalDescription"></p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Batal
                </button>
                <form id="deleteConfirmForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3 me-1"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Global delete confirmation handler
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-delete-url]').forEach(btn => {
        btn.addEventListener('click', function () {
            const url  = this.dataset.deleteUrl;
            const desc = this.dataset.deleteDesc || 'Data ini akan dihapus secara permanen.';
            document.getElementById('deleteConfirmForm').action = url;
            document.getElementById('deleteModalDescription').textContent = desc;
            new bootstrap.Modal(document.getElementById('deleteConfirmModal')).show();
        });
    });
});
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\New folder (20)\kpi-system\resources\views/layouts/app.blade.php ENDPATH**/ ?>