@php
    $jenis   = $row->jenis_sd  ?? old("sd.$index.jenis_sd", '');
    $kegiatan= $row->kegiatan  ?? old("sd.$index.kegiatan", '');
    $mandays = $row->mandays   ?? old("sd.$index.mandays", 0);
    $koef    = $row->koefisien ?? 0;
    $point   = $row->point     ?? 0;
@endphp
<td>{{ $index + 1 }}</td>
<td>
    <select name="sd[{{ $index }}][jenis_sd]"
            class="form-select sd-jenis"
            onchange="calcSDRow(this.closest('tr'))">
        <option value="">-- Pilih Jenis SD --</option>
        @foreach($sdOptions as $opt)
            <option value="{{ $opt }}" {{ $jenis === $opt ? 'selected' : '' }}>{{ $opt }}</option>
        @endforeach
    </select>
</td>
<td>
    <input type="text"
           name="sd[{{ $index }}][kegiatan]"
           class="form-control"
           placeholder="Nama kegiatan..."
           value="{{ $kegiatan }}">
</td>
<td>
    <input type="number"
           name="sd[{{ $index }}][mandays]"
           class="form-control sd-mandays"
           min="0" step="0.01"
           value="{{ number_format((float)$mandays, 2, '.', '') }}"
           oninput="calcSDRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           class="form-control calc-field sd-koef"
           value="{{ number_format((float)$koef, 4, '.', '') }}"
           readonly tabindex="-1">
</td>
<td>
    <input type="text"
           class="form-control calc-field sd-point"
           value="{{ number_format((float)$point, 4, '.', '') }}"
           readonly tabindex="-1">
</td>
<td>
    <button type="button" class="btn btn-sm btn-outline-danger"
            onclick="this.closest('tr').remove(); updateSDTotal();">
        <i class="bi bi-trash3"></i>
    </button>
</td>
