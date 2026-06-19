<?php $__env->startSection('title', 'Review KPI — ' . $kpiDocument->user->name); ?>
<?php $__env->startPush('styles'); ?>
<style>
.subform-view-table th { background:#f1f5f9; font-size:.8rem; font-weight:600; text-transform:uppercase; color:#64748b; }
.calc-cell { background:#FEF2F2; color:#B91C1C; font-weight:600; }
.inline-edit-form { display:none; background:#f8fafc; padding:1rem; border-radius:8px; border:1px solid #e2e8f0; margin-top:.5rem; }
.inline-edit-form.show { display:block; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<nav class="mb-4 text-sm">
    <ol class="flex text-gray-500 gap-2">
        <li><a href="<?php echo e(route('dashboard')); ?>" class="text-red-700 hover:underline">Home</a></li>
        <li>/</li>
        <li><a href="<?php echo e(route('hr.kpi.index')); ?>" class="text-red-700 hover:underline">Kelola Dokumen KPI</a></li>
        <li>/</li>
        <li class="text-gray-700">Review KPI — <?php echo e($kpiDocument->user->name); ?></li>
    </ol>
</nav>

<header class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Review KPI — <?php echo e($kpiDocument->user->name); ?> (<?php echo e($kpiDocument->period_year); ?>)</h1>
        <p class="text-gray-600 text-sm">
            <?php echo e($kpiDocument->user->role_label ?? ''); ?> · Dibuat: <?php echo e($kpiDocument->created_at->format('d M Y')); ?>

            <?php if($kpiDocument->submitted_at): ?>
            · Disubmit: <?php echo e($kpiDocument->submitted_at->format('d M Y H:i')); ?>

            <?php endif; ?>
        </p>
    </div>
    <div class="flex gap-2 flex-wrap">
        <a href="<?php echo e(route('hr.kpi.index')); ?>" class="btn-secondary">Kembali</a>
        <a href="<?php echo e(route('hr.kpi.edit', $kpiDocument->id)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-medium">Edit</a>
        <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-medium"
                data-delete-url="<?php echo e(route('hr.kpi.destroy', $kpiDocument->id)); ?>"
                data-delete-desc="Dokumen KPI milik <?php echo e($kpiDocument->user->name); ?> (<?php echo e($kpiDocument->period_year); ?>) akan dihapus permanen.">Hapus</button>
        <button onclick="window.print()" class="btn-secondary">Cetak</button>
    </div>
</header>

<?php
    $jdTotal = $kpiDocument->jobdescs->sum('total_mandays_penugasan');
    $ciTotal = $kpiDocument->continuesImprovements->sum('point');
    $sdTotal = $kpiDocument->selfDevelopments->sum('point');
    $hrTotal = $kpiDocument->hrActivities->sum('point');
    $pkTotal = $kpiDocument->kinerjaPerilakus->sum('score');
?>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4 text-center flex flex-col items-center justify-center">
        <span class="badge <?php echo e($kpiDocument->status_badge_class); ?> text-sm px-3 py-2"><?php echo e($kpiDocument->status_label); ?></span>
        <small class="text-gray-500 mt-2">Status Dokumen</small>
    </div>
    <div class="md:col-span-3 bg-white rounded-lg shadow p-4">
        <div class="grid grid-cols-2 md:grid-cols-6 gap-2 text-center">
            <div class="border-r">
                <div class="text-muted small text-gray-500 text-xs">Jobdesc</div>
                <div class="font-bold text-red-700 text-lg"><?php echo e(number_format($jdTotal,2)); ?></div>
            </div>
            <div class="border-r">
                <div class="text-muted small text-gray-500 text-xs">CI</div>
                <div class="font-bold text-green-600 text-lg"><?php echo e(number_format($ciTotal,2)); ?></div>
            </div>
            <div class="border-r">
                <div class="text-muted small text-gray-500 text-xs">Self Dev</div>
                <div class="font-bold text-yellow-600 text-lg"><?php echo e(number_format($sdTotal,2)); ?></div>
            </div>
            <div class="border-r">
                <div class="text-muted small text-gray-500 text-xs">HR Act</div>
                <div class="font-bold text-purple-600 text-lg"><?php echo e(number_format($hrTotal,2)); ?></div>
            </div>
            <div class="border-r">
                <div class="text-muted small text-gray-500 text-xs">Perilaku</div>
                <div class="font-bold text-cyan-600 text-lg"><?php echo e(number_format($pkTotal,2)); ?></div>
            </div>
            <div>
                <div class="text-muted small text-gray-500 text-xs font-semibold">TOTAL</div>
                <div class="font-bold text-2xl text-gray-800"><?php echo e(number_format($kpiDocument->total_score,2)); ?></div>
            </div>
        </div>
    </div>
</div>

<div class="border border-gray-200 rounded-t-lg bg-gray-50 px-4 pt-3">
    <div class="flex flex-wrap gap-1">
        <a class="px-4 py-2 text-sm font-medium text-red-700 border-b-2 border-red-700 bg-white rounded-t" data-bs-toggle="tab" href="#hr-jobdesc">Jobdesc</a>
        <a class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-red-700" data-bs-toggle="tab" href="#hr-ci">Continues Improvement</a>
        <a class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-red-700" data-bs-toggle="tab" href="#hr-sd">Self Development</a>
        <a class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-red-700" data-bs-toggle="tab" href="#hr-hr">HR Activity</a>
        <a class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-red-700" data-bs-toggle="tab" href="#hr-perilaku">Kinerja Perilaku</a>
        <a class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-red-700" data-bs-toggle="tab" href="#hr-history">
            History
            <span class="badge badge-diproses ms-1"><?php echo e($kpiDocument->histories->count()); ?></span>
        </a>
    </div>
</div>

<div class="tab-content border border-t-0 border-gray-200 rounded-b-lg p-5 bg-white">

    <div class="tab-pane fade show active" id="hr-jobdesc">
        <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Jobdesc
        </h3>
        <?php if($kpiDocument->jobdescs->isEmpty()): ?>
            <p class="text-gray-400 text-center py-3">Belum ada data Jobdesc</p>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 subform-view-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Koef. OTB</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Grade Project</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Kegiatan & Bukti</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mandays Proyek</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase calc-cell">Jumlah Koef.</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase calc-cell">Total Mandays</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Edit</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $kpiDocument->jobdescs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $jd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-3 py-2 text-sm"><?php echo e($i+1); ?></td>
                        <td class="px-3 py-2 text-sm"><?php echo e(number_format($jd->penilaian_koefisien_ontime_onbudget,2)); ?></td>
                        <td class="px-3 py-2 text-sm"><?php echo e(number_format($jd->penilaian_grade_project,2)); ?></td>
                        <td class="px-3 py-2 text-sm"><?php echo e($jd->nama_kegiatan_bukti ?: '—'); ?></td>
                        <td class="px-3 py-2 text-sm"><?php echo e(number_format($jd->mandays_proyek,2)); ?></td>
                        <td class="px-3 py-2 text-sm calc-cell"><?php echo e(number_format($jd->jumlah_koefisien,2)); ?></td>
                        <td class="px-3 py-2 text-sm calc-cell"><?php echo e(number_format($jd->total_mandays_penugasan,2)); ?></td>
                        <td class="px-3 py-2 text-center">
                            <button class="text-yellow-600 hover:text-yellow-800 text-sm" onclick="toggleEdit('jd<?php echo e($jd->id); ?>')">Edit</button>
                        </td>
                    </tr>
                    <tr id="jd<?php echo e($jd->id); ?>-row" style="display:none;">
                        <td colspan="8" class="p-0">
                            <form method="POST" action="<?php echo e(route('hr.kpi.update.jobdesc', [$kpiDocument->id, $jd->id])); ?>" class="p-3 bg-gray-50 border-t">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Koef. OTB</label>
                                        <input type="number" name="penilaian_koefisien_ontime_onbudget" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($jd->penilaian_koefisien_ontime_onbudget); ?>" step="0.01" min="0">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Grade Project</label>
                                        <input type="number" name="penilaian_grade_project" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($jd->penilaian_grade_project); ?>" step="0.01" min="0">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs text-gray-600 mb-1">Nama Kegiatan & Bukti</label>
                                        <input type="text" name="nama_kegiatan_bukti" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($jd->nama_kegiatan_bukti); ?>">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Mandays Proyek</label>
                                        <input type="number" name="mandays_proyek" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($jd->mandays_proyek); ?>" step="0.01" min="0">
                                    </div>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">Simpan</button>
                                    <button type="button" class="btn-secondary py-1 px-3 text-sm" onclick="toggleEdit('jd<?php echo e($jd->id); ?>')">Batal</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot class="bg-red-50">
                    <tr><td colspan="6" class="px-3 py-2 text-right font-bold text-sm">Total:</td><td class="px-3 py-2 font-bold text-sm"><?php echo e(number_format($jdTotal,2)); ?></td><td></td></tr>
                </tfoot>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <div class="tab-pane fade" id="hr-ci">
        <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Continues Improvement
        </h3>
        <?php if($kpiDocument->continuesImprovements->isEmpty()): ?>
            <p class="text-gray-400 text-center py-3">Belum ada data</p>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 subform-view-table">
                <thead class="bg-gray-50">
                    <tr><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jenis Kegiatan/Bukti</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kegiatan</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mandays</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase calc-cell">Koefisien</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase calc-cell">Point</th><th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Edit</th></tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $kpiDocument->continuesImprovements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $ci): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-3 py-2 text-sm"><?php echo e($i+1); ?></td>
                        <td class="px-3 py-2"><span class="badge badge-diproses"><?php echo e($ci->jenis_kegiatan_bukti); ?></span></td>
                        <td class="px-3 py-2 text-sm"><?php echo e($ci->kegiatan); ?></td>
                        <td class="px-3 py-2 text-sm"><?php echo e(number_format($ci->mandays,2)); ?></td>
                        <td class="px-3 py-2 text-sm calc-cell"><?php echo e(number_format($ci->koefisien,4)); ?></td>
                        <td class="px-3 py-2 text-sm calc-cell"><?php echo e(number_format($ci->point,4)); ?></td>
                        <td class="px-3 py-2 text-center">
                            <button class="text-yellow-600 hover:text-yellow-800 text-sm" onclick="toggleEdit('ci<?php echo e($ci->id); ?>')">Edit</button>
                        </td>
                    </tr>
                    <tr id="ci<?php echo e($ci->id); ?>-row" style="display:none;">
                        <td colspan="7" class="p-0">
                            <form method="POST" action="<?php echo e(route('hr.kpi.update.ci', [$kpiDocument->id, $ci->id])); ?>" class="p-3 bg-gray-50 border-t">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Jenis Kegiatan/Bukti</label>
                                        <select name="jenis_kegiatan_bukti" class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                            <?php $__currentLoopData = array_keys(\App\Models\KpiContinuesImprovement::$koefisienMap); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt); ?>" <?php echo e($ci->jenis_kegiatan_bukti===$opt?'selected':''); ?>><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs text-gray-600 mb-1">Kegiatan</label>
                                        <input type="text" name="kegiatan" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($ci->kegiatan); ?>">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Mandays</label>
                                        <input type="number" name="mandays" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($ci->mandays); ?>" step="0.01" min="0">
                                    </div>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">Simpan</button>
                                    <button type="button" class="btn-secondary py-1 px-3 text-sm" onclick="toggleEdit('ci<?php echo e($ci->id); ?>')">Batal</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot class="bg-green-50">
                    <tr><td colspan="5" class="px-3 py-2 text-right font-bold text-sm">Total Point:</td><td class="px-3 py-2 font-bold text-sm"><?php echo e(number_format($ciTotal,4)); ?></td><td></td></tr>
                </tfoot>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <div class="tab-pane fade" id="hr-sd">
        <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Self Development
        </h3>
        <?php if($kpiDocument->selfDevelopments->isEmpty()): ?>
            <p class="text-gray-400 text-center py-3">Belum ada data</p>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 subform-view-table">
                <thead class="bg-gray-50">
                    <tr><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jenis SD</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kegiatan</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mandays</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase calc-cell">Koefisien</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase calc-cell">Point</th><th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Edit</th></tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $kpiDocument->selfDevelopments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-3 py-2 text-sm"><?php echo e($i+1); ?></td>
                        <td class="px-3 py-2"><span class="badge badge-draft"><?php echo e($sd->jenis_sd); ?></span></td>
                        <td class="px-3 py-2 text-sm"><?php echo e($sd->kegiatan); ?></td>
                        <td class="px-3 py-2 text-sm"><?php echo e(number_format($sd->mandays,2)); ?></td>
                        <td class="px-3 py-2 text-sm calc-cell"><?php echo e(number_format($sd->koefisien,4)); ?></td>
                        <td class="px-3 py-2 text-sm calc-cell"><?php echo e(number_format($sd->point,4)); ?></td>
                        <td class="px-3 py-2 text-center">
                            <button class="text-yellow-600 hover:text-yellow-800 text-sm" onclick="toggleEdit('sd<?php echo e($sd->id); ?>')">Edit</button>
                        </td>
                    </tr>
                    <tr id="sd<?php echo e($sd->id); ?>-row" style="display:none;">
                        <td colspan="7" class="p-0">
                            <form method="POST" action="<?php echo e(route('hr.kpi.update.sd', [$kpiDocument->id, $sd->id])); ?>" class="p-3 bg-gray-50 border-t">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Jenis SD</label>
                                        <select name="jenis_sd" class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                            <?php $__currentLoopData = array_keys(\App\Models\KpiSelfDevelopment::$koefisienMap); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt); ?>" <?php echo e($sd->jenis_sd===$opt?'selected':''); ?>><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs text-gray-600 mb-1">Kegiatan</label>
                                        <input type="text" name="kegiatan" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($sd->kegiatan); ?>">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Mandays</label>
                                        <input type="number" name="mandays" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($sd->mandays); ?>" step="0.01" min="0">
                                    </div>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">Simpan</button>
                                    <button type="button" class="btn-secondary py-1 px-3 text-sm" onclick="toggleEdit('sd<?php echo e($sd->id); ?>')">Batal</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot class="bg-yellow-50">
                    <tr><td colspan="5" class="px-3 py-2 text-right font-bold text-sm">Total Point:</td><td class="px-3 py-2 font-bold text-sm"><?php echo e(number_format($sdTotal,4)); ?></td><td></td></tr>
                </tfoot>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <div class="tab-pane fade" id="hr-hr">
        <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            HR Activity
        </h3>
        <?php if($kpiDocument->hrActivities->isEmpty()): ?>
            <p class="text-gray-400 text-center py-3">Belum ada data</p>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 subform-view-table">
                <thead class="bg-gray-50">
                    <tr><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jenis Kegiatan</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kegiatan</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mandays</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase calc-cell">Koefisien</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase calc-cell">Point</th><th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Edit</th></tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $kpiDocument->hrActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $hr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-3 py-2 text-sm"><?php echo e($i+1); ?></td>
                        <td class="px-3 py-2"><span class="badge badge-diproses"><?php echo e($hr->jenis_kegiatan); ?></span></td>
                        <td class="px-3 py-2 text-sm"><?php echo e($hr->kegiatan); ?></td>
                        <td class="px-3 py-2 text-sm"><?php echo e(number_format($hr->mandays,2)); ?></td>
                        <td class="px-3 py-2 text-sm calc-cell"><?php echo e(number_format($hr->koefisien,4)); ?></td>
                        <td class="px-3 py-2 text-sm calc-cell"><?php echo e(number_format($hr->point,4)); ?></td>
                        <td class="px-3 py-2 text-center">
                            <button class="text-yellow-600 hover:text-yellow-800 text-sm" onclick="toggleEdit('hr<?php echo e($hr->id); ?>')">Edit</button>
                        </td>
                    </tr>
                    <tr id="hr<?php echo e($hr->id); ?>-row" style="display:none;">
                        <td colspan="7" class="p-0">
                            <form method="POST" action="<?php echo e(route('hr.kpi.update.hr_activity', [$kpiDocument->id, $hr->id])); ?>" class="p-3 bg-gray-50 border-t">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Jenis Kegiatan</label>
                                        <select name="jenis_kegiatan" class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                            <?php $__currentLoopData = array_keys(\App\Models\KpiHrActivity::$koefisienMap); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt); ?>" <?php echo e($hr->jenis_kegiatan===$opt?'selected':''); ?>><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs text-gray-600 mb-1">Kegiatan</label>
                                        <input type="text" name="kegiatan" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($hr->kegiatan); ?>">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Mandays</label>
                                        <input type="number" name="mandays" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($hr->mandays); ?>" step="0.01" min="0">
                                    </div>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">Simpan</button>
                                    <button type="button" class="btn-secondary py-1 px-3 text-sm" onclick="toggleEdit('hr<?php echo e($hr->id); ?>')">Batal</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot style="background:#ede9fe;">
                    <tr><td colspan="5" class="px-3 py-2 text-right font-bold text-sm">Total Point:</td><td class="px-3 py-2 font-bold text-sm"><?php echo e(number_format($hrTotal,4)); ?></td><td></td></tr>
                </tfoot>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <div class="tab-pane fade" id="hr-perilaku">
        <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            Kinerja Perilaku
        </h3>
        <?php if($kpiDocument->kinerjaPerilakus->isEmpty()): ?>
            <p class="text-gray-400 text-center py-3">Belum ada data</p>
        <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 subform-view-table">
                <thead class="bg-gray-50">
                    <tr><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aspek Kinerja</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Definisi</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Min. Capaian</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Indikator</th><th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th><th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Score</th><th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Edit</th></tr>
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
                        <td class="px-3 py-2 text-center">
                            <span class="font-bold text-lg <?php echo e($kp->score >= $kp->minimum_capaian ? 'text-green-600' : 'text-red-600'); ?>">
                                <?php echo e(number_format($kp->score,2)); ?>

                            </span>
                        </td>
                        <td class="px-3 py-2 text-center">
                            <?php if($kp->score >= $kp->minimum_capaian): ?>
                                <span class="badge badge-aktif">Tercapai</span>
                            <?php else: ?>
                                <span class="badge badge-dicabut">Belum</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-2 text-center">
                            <button class="text-yellow-600 hover:text-yellow-800 text-sm" onclick="toggleEdit('kp<?php echo e($kp->id); ?>')">Edit</button>
                        </td>
                    </tr>
                    <tr id="kp<?php echo e($kp->id); ?>-row" style="display:none;">
                        <td colspan="9" class="p-0">
                            <form method="POST" action="<?php echo e(route('hr.kpi.update.perilaku', [$kpiDocument->id, $kp->id])); ?>" class="p-3 bg-gray-50 border-t">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-end">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Score (0-100)</label>
                                        <input type="number" name="score" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" value="<?php echo e($kp->score); ?>" min="0" max="100" step="0.01">
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">Simpan</button>
                                        <button type="button" class="btn-secondary py-1 px-3 text-sm" onclick="toggleEdit('kp<?php echo e($kp->id); ?>')">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot class="bg-cyan-50">
                    <tr><td colspan="6" class="px-3 py-2 text-right font-bold text-sm">Total Score Perilaku:</td><td class="px-3 py-2 text-center font-bold text-lg"><?php echo e(number_format($pkTotal,2)); ?></td><td colspan="2"></td></tr>
                </tfoot>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <div class="tab-pane fade" id="hr-history">
        <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Riwayat Perubahan
        </h3>
        <?php if($kpiDocument->histories->isEmpty()): ?>
            <p class="text-gray-400 text-center py-3">Belum ada riwayat perubahan</p>
        <?php else: ?>
            <?php $__currentLoopData = $kpiDocument->histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border-l-4 mb-4 pl-4 py-2
                <?php if($hist->action === 'create'): ?> border-green-500
                <?php elseif($hist->action === 'update'): ?> border-yellow-500
                <?php elseif($hist->action === 'delete'): ?> border-red-500
                <?php elseif($hist->action === 'submit'): ?> border-blue-500
                <?php else: ?> border-gray-500 <?php endif; ?>">
                <div class="flex items-start justify-between flex-wrap gap-2 mb-1">
                    <div>
                        <span class="badge
                            <?php if($hist->action === 'create'): ?> badge-aktif
                            <?php elseif($hist->action === 'update'): ?> badge-draft
                            <?php elseif($hist->action === 'delete'): ?> badge-dicabut
                            <?php elseif($hist->action === 'submit'): ?> badge-diproses
                            <?php else: ?> badge-expired <?php endif; ?>"><?php echo e(ucfirst($hist->action)); ?></span>
                        <?php if($hist->section): ?>
                            <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded text-xs"><?php echo e($hist->section_label); ?></span>
                        <?php endif; ?>
                        <span class="text-sm text-gray-700"><?php echo e($hist->description); ?></span>
                    </div>
                    <small class="text-gray-500"><?php echo e($hist->created_at->format('d M Y H:i')); ?></small>
                </div>
                <small class="text-gray-500">
                    Oleh: <strong><?php echo e($hist->changedBy->name); ?></strong> (<?php echo e($hist->changedBy->role_label); ?>)
                </small>
                <?php if($hist->old_data && $hist->action === 'update'): ?>
                <div class="mt-1">
                    <a class="text-blue-600 hover:underline text-xs" data-bs-toggle="collapse" href="#hd<?php echo e($hist->id); ?>">Lihat Detail</a>
                    <div class="collapse mt-2" id="hd<?php echo e($hist->id); ?>">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <div>
                                <small class="text-gray-500 font-semibold d-block mb-1">Sebelum:</small>
                                <pre class="bg-gray-50 rounded p-2 text-xs" style="max-height:150px;overflow:auto;"><?php echo e(json_encode($hist->old_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)); ?></pre>
                            </div>
                            <div>
                                <small class="text-gray-500 font-semibold d-block mb-1">Sesudah:</small>
                                <pre class="bg-gray-50 rounded p-2 text-xs" style="max-height:150px;overflow:auto;"><?php echo e(json_encode($hist->new_data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)); ?></pre>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function toggleEdit(id) {
    const row = document.getElementById(id + '-row');
    if (row) {
        row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/hr/show.blade.php ENDPATH**/ ?>