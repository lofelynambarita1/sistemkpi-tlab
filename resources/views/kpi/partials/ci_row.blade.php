@php
    $jenis   = $row->jenis_kegiatan_bukti ?? old("ci.$index.jenis_kegiatan_bukti", '');
    $kegiatan= $row->kegiatan             ?? old("ci.$index.kegiatan", '');
    $mandays = $row->mandays              ?? old("ci.$index.mandays", 0);
    $koef    = $row->koefisien            ?? 0;
    $point   = $row->point               ?? 0;
@endphp
<td>{{ $index + 1 }}</td>
<td>
    <select name="ci[{{ $index }}][jenis_kegiatan_bukti]"
            class="form-select ci-jenis"
            onchange="calcCIRow(this.closest('tr'))">
        <option value="">-- Pilih Jenis --</option>
        @foreach($ciOptions as $opt)
            <option value="{{ $opt }}" {{ $jenis === $opt ? 'selected' : '' }}>{{ $opt }}</option>
        @endforeach
    </select>
</td>
<td>
    <input type="text"
           name="ci[{{ $index }}][kegiatan]"
           class="form-control"
           placeholder="Nama kegiatan..."
           value="{{ $kegiatan }}">
</td>
<td>
    <input type="number"
           name="ci[{{ $index }}][mandays]"
           class="form-control ci-mandays"
           min="0" step="0.01"
           value="{{ number_format((float)$mandays, 2, '.', '') }}"
           oninput="calcCIRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           class="form-control calc-field ci-koef"
           value="{{ number_format((float)$koef, 4, '.', '') }}"
           readonly tabindex="-1">
</td>
<td>
    <input type="text"
           class="form-control calc-field ci-point"
           value="{{ number_format((float)$point, 4, '.', '') }}"
           readonly tabindex="-1">
</td>
<td>
    <button type="button" class="btn btn-sm btn-outline-danger"
            onclick="this.closest('tr').remove(); updateCITotal();">
        <i class="bi bi-trash3"></i>
    </button>
</td>
