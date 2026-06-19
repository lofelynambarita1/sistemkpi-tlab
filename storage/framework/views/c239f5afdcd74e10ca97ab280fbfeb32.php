<?php $__env->startSection('title', 'Edit KPI Staff — ' . $kpiDocument->user->name); ?>
<?php $__env->startPush('styles'); ?>
<style>
.form-section { background:#fff; border-radius:12px; border:1px solid #e2e8f0; margin-bottom:1.5rem; overflow:hidden; }
.form-section-header { background:linear-gradient(90deg,#7F1D1D,#B91C1C); color:#fff; padding:.9rem 1.25rem; font-weight:600; display:flex; align-items:center; gap:.5rem; }
.form-section-body { padding:1.25rem; }
.subform-table th { background:#f8fafc; font-size:.8rem; font-weight:600; text-transform:uppercase; color:#64748b; white-space:nowrap; }
.subform-table td { vertical-align:middle; }
.calc-field { background:#FEF2F2 !important; color:#B91C1C; font-weight:600; border-color:#FECACA !important; cursor:not-allowed; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="<?php echo e(route('dashboard')); ?>" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li><a href="<?php echo e(route('hr.kpi.index')); ?>" class="text-red-700 hover:underline">Kelola Dokumen KPI</a></li>
        <li>/</li>
        <li class="text-gray-700">Edit KPI — <?php echo e($kpiDocument->user->name); ?></li>
    </ol>
</nav>

<header class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Edit/Review KPI — <?php echo e($kpiDocument->user->name); ?> (<?php echo e($kpiDocument->period_year); ?>)</h1>
        <p class="text-gray-600 text-sm"><?php echo e(auth()->user()->name); ?> · <?php echo e(auth()->user()->role_label); ?></p>
    </div>
    <a href="<?php echo e(route('hr.kpi.show', $kpiDocument->id)); ?>" class="btn-secondary">Kembali</a>
</header>

<div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg px-4 py-3 mb-6 text-sm flex items-center gap-2">
    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    Segala perubahan yang Anda lakukan akan tercatat di <strong>History</strong> dan dapat dilihat oleh staff yang bersangkutan.
</div>

<form method="POST" action="<?php echo e(route('hr.kpi.update', $kpiDocument->id)); ?>" id="hrEditForm">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

    <div class="form-section">
        <div class="form-section-header">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Informasi & Status Dokumen
        </div>
        <div class="form-section-body">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Staff</label>
                    <p class="font-bold text-gray-800"><?php echo e($kpiDocument->user->name); ?></p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Periode</label>
                    <p class="font-bold text-gray-800"><?php echo e($kpiDocument->period_year); ?></p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Total Score</label>
                    <p class="font-bold text-red-700"><?php echo e(number_format($kpiDocument->total_score, 2)); ?></p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="submitted" <?php echo e($kpiDocument->status=='submitted' ? 'selected':''); ?>>Disubmit</option>
                        <option value="reviewed"  <?php echo e($kpiDocument->status=='reviewed'  ? 'selected':''); ?>>Ditinjau</option>
                        <option value="approved"  <?php echo e($kpiDocument->status=='approved'  ? 'selected':''); ?>>Disetujui</option>
                    </select>
                    <?php if($kpiDocument->status === 'draft'): ?>
                        <small class="text-yellow-600"><svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Dokumen masih Draft</small>
                    <?php endif; ?>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Catatan HR/Manager</label>
                    <input type="text" name="notes" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-700" placeholder="Catatan review..." value="<?php echo e(old('notes', $kpiDocument->notes)); ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="border border-gray-200 rounded-t-lg bg-gray-50 px-4 pt-3">
        <div class="flex flex-wrap gap-1">
            <a class="px-4 py-2 text-sm font-medium text-red-700 border-b-2 border-red-700 bg-white rounded-t" data-bs-toggle="tab" href="#hr-edit-jobdesc">Jobdesc</a>
            <a class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-red-700" data-bs-toggle="tab" href="#hr-edit-ci">Continues Improvement</a>
            <a class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-red-700" data-bs-toggle="tab" href="#hr-edit-sd">Self Development</a>
            <a class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-red-700" data-bs-toggle="tab" href="#hr-edit-hr">HR Activity</a>
            <a class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-red-700" data-bs-toggle="tab" href="#hr-edit-perilaku">Kinerja Perilaku</a>
        </div>
    </div>

    <div class="tab-content border border-t-0 border-gray-200 rounded-b-lg p-5 bg-gray-50">

        <div class="tab-pane fade show active" id="hr-edit-jobdesc">
            <div class="form-section">
                <div class="form-section-header">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Jobdesc
                </div>
                <div class="form-section-body">
                    <?php if($kpiDocument->jobdescs->isEmpty()): ?>
                        <p class="text-gray-400"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg> Tidak ada data Jobdesc</p>
                    <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 subform-table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:160px">Koef. OTB</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:160px">Grade Project</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:200px">Nama Kegiatan & Bukti</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:120px">Mandays Proyek</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase text-red-700" style="min-width:150px">Jumlah Koef.</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase text-red-700" style="min-width:150px">Total Mandays</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $kpiDocument->jobdescs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $jd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-3 py-2 text-sm"><?php echo e($i+1); ?></td>
                                    <td class="px-3 py-2"><input type="number" name="jobdesc[<?php echo e($jd->id); ?>][penilaian_koefisien_ontime_onbudget]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm jd-otb" value="<?php echo e($jd->penilaian_koefisien_ontime_onbudget); ?>" step="0.01" min="0" oninput="hrCalcJD(this.closest('tr'))"></td>
                                    <td class="px-3 py-2"><input type="number" name="jobdesc[<?php echo e($jd->id); ?>][penilaian_grade_project]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm jd-grade" value="<?php echo e($jd->penilaian_grade_project); ?>" step="0.01" min="0" oninput="hrCalcJD(this.closest('tr'))"></td>
                                    <td class="px-3 py-2"><input type="text" name="jobdesc[<?php echo e($jd->id); ?>][nama_kegiatan_bukti]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($jd->nama_kegiatan_bukti); ?>"></td>
                                    <td class="px-3 py-2"><input type="number" name="jobdesc[<?php echo e($jd->id); ?>][mandays_proyek]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm jd-mandays" value="<?php echo e($jd->mandays_proyek); ?>" step="0.01" min="0" oninput="hrCalcJD(this.closest('tr'))"></td>
                                    <td class="px-3 py-2"><input type="text" class="w-full px-2 py-1 border rounded text-sm calc-field jd-jumlah" value="<?php echo e(number_format($jd->jumlah_koefisien,2,'.','')); ?>" readonly tabindex="-1"></td>
                                    <td class="px-3 py-2"><input type="text" class="w-full px-2 py-1 border rounded text-sm calc-field jd-total" value="<?php echo e(number_format($jd->total_mandays_penugasan,2,'.','')); ?>" readonly tabindex="-1"></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="hr-edit-ci">
            <div class="form-section">
                <div class="form-section-header">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Continues Improvement
                </div>
                <div class="form-section-body">
                    <?php if($kpiDocument->continuesImprovements->isEmpty()): ?>
                        <p class="text-gray-400">Tidak ada data CI</p>
                    <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 subform-table">
                            <thead class="bg-gray-50">
                                <tr><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:230px">Jenis Kegiatan/Bukti</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:200px">Kegiatan</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:110px">Mandays</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase text-red-700" style="min-width:100px">Koefisien</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase text-red-700" style="min-width:100px">Point</th></tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $kpiDocument->continuesImprovements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ci): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-3 py-2 text-sm"><?php echo e($i+1); ?></td>
                                    <td class="px-3 py-2">
                                        <select name="ci_edit[<?php echo e($ci->id); ?>][jenis_kegiatan_bukti]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm ci-jenis" onchange="hrCalcCI(this.closest('tr'))">
                                            <?php $__currentLoopData = array_keys(\App\Models\KpiContinuesImprovement::$koefisienMap); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt); ?>" <?php echo e($ci->jenis_kegiatan_bukti===$opt?'selected':''); ?>><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td class="px-3 py-2"><input type="text" name="ci_edit[<?php echo e($ci->id); ?>][kegiatan]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($ci->kegiatan); ?>"></td>
                                    <td class="px-3 py-2"><input type="number" name="ci_edit[<?php echo e($ci->id); ?>][mandays]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm ci-mandays" value="<?php echo e($ci->mandays); ?>" step="0.01" min="0" oninput="hrCalcCI(this.closest('tr'))"></td>
                                    <td class="px-3 py-2"><input type="text" class="w-full px-2 py-1 border rounded text-sm calc-field ci-koef" value="<?php echo e(number_format($ci->koefisien,4,'.','')); ?>" readonly tabindex="-1"></td>
                                    <td class="px-3 py-2"><input type="text" class="w-full px-2 py-1 border rounded text-sm calc-field ci-point" value="<?php echo e(number_format($ci->point,4,'.','')); ?>" readonly tabindex="-1"></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="hr-edit-sd">
            <div class="form-section">
                <div class="form-section-header">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Self Development
                </div>
                <div class="form-section-body">
                    <?php if($kpiDocument->selfDevelopments->isEmpty()): ?>
                        <p class="text-gray-400">Tidak ada data SD</p>
                    <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 subform-table">
                            <thead class="bg-gray-50">
                                <tr><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:230px">Jenis SD</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:200px">Kegiatan</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:110px">Mandays</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase text-red-700" style="min-width:100px">Koefisien</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase text-red-700" style="min-width:100px">Point</th></tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $kpiDocument->selfDevelopments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-3 py-2 text-sm"><?php echo e($i+1); ?></td>
                                    <td class="px-3 py-2">
                                        <select name="sd_edit[<?php echo e($sd->id); ?>][jenis_sd]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm sd-jenis" onchange="hrCalcSD(this.closest('tr'))">
                                            <?php $__currentLoopData = array_keys(\App\Models\KpiSelfDevelopment::$koefisienMap); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt); ?>" <?php echo e($sd->jenis_sd===$opt?'selected':''); ?>><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td class="px-3 py-2"><input type="text" name="sd_edit[<?php echo e($sd->id); ?>][kegiatan]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($sd->kegiatan); ?>"></td>
                                    <td class="px-3 py-2"><input type="number" name="sd_edit[<?php echo e($sd->id); ?>][mandays]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm sd-mandays" value="<?php echo e($sd->mandays); ?>" step="0.01" min="0" oninput="hrCalcSD(this.closest('tr'))"></td>
                                    <td class="px-3 py-2"><input type="text" class="w-full px-2 py-1 border rounded text-sm calc-field sd-koef" value="<?php echo e(number_format($sd->koefisien,4,'.','')); ?>" readonly tabindex="-1"></td>
                                    <td class="px-3 py-2"><input type="text" class="w-full px-2 py-1 border rounded text-sm calc-field sd-point" value="<?php echo e(number_format($sd->point,4,'.','')); ?>" readonly tabindex="-1"></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="hr-edit-hr">
            <div class="form-section">
                <div class="form-section-header">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    HR Activity
                </div>
                <div class="form-section-body">
                    <?php if($kpiDocument->hrActivities->isEmpty()): ?>
                        <p class="text-gray-400">Tidak ada data HR Activity</p>
                    <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 subform-table">
                            <thead class="bg-gray-50">
                                <tr><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:230px">Jenis Kegiatan</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:200px">Kegiatan</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:110px">Mandays</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase text-red-700" style="min-width:100px">Koefisien</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase text-red-700" style="min-width:100px">Point</th></tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $kpiDocument->hrActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $hr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-3 py-2 text-sm"><?php echo e($i+1); ?></td>
                                    <td class="px-3 py-2">
                                        <select name="hr_edit[<?php echo e($hr->id); ?>][jenis_kegiatan]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm hr-jenis" onchange="hrCalcHR(this.closest('tr'))">
                                            <?php $__currentLoopData = array_keys(\App\Models\KpiHrActivity::$koefisienMap); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt); ?>" <?php echo e($hr->jenis_kegiatan===$opt?'selected':''); ?>><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td class="px-3 py-2"><input type="text" name="hr_edit[<?php echo e($hr->id); ?>][kegiatan]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($hr->kegiatan); ?>"></td>
                                    <td class="px-3 py-2"><input type="number" name="hr_edit[<?php echo e($hr->id); ?>][mandays]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm hr-mandays" value="<?php echo e($hr->mandays); ?>" step="0.01" min="0" oninput="hrCalcHR(this.closest('tr'))"></td>
                                    <td class="px-3 py-2"><input type="text" class="w-full px-2 py-1 border rounded text-sm calc-field hr-koef" value="<?php echo e(number_format($hr->koefisien,4,'.','')); ?>" readonly tabindex="-1"></td>
                                    <td class="px-3 py-2"><input type="text" class="w-full px-2 py-1 border rounded text-sm calc-field hr-point" value="<?php echo e(number_format($hr->point,4,'.','')); ?>" readonly tabindex="-1"></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="hr-edit-perilaku">
            <div class="form-section">
                <div class="form-section-header">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    Kinerja Perilaku
                </div>
                <div class="form-section-body">
                    <?php if($kpiDocument->kinerjaPerilakus->isEmpty()): ?>
                        <p class="text-gray-400">Tidak ada data Kinerja Perilaku</p>
                    <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 subform-table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aspek Kinerja</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Definisi</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Min. Capaian</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Indikator</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase" style="min-width:110px">Score</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $kpiDocument->kinerjaPerilakus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $kp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-3 py-2 text-sm"><?php echo e($i+1); ?></td>
                                    <td class="px-3 py-2 text-sm font-medium"><?php echo e($kp->aspek_kinerja); ?></td>
                                    <td class="px-3 py-2 text-sm"><small><?php echo e($kp->definisi); ?></small></td>
                                    <td class="px-3 py-2 text-sm text-center"><span class="badge badge-draft">≥ <?php echo e($kp->minimum_capaian); ?></span></td>
                                    <td class="px-3 py-2 text-sm"><small><?php echo e($kp->indikator); ?></small></td>
                                    <td class="px-3 py-2 text-sm"><small><?php echo e($kp->deskripsi); ?></small></td>
                                    <td class="px-3 py-2">
                                        <input type="number" name="perilaku_edit[<?php echo e($kp->id); ?>][score]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($kp->score); ?>" min="0" max="100" step="0.01">
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-lg shadow p-4 mt-6 border border-yellow-200">
        <div class="flex justify-between items-center flex-wrap gap-3">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Perubahan akan dicatat di history dan dapat dilihat oleh staff.
            </div>
            <div class="flex gap-2">
                <a href="<?php echo e(route('hr.kpi.show', $kpiDocument->id)); ?>" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const CI_KOEFISIEN = <?php echo json_encode(\App\Models\KpiContinuesImprovement::$koefisienMap, 15, 512) ?>;
const SD_KOEFISIEN = <?php echo json_encode(\App\Models\KpiSelfDevelopment::$koefisienMap, 15, 512) ?>;
const HR_KOEFISIEN = <?php echo json_encode(\App\Models\KpiHrActivity::$koefisienMap, 15, 512) ?>;

function hrCalcJD(row) {
    const otb   = parseFloat(row.querySelector('.jd-otb').value)||0;
    const grade = parseFloat(row.querySelector('.jd-grade').value)||0;
    const md    = parseFloat(row.querySelector('.jd-mandays').value)||0;
    const jml   = otb + grade;
    row.querySelector('.jd-jumlah').value = jml.toFixed(2);
    row.querySelector('.jd-total').value  = (jml * md).toFixed(2);
}
function hrCalcCI(row) {
    const jenis = row.querySelector('.ci-jenis').value;
    const md    = parseFloat(row.querySelector('.ci-mandays').value)||0;
    const koef  = CI_KOEFISIEN[jenis]||0.5;
    row.querySelector('.ci-koef').value  = koef.toFixed(4);
    row.querySelector('.ci-point').value = (koef*md).toFixed(4);
}
function hrCalcSD(row) {
    const jenis = row.querySelector('.sd-jenis').value;
    const md    = parseFloat(row.querySelector('.sd-mandays').value)||0;
    const koef  = SD_KOEFISIEN[jenis]||0.5;
    row.querySelector('.sd-koef').value  = koef.toFixed(4);
    row.querySelector('.sd-point').value = (koef*md).toFixed(4);
}
function hrCalcHR(row) {
    const jenis = row.querySelector('.hr-jenis').value;
    const md    = parseFloat(row.querySelector('.hr-mandays').value)||0;
    const koef  = HR_KOEFISIEN[jenis]||0.5;
    row.querySelector('.hr-koef').value  = koef.toFixed(4);
    row.querySelector('.hr-point').value = (koef*md).toFixed(4);
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/hr/edit.blade.php ENDPATH**/ ?>