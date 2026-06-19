<?php $__env->startSection('title', 'Detail KPI ' . $kpiDocument->period_year); ?>

<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="<?php echo e(route('dashboard')); ?>" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <?php if(auth()->user()->isStaff()): ?>
            <li><a href="<?php echo e(route('kpi.index')); ?>" class="text-red-700 hover:underline">KPI Saya</a></li>
        <?php else: ?>
            <li><a href="<?php echo e(route('hr.kpi.index')); ?>" class="text-red-700 hover:underline">Kelola KPI</a></li>
        <?php endif; ?>
        <li>/</li>
        <li class="text-gray-700">Detail KPI</li>
    </ol>
</nav>

<header class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Detail KPI — <?php echo e($kpiDocument->user->name); ?></h1>
        <p class="text-gray-600">
            <?php echo e($kpiDocument->period_year); ?> | Role: <?php echo e($kpiDocument->user->role_label); ?>

            &nbsp;·&nbsp; Dibuat: <?php echo e($kpiDocument->created_at->format('d M Y')); ?>

            <?php if($kpiDocument->submitted_at): ?>
                &nbsp;·&nbsp; Disubmit: <?php echo e($kpiDocument->submitted_at->format('d M Y H:i')); ?>

            <?php endif; ?>
        </p>
        <span class="badge <?php echo e($kpiDocument->status_badge_class); ?> mt-2 inline-block"><?php echo e($kpiDocument->status_label); ?></span>
    </div>
    <div class="flex gap-2 flex-wrap">
        <?php if(auth()->user()->isStaff()): ?>
            <a href="<?php echo e(route('kpi.index')); ?>" class="btn-secondary">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            <?php if($kpiDocument->status === 'draft'): ?>
                <a href="<?php echo e(route('kpi.edit', $kpiDocument->id)); ?>" class="btn-primary">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            <?php endif; ?>
        <?php else: ?>
            <a href="<?php echo e(route('hr.kpi.index')); ?>" class="btn-secondary">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            <a href="<?php echo e(route('hr.kpi.edit', $kpiDocument->id)); ?>" class="btn-primary">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit/Review
            </a>
            <button class="bg-red-600 text-white px-4 py-2 rounded text-sm font-medium hover:bg-red-700 transition"
                    data-delete-url="<?php echo e(route('hr.kpi.destroy', $kpiDocument->id)); ?>"
                    data-delete-desc="Dokumen KPI milik <?php echo e($kpiDocument->user->name); ?> (<?php echo e($kpiDocument->period_year); ?>) akan dihapus permanen.">
                <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        <?php endif; ?>
        <button onclick="window.print()" class="btn-secondary">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak
        </button>
    </div>
</header>

<?php
    $jdTotal  = $kpiDocument->jobdescs->sum('total_mandays_penugasan');
    $ciTotal  = $kpiDocument->continuesImprovements->sum('point');
    $sdTotal  = $kpiDocument->selfDevelopments->sum('point');
    $hrTotal  = $kpiDocument->hrActivities->sum('point');
    $pkTotal  = $kpiDocument->kinerjaPerilakus->sum('score');
?>


<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Jobdesc</p>
        <p class="text-xl font-bold text-gray-800"><?php echo e(number_format($jdTotal, 2)); ?></p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-xs text-gray-500 uppercase tracking-wide">CI</p>
        <p class="text-xl font-bold text-green-700"><?php echo e(number_format($ciTotal, 2)); ?></p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Self Dev</p>
        <p class="text-xl font-bold text-yellow-600"><?php echo e(number_format($sdTotal, 2)); ?></p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-xs text-gray-500 uppercase tracking-wide">HR Act</p>
        <p class="text-xl font-bold text-purple-700"><?php echo e(number_format($hrTotal, 2)); ?></p>
    </div>
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Perilaku</p>
        <p class="text-xl font-bold text-cyan-700"><?php echo e(number_format($pkTotal, 2)); ?></p>
    </div>
    <div class="bg-red-50 rounded-lg shadow p-4 text-center border border-red-200">
        <p class="text-xs text-red-600 uppercase tracking-wide font-semibold">Total Score</p>
        <p class="text-xl font-bold text-red-700"><?php echo e(number_format($kpiDocument->total_score, 2)); ?></p>
    </div>
</div>


<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
        <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        A. Kinerja Hasil — Subform Jobdesc
    </h2>
    <?php if($kpiDocument->jobdescs->isEmpty()): ?>
        <div class="text-center py-8">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-gray-500">Belum ada data Jobdesc</p>
        </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Penilaian Koef. On Time & On Budget</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Penilaian Grade Project</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Kegiatan dan Bukti</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mandays Proyek</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase bg-blue-50 text-blue-700">Jml Koefisien</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase bg-blue-50 text-blue-700">Total Mandays Penugasan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $kpiDocument->jobdescs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $jd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 text-sm"><?php echo e($i+1); ?></td>
                    <td class="px-3 py-2 text-sm"><?php echo e(number_format($jd->penilaian_koefisien_ontime_onbudget, 2)); ?></td>
                    <td class="px-3 py-2 text-sm"><?php echo e(number_format($jd->penilaian_grade_project, 2)); ?></td>
                    <td class="px-3 py-2 text-sm"><?php echo e($jd->nama_kegiatan_bukti ?: '—'); ?></td>
                    <td class="px-3 py-2 text-sm"><?php echo e(number_format($jd->mandays_proyek, 2)); ?></td>
                    <td class="px-3 py-2 text-sm bg-blue-50 font-semibold text-blue-700"><?php echo e(number_format($jd->jumlah_koefisien, 2)); ?></td>
                    <td class="px-3 py-2 text-sm bg-blue-50 font-semibold text-blue-700"><?php echo e(number_format($jd->total_mandays_penugasan, 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3 bg-gray-50 rounded p-3 text-sm flex items-center gap-2">
        <span class="font-medium text-gray-700">Total Mandays Jobdesc:</span>
        <span class="font-bold text-red-700"><?php echo e(number_format($jdTotal, 2)); ?></span>
    </div>
    <?php endif; ?>
</div>


<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
        <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        B. Kinerja Hasil — Subform CI, SD, HRA
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        
        <div class="border rounded-lg p-4">
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                Continuous Improvement (CI)
            </h3>
            <?php if($kpiDocument->continuesImprovements->isEmpty()): ?>
                <p class="text-sm text-gray-400">Belum ada data</p>
            <?php else: ?>
                <?php $__currentLoopData = $kpiDocument->continuesImprovements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ci): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-3 pb-3 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                    <p class="text-xs text-gray-500 mb-1"><span class="badge badge-aktif text-[10px]"><?php echo e($ci->jenis_kegiatan_bukti); ?></span></p>
                    <p class="text-sm text-gray-700 mb-1"><?php echo e($ci->kegiatan); ?></p>
                    <div class="flex gap-4 text-xs text-gray-500">
                        <span>Mandays: <strong><?php echo e(number_format($ci->mandays, 2)); ?></strong></span>
                        <span>Koef: <strong><?php echo e(number_format($ci->koefisien, 4)); ?></strong></span>
                        <span>Point: <strong class="text-green-700"><?php echo e(number_format($ci->point, 4)); ?></strong></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

        
        <div class="border rounded-lg p-4">
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-yellow-500 inline-block"></span>
                Self Development (SD)
            </h3>
            <?php if($kpiDocument->selfDevelopments->isEmpty()): ?>
                <p class="text-sm text-gray-400">Belum ada data</p>
            <?php else: ?>
                <?php $__currentLoopData = $kpiDocument->selfDevelopments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-3 pb-3 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                    <p class="text-xs text-gray-500 mb-1"><span class="badge badge-draft text-[10px]"><?php echo e($sd->jenis_sd); ?></span></p>
                    <p class="text-sm text-gray-700 mb-1"><?php echo e($sd->kegiatan); ?></p>
                    <div class="flex gap-4 text-xs text-gray-500">
                        <span>Mandays: <strong><?php echo e(number_format($sd->mandays, 2)); ?></strong></span>
                        <span>Koef: <strong><?php echo e(number_format($sd->koefisien, 4)); ?></strong></span>
                        <span>Point: <strong class="text-yellow-600"><?php echo e(number_format($sd->point, 4)); ?></strong></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

        
        <div class="border rounded-lg p-4">
            <h3 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-purple-500 inline-block"></span>
                HR Activity (HRA)
            </h3>
            <?php if($kpiDocument->hrActivities->isEmpty()): ?>
                <p class="text-sm text-gray-400">Belum ada data</p>
            <?php else: ?>
                <?php $__currentLoopData = $kpiDocument->hrActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-3 pb-3 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                    <p class="text-xs text-gray-500 mb-1"><span class="badge badge-diproses text-[10px]"><?php echo e($hr->jenis_kegiatan); ?></span></p>
                    <p class="text-sm text-gray-700 mb-1"><?php echo e($hr->kegiatan); ?></p>
                    <div class="flex gap-4 text-xs text-gray-500">
                        <span>Mandays: <strong><?php echo e(number_format($hr->mandays, 2)); ?></strong></span>
                        <span>Koef: <strong><?php echo e(number_format($hr->koefisien, 4)); ?></strong></span>
                        <span>Point: <strong class="text-purple-700"><?php echo e(number_format($hr->point, 4)); ?></strong></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-gray-50 rounded-lg p-3 text-sm">
        <p class="font-medium text-gray-700">
            Total Point Semua Subform:
            <span class="font-bold text-red-700"><?php echo e(number_format($jdTotal + $ciTotal + $sdTotal + $hrTotal, 2)); ?></span>
            (Jobdesc <?php echo e(number_format($jdTotal, 2)); ?> + CI <?php echo e(number_format($ciTotal, 2)); ?> + SD <?php echo e(number_format($sdTotal, 2)); ?> + HRA <?php echo e(number_format($hrTotal, 2)); ?>)
        </p>
    </div>
</div>


<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
        <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        C. Total Cuti & Target Point
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="text-center bg-gray-50 rounded p-3">
            <p class="text-xs text-gray-500">Total Cuti</p>
            <p class="font-bold text-lg text-gray-800"><?php echo e($kpiDocument->total_cuti ?? 0); ?></p>
        </div>
        <div class="text-center bg-gray-50 rounded p-3">
            <p class="text-xs text-gray-500">Hari Kerja Efektif</p>
            <p class="font-bold text-lg text-gray-800"><?php echo e($kpiDocument->hari_kerja_efektif ?? 238); ?></p>
        </div>
        <div class="text-center bg-gray-50 rounded p-3">
            <p class="text-xs text-gray-500">Koefisien Role</p>
            <p class="font-bold text-lg text-gray-800"><?php echo e(number_format($kpiDocument->koefisien_role ?? 1.000, 3)); ?></p>
        </div>
        <div class="text-center bg-gray-50 rounded p-3">
            <p class="text-xs text-gray-500">Target Point Minimal</p>
            <p class="font-bold text-lg text-gray-800"><?php echo e(number_format($kpiDocument->target_point_minimal ?? 0, 2)); ?></p>
        </div>
        <div class="text-center bg-red-50 rounded p-3 border border-red-200">
            <p class="text-xs text-red-600 font-semibold">Total Point Diperoleh</p>
            <p class="font-bold text-lg text-red-700"><?php echo e(number_format($jdTotal + $ciTotal + $sdTotal + $hrTotal, 2)); ?></p>
        </div>
    </div>
</div>


<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
        <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>
        D. Penilaian Kinerja Perilaku (<?php echo e($kpiDocument->kinerjaPerilakus->count()); ?> Aspek)
    </h2>
    <?php if($kpiDocument->kinerjaPerilakus->isEmpty()): ?>
        <div class="text-center py-8">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
            <p class="text-gray-500">Belum ada data Kinerja Perilaku</p>
        </div>
    <?php else: ?>
    <div class="space-y-3">
        <?php $__currentLoopData = $kpiDocument->kinerjaPerilakus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $kp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex justify-between items-center border-b border-gray-100 pb-3">
            <div class="flex-1">
                <p class="font-medium text-sm text-gray-800">
                    <?php echo e($i+1); ?>. <?php echo e($kp->aspek_kinerja); ?>

                </p>
                <p class="text-xs text-gray-500">
                    Score: <span class="<?php echo e($kp->score >= $kp->minimum_capaian ? 'text-green-600' : 'text-red-600'); ?> font-semibold"><?php echo e(number_format($kp->score, 2)); ?></span>
                    / Min: <?php echo e(number_format($kp->minimum_capaian, 0)); ?>

                    <span class="ml-2 badge <?php echo e($kp->score >= $kp->minimum_capaian ? 'badge-aktif' : 'badge-rejected'); ?> text-[10px]">
                        <?php echo e($kp->score >= $kp->minimum_capaian ? 'Tercapai' : 'Belum Tercapai'); ?>

                    </span>
                </p>
            </div>
            <p class="text-xs text-gray-500 max-w-xs text-right ml-4"><?php echo e($kp->indikator); ?></p>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="mt-4 bg-gray-50 rounded p-3 text-sm">
        <p class="font-medium text-gray-700">
            Total Score Kinerja Perilaku: <span class="font-bold text-red-700"><?php echo e(number_format($pkTotal, 2)); ?></span>
            &nbsp;|&nbsp; Rata-Rata: <span class="font-bold text-red-700"><?php echo e($kpiDocument->kinerjaPerilakus->count() > 0 ? number_format($pkTotal / $kpiDocument->kinerjaPerilakus->count(), 2) : 0); ?></span>
        </p>
    </div>
    <?php endif; ?>
</div>


<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
        <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
        </svg>
        E. Preview Final Score
    </h2>
    <?php
        $totalPointHasil = $jdTotal + $ciTotal + $sdTotal + $hrTotal;
        $avgPerilaku = $kpiDocument->kinerjaPerilakus->count() > 0 ? $pkTotal / $kpiDocument->kinerjaPerilakus->count() : 0;
        $targetPoint = $kpiDocument->target_point_minimal ?? 238;
        $koefRole = $kpiDocument->koefisien_role ?? 1.000;
    ?>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <p class="text-xs text-gray-500">Final Score Hasil</p>
            <p class="text-2xl font-bold text-gray-800"><?php echo e(number_format(70/100 * 5 * ($targetPoint > 0 ? $totalPointHasil / $targetPoint : 0), 2)); ?></p>
            <p class="text-[10px] text-gray-400">70% × 5 × (<?php echo e(number_format($totalPointHasil, 2)); ?> ÷ <?php echo e(number_format($targetPoint, 0)); ?>)</p>
        </div>
        <div class="text-center p-4 bg-gray-50 rounded-lg">
            <p class="text-xs text-gray-500">Final Score Perilaku</p>
            <p class="text-2xl font-bold text-gray-800"><?php echo e(number_format(30/100 * 5 * $avgPerilaku, 2)); ?></p>
            <p class="text-[10px] text-gray-400">30% × 5 × <?php echo e(number_format($avgPerilaku, 2)); ?></p>
        </div>
        <div class="text-center p-4 bg-red-50 rounded-lg border border-red-200">
            <p class="text-xs text-red-600 font-semibold">Final KPI Score</p>
            <p class="text-2xl font-bold text-red-700"><?php echo e(number_format($kpiDocument->total_score, 2)); ?></p>
            <p class="text-[10px] text-red-500">Hasil + Perilaku</p>
        </div>
        <div class="text-center p-4 bg-red-50 rounded-lg border border-red-200">
            <p class="text-xs text-red-600 font-semibold">Predikat</p>
            <p class="text-2xl font-bold text-red-700"><?php echo e($kpiDocument->predikat ?? '—'); ?></p>
            <p class="text-[10px] text-red-500">Sesuai rentang nilai</p>
        </div>
    </div>
</div>


<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b flex items-center gap-2">
        <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        F. Riwayat Perubahan
    </h2>
    <?php if($kpiDocument->histories->isEmpty()): ?>
        <div class="text-center py-8">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-500">Belum ada riwayat perubahan</p>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $kpiDocument->histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <div class="flex items-start justify-between flex-wrap gap-2 mb-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="badge <?php echo e($hist->action_badge_class); ?>"><?php echo e($hist->action_label); ?></span>
                        <?php if($hist->section): ?>
                            <span class="text-xs bg-white border border-gray-300 text-gray-600 rounded px-2 py-0.5"><?php echo e($hist->section_label); ?></span>
                        <?php endif; ?>
                        <span class="text-sm text-gray-700"><?php echo e($hist->description); ?></span>
                    </div>
                    <span class="text-xs text-gray-500 whitespace-nowrap"><?php echo e($hist->created_at->format('d M Y H:i')); ?></span>
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    Oleh: <strong><?php echo e($hist->changedBy->name); ?></strong> (<?php echo e($hist->changedBy->role_label); ?>)
                </div>
                <?php if($hist->old_data && $hist->action === 'update'): ?>
                    <div class="mt-2">
                        <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden')"
                                class="text-xs text-blue-600 hover:underline">
                            Detail Perubahan
                        </button>
                        <div class="hidden mt-2 grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Data Sebelum:</p>
                                <pre class="bg-white rounded p-2 text-xs max-h-32 overflow-auto border"><?php echo e(json_encode($hist->old_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Data Sesudah:</p>
                                <pre class="bg-white rounded p-2 text-xs max-h-32 overflow-auto border"><?php echo e(json_encode($hist->new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<?php if($kpiDocument->notes): ?>
<div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-lg p-4 text-sm flex items-start gap-2">
    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
    </svg>
    <span><strong>Catatan:</strong> <?php echo e($kpiDocument->notes); ?></span>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/kpi/show.blade.php ENDPATH**/ ?>