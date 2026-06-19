@php
    $jenis   = $row->jenis_kegiatan ?? old("hr.$index.jenis_kegiatan", '');
    $kegiatan= $row->kegiatan       ?? old("hr.$index.kegiatan", '');
    $mandays = $row->mandays        ?? old("hr.$index.mandays", 0);
    $koef    = $row->koefisien      ?? 0;
    $point   = $row->point          ?? 0;
@endphp
<td class="px-3 py-2 text-sm text-gray-500">{{ $index + 1 }}</td>
<td>
    <select name="hr[{{ $index }}][jenis_kegiatan]"
            class="form-input hr-jenis"
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
           class="form-input"
           placeholder="Nama kegiatan..."
           value="{{ $kegiatan }}">
</td>
<td>
    <input type="number"
           name="hr[{{ $index }}][mandays]"
           class="form-input hr-mandays"
           min="0" step="0.01"
           value="{{ number_format((float)$mandays, 2, '.', '') }}"
           oninput="calcHRRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           class="form-input calc-field hr-koef"
           value="{{ number_format((float)$koef, 4, '.', '') }}"
           readonly tabindex="-1"
           style="background:#f5f3ff !important;color:#7c3aed;font-weight:600;">
</td>
<td>
    <input type="text"
           class="form-input calc-field hr-point"
           value="{{ number_format((float)$point, 4, '.', '') }}"
           readonly tabindex="-1"
           style="background:#f5f3ff !important;color:#7c3aed;font-weight:600;">
</td>
<td>
    <button type="button" class="px-2 py-1 text-xs text-red-600 hover:bg-red-50 rounded border border-red-200"
            onclick="this.closest('tr').remove(); updateHRTotal();">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
    </button>
</td>
