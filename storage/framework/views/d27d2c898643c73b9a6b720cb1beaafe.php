<?php
    $jenis    = $row->jenis_kegiatan ?? (string) old("hr.$index.jenis_kegiatan", '');
    $kegiatan = $row->kegiatan       ?? (string) old("hr.$index.kegiatan", '');
    $mandays  = $row->mandays        ?? (string) old("hr.$index.mandays", 0);
    $koef     = $row->koefisien      ?? 0;
    $point    = $row->point          ?? 0;

    $jenis    = is_array($jenis)    ? '' : $jenis;
    $kegiatan = is_array($kegiatan) ? '' : $kegiatan;
    $mandays  = is_array($mandays)  ? 0  : $mandays;
?>
<td><?php echo e($index + 1); ?></td>
<td>
    <select name="hr[<?php echo e($index); ?>][jenis_kegiatan]"
            class="form-select hr-jenis"
            onchange="calcHRRow(this.closest('tr'))">
        <option value="">-- Pilih Jenis Kegiatan --</option>
        <?php $__currentLoopData = $hrOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($opt); ?>" <?php echo e($jenis === $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</td>
<td>
    <input type="text"
           name="hr[<?php echo e($index); ?>][kegiatan]"
           class="form-control"
           placeholder="Nama kegiatan..."
           value="<?php echo e($kegiatan); ?>">
</td>
<td>
    <input type="number"
           name="hr[<?php echo e($index); ?>][mandays]"
           class="form-control hr-mandays"
           min="0" step="0.01"
           value="<?php echo e(number_format((float)$mandays, 2, '.', '')); ?>"
           oninput="calcHRRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           class="form-control calc-field hr-koef"
           value="<?php echo e(number_format((float)$koef, 4, '.', '')); ?>"
           readonly tabindex="-1">
</td>
<td>
    <input type="text"
           class="form-control calc-field hr-point"
           value="<?php echo e(number_format((float)$point, 4, '.', '')); ?>"
           readonly tabindex="-1">
</td>
<td>
    <button type="button" class="btn btn-sm btn-outline-danger"
            onclick="this.closest('tr').remove(); updateHRTotal();">
        <i class="bi bi-trash3"></i>
    </button>
</td><?php /**PATH D:\New folder (20)\kpi-system\resources\views/kpi/partials/hr_row.blade.php ENDPATH**/ ?>