<?php
    $jenis   = $row->jenis_sd  ?? old("sd.$index.jenis_sd", '');
    $kegiatan= $row->kegiatan  ?? old("sd.$index.kegiatan", '');
    $mandays = $row->mandays   ?? old("sd.$index.mandays", 0);
    $koef    = $row->koefisien ?? 0;
    $point   = $row->point     ?? 0;
?>
<td class="px-3 py-2 text-sm text-gray-500"><?php echo e($index + 1); ?></td>
<td>
    <select name="sd[<?php echo e($index); ?>][jenis_sd]"
            class="form-input sd-jenis"
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
           class="form-input"
           placeholder="Nama kegiatan..."
           value="<?php echo e($kegiatan); ?>">
</td>
<td>
    <input type="number"
           name="sd[<?php echo e($index); ?>][mandays]"
           class="form-input sd-mandays"
           min="0" step="0.01"
           value="<?php echo e(number_format((float)$mandays, 2, '.', '')); ?>"
           oninput="calcSDRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           class="form-input calc-field sd-koef"
           value="<?php echo e(number_format((float)$koef, 4, '.', '')); ?>"
           readonly tabindex="-1"
           style="background:#fefce8 !important;color:#ca8a04;font-weight:600;">
</td>
<td>
    <input type="text"
           class="form-input calc-field sd-point"
           value="<?php echo e(number_format((float)$point, 4, '.', '')); ?>"
           readonly tabindex="-1"
           style="background:#fefce8 !important;color:#ca8a04;font-weight:600;">
</td>
<td>
    <button type="button" class="px-2 py-1 text-xs text-red-600 hover:bg-red-50 rounded border border-red-200"
            onclick="this.closest('tr').remove(); updateSDTotal();">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
    </button>
</td>
<?php /**PATH D:\New folder (20)\New folder\sistemkpi-tlab\resources\views/kpi/partials/sd_row.blade.php ENDPATH**/ ?>