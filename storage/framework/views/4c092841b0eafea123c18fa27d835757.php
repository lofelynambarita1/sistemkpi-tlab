<?php
    $otb     = $row->penilaian_koefisien_ontime_onbudget ?? old("jobdesc.$index.penilaian_koefisien_ontime_onbudget", 0);
    $grade   = $row->penilaian_grade_project              ?? old("jobdesc.$index.penilaian_grade_project", 0);
    $nama    = $row->nama_kegiatan_bukti                  ?? old("jobdesc.$index.nama_kegiatan_bukti", '');
    $mandays = $row->mandays_proyek                        ?? old("jobdesc.$index.mandays_proyek", 0);
    $jumlah  = $row->jumlah_koefisien                     ?? ($otb + $grade);
    $total   = $row->total_mandays_penugasan              ?? ($jumlah * $mandays);
?>
<td class="px-3 py-2 text-sm text-gray-500"><?php echo e($index + 1); ?></td>
<td>
    <input type="number"
           name="jobdesc[<?php echo e($index); ?>][penilaian_koefisien_ontime_onbudget]"
           class="form-input jd-otb"
           min="0" step="0.01"
           value="<?php echo e(number_format((float)$otb, 2, '.', '')); ?>"
           oninput="calcJobdescRow(this.closest('tr'))">
</td>
<td>
    <input type="number"
           name="jobdesc[<?php echo e($index); ?>][penilaian_grade_project]"
           class="form-input jd-grade"
           min="0" step="0.01"
           value="<?php echo e(number_format((float)$grade, 2, '.', '')); ?>"
           oninput="calcJobdescRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           name="jobdesc[<?php echo e($index); ?>][nama_kegiatan_bukti]"
           class="form-input"
           placeholder="Nama kegiatan & bukti..."
           value="<?php echo e($nama); ?>">
</td>
<td>
    <input type="number"
           name="jobdesc[<?php echo e($index); ?>][mandays_proyek]"
           class="form-input jd-mandays"
           min="0" step="0.01"
           value="<?php echo e(number_format((float)$mandays, 2, '.', '')); ?>"
           oninput="calcJobdescRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           class="form-input calc-field jd-jumlah"
           value="<?php echo e(number_format((float)$jumlah, 2, '.', '')); ?>"
           readonly tabindex="-1"
           style="background:#eff6ff !important;color:#2563eb;font-weight:600;">
</td>
<td>
    <input type="text"
           class="form-input calc-field jd-total"
           value="<?php echo e(number_format((float)$total, 2, '.', '')); ?>"
           readonly tabindex="-1"
           style="background:#eff6ff !important;color:#2563eb;font-weight:600;">
</td>
<td>
    <button type="button" class="px-2 py-1 text-xs text-red-600 hover:bg-red-50 rounded border border-red-200"
            onclick="this.closest('tr').remove(); updateJobdescTotal();">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
    </button>
</td>
<?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/kpi/partials/jobdesc_row.blade.php ENDPATH**/ ?>