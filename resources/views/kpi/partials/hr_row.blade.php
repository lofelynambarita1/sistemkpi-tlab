@php
    $jenis   = $row->jenis_kegiatan ?? old("hr.$index.jenis_kegiatan", '');
    $kegiatan= $row->kegiatan       ?? old("hr.$index.kegiatan", '');
    $mandays = $row->mandays        ?? old("hr.$index.mandays", 0);
    $koef    = $row->koefisien      ?? 0;
    $point   = $row->point          ?? 0;
@endphp
<td>{{ $index + 1 }}</td>
<td>
    <select name="hr[{{ $index }}][jenis_kegiatan]"
            class="form-select hr-jenis"
            onchange="calcHRRow(this.closest('tr'))">
        <option value="">-- Pilih Jenis Kegiatan --</option>
        @foreach($hrOptions as $opt)
            <option value="{{ $opt }}" {{ $jenis === $opt ? 'selected' : '' }}>{{ $opt }}</option>
        @endforeach
    </select>
</td>
<td>
    <input type="text"
           name="hr[{{ $index }}][kegiatan]"
           class="form-control"
           placeholder="Nama kegiatan..."
           value="{{ $kegiatan }}">
</td>
<td>
    <input type="number"
           name="hr[{{ $index }}][mandays]"
           class="form-control hr-mandays"
           min="0" step="0.01"
           value="{{ number_format((float)$mandays, 2, '.', '') }}"
           oninput="calcHRRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           class="form-control calc-field hr-koef"
           value="{{ number_format((float)$koef, 4, '.', '') }}"
           readonly tabindex="-1">
</td>
<td>
    <input type="text"
           class="form-control calc-field hr-point"
           value="{{ number_format((float)$point, 4, '.', '') }}"
           readonly tabindex="-1">
</td>
<td>
    <button type="button" class="btn btn-sm btn-outline-danger"
            onclick="this.closest('tr').remove(); updateHRTotal();">
        <i class="bi bi-trash3"></i>
    </button>
</td>
