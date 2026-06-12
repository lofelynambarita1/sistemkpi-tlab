<?php
    $otb     = $row->penilaian_koefisien_ontime_onbudget ?? (string) old("jobdesc.$index.penilaian_koefisien_ontime_onbudget", 0);
    $grade   = $row->penilaian_grade_project              ?? (string) old("jobdesc.$index.penilaian_grade_project", 0);
    $nama    = $row->nama_kegiatan_bukti                  ?? (string) old("jobdesc.$index.nama_kegiatan_bukti", '');
    $mandays = $row->mandays_proyek                        ?? (string) old("jobdesc.$index.mandays_proyek", 0);
    $jumlah  = $row->jumlah_koefisien                     ?? ((float)$otb + (float)$grade);
    $total   = $row->total_mandays_penugasan              ?? ((float)$jumlah * (float)$mandays);
?>
<td><?php echo e($index + 1); ?></td>
<td>
    <input type="number"
           name="jobdesc[<?php echo e($index); ?>][penilaian_koefisien_ontime_onbudget]"
           class="form-control jd-otb"
           min="0" step="0.01"
           value="<?php echo e(number_format((float)$otb, 2, '.', '')); ?>"
           oninput="calcJobdescRow(this.closest('tr'))">
</td>
<td>
    <input type="number"
           name="jobdesc[<?php echo e($index); ?>][penilaian_grade_project]"
           class="form-control jd-grade"
           min="0" step="0.01"
           value="<?php echo e(number_format((float)$grade, 2, '.', '')); ?>"
           oninput="calcJobdescRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           name="jobdesc[<?php echo e($index); ?>][nama_kegiatan_bukti]"
           class="form-control"
           placeholder="Nama kegiatan & bukti..."
           value="<?php echo e(is_array($nama) ? '' : $nama); ?>">
</td>
<td>
    <input type="number"
           name="jobdesc[<?php echo e($index); ?>][mandays_proyek]"
           class="form-control jd-mandays"
           min="0" step="0.01"
           value="<?php echo e(number_format((float)$mandays, 2, '.', '')); ?>"
           oninput="calcJobdescRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           class="form-control calc-field jd-jumlah"
           value="<?php echo e(number_format((float)$jumlah, 2, '.', '')); ?>"
           readonly tabindex="-1">
</td>
<td>
    <input type="text"
           class="form-control calc-field jd-total"
           value="<?php echo e(number_format((float)$total, 2, '.', '')); ?>"
           readonly tabindex="-1">
</td>
<td>
    <button type="button" class="btn btn-sm btn-outline-danger"
            onclick="this.closest('tr').remove(); updateJobdescTotal();">
        <i class="bi bi-trash3"></i>
    </button>
</td><?php /**PATH D:\New folder (20)\kpi-system\resources\views/kpi/partials/jobdesc_row.blade.php ENDPATH**/ ?>