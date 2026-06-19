@php
    $jenis   = $row->jenis_kegiatan_bukti ?? old("ci.$index.jenis_kegiatan_bukti", '');
    $kegiatan= $row->kegiatan             ?? old("ci.$index.kegiatan", '');
    $mandays = $row->mandays              ?? old("ci.$index.mandays", 0);
    $koef    = $row->koefisien            ?? 0;
    $point   = $row->point               ?? 0;
@endphp
<td class="px-3 py-2 text-sm text-gray-500">{{ $index + 1 }}</td>
<td>
    <select name="ci[{{ $index }}][jenis_kegiatan_bukti]"
            class="form-input ci-jenis"
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
           class="form-input"
           placeholder="Nama kegiatan..."
           value="{{ $kegiatan }}">
</td>
<td>
    <input type="number"
           name="ci[{{ $index }}][mandays]"
           class="form-input ci-mandays"
           min="0" step="0.01"
           value="{{ number_format((float)$mandays, 2, '.', '') }}"
           oninput="calcCIRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           class="form-input calc-field ci-koef"
           value="{{ number_format((float)$koef, 4, '.', '') }}"
           readonly tabindex="-1"
           style="background:#f0fdf4 !important;color:#16a34a;font-weight:600;">
</td>
<td>
    <input type="text"
           class="form-input calc-field ci-point"
           value="{{ number_format((float)$point, 4, '.', '') }}"
           readonly tabindex="-1"
           style="background:#f0fdf4 !important;color:#16a34a;font-weight:600;">
</td>
<td>
    <button type="button" class="px-2 py-1 text-xs text-red-600 hover:bg-red-50 rounded border border-red-200"
            onclick="this.closest('tr').remove(); updateCITotal();">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
    </button>
</td>
