<?php
    $jenis    = $row->jenis_sd  ?? (string) old("sd.$index.jenis_sd", '');
    $kegiatan = $row->kegiatan  ?? (string) old("sd.$index.kegiatan", '');
    $mandays  = $row->mandays   ?? (string) old("sd.$index.mandays", 0);
    $koef     = $row->koefisien ?? 0;
    $point    = $row->point     ?? 0;

    $jenis    = is_array($jenis)    ? '' : $jenis;
    $kegiatan = is_array($kegiatan) ? '' : $kegiatan;
    $mandays  = is_array($mandays)  ? 0  : $mandays;
?>
<td><?php echo e($index + 1); ?></td>
<td>
    <select name="sd[<?php echo e($index); ?>][jenis_sd]"
            class="form-select sd-jenis"
            onchange="calcSDRow(this.closest('tr'))">
        <option value="">-- Pilih Jenis SD --</option>
        <?php $__currentLoopData = $sdOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($opt); ?>" <?php echo e($jenis === $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</td>
<td>
    <input type="text"
           name="sd[<?php echo e($index); ?>][kegiatan]"
           class="form-control"
           placeholder="Nama kegiatan..."
           value="<?php echo e($kegiatan); ?>">
</td>
<td>
    <input type="number"
           name="sd[<?php echo e($index); ?>][mandays]"
           class="form-control sd-mandays"
           min="0" step="0.01"
           value="<?php echo e(number_format((float)$mandays, 2, '.', '')); ?>"
           oninput="calcSDRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           class="form-control calc-field sd-koef"
           value="<?php echo e(number_format((float)$koef, 4, '.', '')); ?>"
           readonly tabindex="-1">
</td>
<td>
    <input type="text"
           class="form-control calc-field sd-point"
           value="<?php echo e(number_format((float)$point, 4, '.', '')); ?>"
           readonly tabindex="-1">
</td>
<td>
    <button type="button" class="btn btn-sm btn-outline-danger"
            onclick="this.closest('tr').remove(); updateSDTotal();">
        <i class="bi bi-trash3"></i>
    </button>
</td><?php /**PATH D:\New folder (20)\kpi-system\resources\views/kpi/partials/sd_row.blade.php ENDPATH**/ ?>