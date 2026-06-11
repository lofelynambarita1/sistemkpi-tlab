@php
    $otb     = $row->penilaian_koefisien_ontime_onbudget ?? old("jobdesc.$index.penilaian_koefisien_ontime_onbudget", 0);
    $grade   = $row->penilaian_grade_project              ?? old("jobdesc.$index.penilaian_grade_project", 0);
    $nama    = $row->nama_kegiatan_bukti                  ?? old("jobdesc.$index.nama_kegiatan_bukti", '');
    $mandays = $row->mandays_proyek                        ?? old("jobdesc.$index.mandays_proyek", 0);
    $jumlah  = $row->jumlah_koefisien                     ?? ($otb + $grade);
    $total   = $row->total_mandays_penugasan              ?? ($jumlah * $mandays);
@endphp
<td>{{ $index + 1 }}</td>
<td>
    <input type="number"
           name="jobdesc[{{ $index }}][penilaian_koefisien_ontime_onbudget]"
           class="form-control jd-otb"
           min="0" step="0.01"
           value="{{ number_format((float)$otb, 2, '.', '') }}"
           oninput="calcJobdescRow(this.closest('tr'))">
</td>
<td>
    <input type="number"
           name="jobdesc[{{ $index }}][penilaian_grade_project]"
           class="form-control jd-grade"
           min="0" step="0.01"
           value="{{ number_format((float)$grade, 2, '.', '') }}"
           oninput="calcJobdescRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           name="jobdesc[{{ $index }}][nama_kegiatan_bukti]"
           class="form-control"
           placeholder="Nama kegiatan & bukti..."
           value="{{ $nama }}">
</td>
<td>
    <input type="number"
           name="jobdesc[{{ $index }}][mandays_proyek]"
           class="form-control jd-mandays"
           min="0" step="0.01"
           value="{{ number_format((float)$mandays, 2, '.', '') }}"
           oninput="calcJobdescRow(this.closest('tr'))">
</td>
<td>
    <input type="text"
           class="form-control calc-field jd-jumlah"
           value="{{ number_format((float)$jumlah, 2, '.', '') }}"
           readonly tabindex="-1">
</td>
<td>
    <input type="text"
           class="form-control calc-field jd-total"
           value="{{ number_format((float)$total, 2, '.', '') }}"
           readonly tabindex="-1">
</td>
<td>
    @if($index > 0 || ($row !== null))
        <button type="button" class="btn btn-sm btn-outline-danger"
                onclick="this.closest('tr').remove(); updateJobdescTotal();">
            <i class="bi bi-trash3"></i>
        </button>
    @else
        <button type="button" class="btn btn-sm btn-outline-danger"
                onclick="this.closest('tr').remove(); updateJobdescTotal();">
            <i class="bi bi-trash3"></i>
        </button>
    @endif
</td>
