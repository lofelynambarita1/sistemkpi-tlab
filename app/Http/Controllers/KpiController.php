<?php

namespace App\Http\Controllers;

use App\Models\KpiDocument;
use App\Models\KpiDocumentHistory;
use App\Models\KpiJobdesc;
use App\Models\KpiContinuesImprovement;
use App\Models\KpiSelfDevelopment;
use App\Models\KpiHrActivity;
use App\Models\KpiKinerjaPerilaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KpiController extends Controller
{
    /**
     * List semua dokumen KPI milik user yang login
     */
    public function index()
    {
        $user      = Auth::user();
        $documents = KpiDocument::where('user_id', $user->id)
            ->orderBy('period_year', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('kpi.index', compact('documents', 'user'));
    }

    /**
     * Form buat dokumen KPI baru
     */
    public function create()
    {
        $user = Auth::user();
        $year = date('Y');

        $masterPerilaku = KpiKinerjaPerilaku::getMasterData();
        $ciOptions      = array_keys(KpiContinuesImprovement::$koefisienMap);
        $sdOptions      = array_keys(KpiSelfDevelopment::$koefisienMap);
        $hrOptions      = array_keys(KpiHrActivity::$koefisienMap);

        return view('kpi.create', compact('user', 'year', 'masterPerilaku', 'ciOptions', 'sdOptions', 'hrOptions'));
    }

    /**
     * Simpan dokumen KPI baru
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'period_year' => 'required|integer|min:2020|max:2099',
            'action'      => 'required|in:draft,submit',
        ]);

        DB::beginTransaction();
        try {
            $doc = KpiDocument::create([
                'user_id'     => $user->id,
                'period_year' => $request->period_year,
                'status'      => 'draft',
                'notes'       => $request->notes,
            ]);

            $this->saveSubforms($doc, $request);

            if ($request->action === 'submit') {
                $doc->status       = 'submitted';
                $doc->submitted_at = now();
                $doc->save();

                KpiDocumentHistory::create([
                    'kpi_document_id' => $doc->id,
                    'changed_by'      => $user->id,
                    'action'          => 'submit',
                    'section'         => 'document',
                    'description'     => 'Dokumen KPI disubmit oleh ' . $user->name,
                ]);
            } else {
                KpiDocumentHistory::create([
                    'kpi_document_id' => $doc->id,
                    'changed_by'      => $user->id,
                    'action'          => 'create',
                    'section'         => 'document',
                    'description'     => 'Dokumen KPI dibuat (draft) oleh ' . $user->name,
                ]);
            }

            $doc->recalculateTotalScore();
            DB::commit();

            $msg = $request->action === 'submit' ? 'Dokumen KPI berhasil disubmit!' : 'Dokumen KPI disimpan sebagai draft!';
            return redirect()->route('kpi.show', $doc->id)->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan dokumen KPI
     */
    public function show(KpiDocument $kpiDocument)
    {
        $user = Auth::user();

        // Staff hanya bisa lihat dokumen miliknya sendiri
        if ($user->isStaff() && $kpiDocument->user_id !== $user->id) {
            abort(403, 'Tidak diizinkan.');
        }

        $kpiDocument->load([
            'user', 'jobdescs', 'continuesImprovements',
            'selfDevelopments', 'hrActivities', 'kinerjaPerilakus',
            'histories.changedBy',
        ]);

        return view('kpi.show', compact('kpiDocument', 'user'));
    }

    /**
     * Form edit dokumen KPI (hanya draft)
     */
    public function edit(KpiDocument $kpiDocument)
    {
        $user = Auth::user();

        if ($user->isStaff() && $kpiDocument->user_id !== $user->id) {
            abort(403, 'Tidak diizinkan.');
        }

        if ($user->isStaff() && $kpiDocument->status !== 'draft') {
            return back()->with('error', 'Hanya dokumen berstatus draft yang dapat diedit.');
        }

        $kpiDocument->load([
            'jobdescs', 'continuesImprovements',
            'selfDevelopments', 'hrActivities', 'kinerjaPerilakus',
        ]);

        $masterPerilaku = KpiKinerjaPerilaku::getMasterData();
        $ciOptions      = array_keys(KpiContinuesImprovement::$koefisienMap);
        $sdOptions      = array_keys(KpiSelfDevelopment::$koefisienMap);
        $hrOptions      = array_keys(KpiHrActivity::$koefisienMap);

        return view('kpi.edit', compact('kpiDocument', 'user', 'masterPerilaku', 'ciOptions', 'sdOptions', 'hrOptions'));
    }

    /**
     * Update dokumen KPI
     */
    public function update(Request $request, KpiDocument $kpiDocument)
    {
        $user = Auth::user();

        if ($user->isStaff() && $kpiDocument->user_id !== $user->id) {
            abort(403, 'Tidak diizinkan.');
        }

        if ($user->isStaff() && $kpiDocument->status !== 'draft') {
            return back()->with('error', 'Hanya dokumen berstatus draft yang dapat diedit.');
        }

        $request->validate([
            'action' => 'required|in:draft,submit',
        ]);

        DB::beginTransaction();
        try {
            $oldData = $kpiDocument->only(['status', 'notes', 'total_score']);

            // Hapus subform lama dan buat ulang
            $kpiDocument->jobdescs()->delete();
            $kpiDocument->continuesImprovements()->delete();
            $kpiDocument->selfDevelopments()->delete();
            $kpiDocument->hrActivities()->delete();
            $kpiDocument->kinerjaPerilakus()->delete();

            $kpiDocument->notes = $request->notes;

            if ($request->action === 'submit') {
                $kpiDocument->status       = 'submitted';
                $kpiDocument->submitted_at = now();
            }

            $this->saveSubforms($kpiDocument, $request);
            $kpiDocument->recalculateTotalScore();
            $kpiDocument->save();

            KpiDocumentHistory::create([
                'kpi_document_id' => $kpiDocument->id,
                'changed_by'      => $user->id,
                'action'          => $request->action === 'submit' ? 'submit' : 'update',
                'section'         => 'document',
                'old_data'        => $oldData,
                'new_data'        => $kpiDocument->only(['status', 'notes', 'total_score']),
                'description'     => 'Dokumen KPI diperbarui oleh ' . $user->name . ($request->action === 'submit' ? ' dan disubmit' : ''),
            ]);

            DB::commit();

            $msg = $request->action === 'submit' ? 'Dokumen KPI berhasil disubmit!' : 'Dokumen KPI berhasil diperbarui!';
            return redirect()->route('kpi.show', $kpiDocument->id)->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Helper: Simpan semua subform dari request
     */
    private function saveSubforms(KpiDocument $doc, Request $request): void
    {
        // === JOBDESC ===
        $jobdescs = $request->input('jobdesc', []);
        foreach ($jobdescs as $i => $row) {
            if (empty($row['nama_kegiatan_bukti']) && empty($row['mandays_proyek'])) continue;

            $jd = new KpiJobdesc();
            $jd->kpi_document_id                      = $doc->id;
            $jd->penilaian_koefisien_ontime_onbudget  = (float)($row['penilaian_koefisien_ontime_onbudget'] ?? 0);
            $jd->penilaian_grade_project               = (float)($row['penilaian_grade_project'] ?? 0);
            $jd->nama_kegiatan_bukti                   = $row['nama_kegiatan_bukti'] ?? '';
            $jd->mandays_proyek                        = (float)($row['mandays_proyek'] ?? 0);
            $jd->row_order                             = $i;
            $jd->recalculate();
            $jd->save();
        }

        // === CONTINUES IMPROVEMENT ===
        $cis = $request->input('ci', []);
        foreach ($cis as $i => $row) {
            if (empty($row['kegiatan'])) continue;

            $ci = new KpiContinuesImprovement();
            $ci->kpi_document_id    = $doc->id;
            $ci->jenis_kegiatan_bukti = $row['jenis_kegiatan_bukti'] ?? 'Lainnya';
            $ci->kegiatan           = $row['kegiatan'] ?? '';
            $ci->mandays            = (float)($row['mandays'] ?? 0);
            $ci->row_order          = $i;
            $ci->recalculate();
            $ci->save();
        }

        // === SELF DEVELOPMENT ===
        $sds = $request->input('sd', []);
        foreach ($sds as $i => $row) {
            if (empty($row['kegiatan'])) continue;

            $sd = new KpiSelfDevelopment();
            $sd->kpi_document_id = $doc->id;
            $sd->jenis_sd        = $row['jenis_sd'] ?? 'Lainnya';
            $sd->kegiatan        = $row['kegiatan'] ?? '';
            $sd->mandays         = (float)($row['mandays'] ?? 0);
            $sd->row_order       = $i;
            $sd->recalculate();
            $sd->save();
        }

        // === HR ACTIVITY ===
        $hrs = $request->input('hr', []);
        foreach ($hrs as $i => $row) {
            if (empty($row['kegiatan'])) continue;

            $hr = new KpiHrActivity();
            $hr->kpi_document_id = $doc->id;
            $hr->jenis_kegiatan  = $row['jenis_kegiatan'] ?? 'Lainnya';
            $hr->kegiatan        = $row['kegiatan'] ?? '';
            $hr->mandays         = (float)($row['mandays'] ?? 0);
            $hr->row_order       = $i;
            $hr->recalculate();
            $hr->save();
        }

        // === KINERJA PERILAKU ===
        $masterData = KpiKinerjaPerilaku::getMasterData();
        $perilakuScores = $request->input('perilaku', []);
        foreach ($masterData as $i => $master) {
            $kp = new KpiKinerjaPerilaku();
            $kp->kpi_document_id = $doc->id;
            $kp->score           = (float)($perilakuScores[$i]['score'] ?? 0);
            $kp->aspek_kinerja   = $master['aspek_kinerja'];
            $kp->definisi        = $master['definisi'];
            $kp->minimum_capaian = $master['minimum_capaian'];
            $kp->indikator       = $master['indikator'];
            $kp->deskripsi       = $master['deskripsi'];
            $kp->row_order       = $i;
            $kp->save();
        }
    }
}
