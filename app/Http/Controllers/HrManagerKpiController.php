<?php

namespace App\Http\Controllers;

use App\Models\KpiDocument;
use App\Models\KpiDocumentHistory;
use App\Models\KpiJobdesc;
use App\Models\KpiContinuesImprovement;
use App\Models\KpiSelfDevelopment;
use App\Models\KpiHrActivity;
use App\Models\KpiKinerjaPerilaku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HrManagerKpiController extends Controller
{
    // __construct() dihapus — di Laravel 11 middleware di constructor tidak didukung.
    // Middleware 'hr.manager.only' sudah diterapkan di routes/web.php.

    /**
     * List semua dokumen KPI staff
     */
    public function index(Request $request)
    {
        $user  = Auth::user();
        $query = KpiDocument::with(['user'])
            ->whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle']));

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('role')) {
            $query->whereHas('user', fn($q) => $q->where('role', $request->role));
        }
        if ($request->filled('year')) {
            $query->where('period_year', $request->year);
        }
        if ($request->filled('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        $documents = $query->orderBy('updated_at', 'desc')->paginate(15)->withQueryString();
        $years     = KpiDocument::distinct()->pluck('period_year')->sort()->values();

        return view('hr.index', compact('documents', 'user', 'years'));
    }

    /**
     * Tampilkan detail dokumen KPI staff
     */
    public function show(KpiDocument $kpiDocument)
    {
        $user = Auth::user();
        $kpiDocument->load([
            'user', 'jobdescs', 'continuesImprovements',
            'selfDevelopments', 'hrActivities', 'kinerjaPerilakus',
            'histories.changedBy',
        ]);

        return view('hr.show', compact('kpiDocument', 'user'));
    }

    /**
     * Form edit dokumen KPI staff
     */
    public function edit(KpiDocument $kpiDocument)
    {
        $user = Auth::user();
        $kpiDocument->load([
            'jobdescs', 'continuesImprovements',
            'selfDevelopments', 'hrActivities', 'kinerjaPerilakus',
        ]);

        $ciOptions = array_keys(KpiContinuesImprovement::$koefisienMap);
        $sdOptions = array_keys(KpiSelfDevelopment::$koefisienMap);
        $hrOptions = array_keys(KpiHrActivity::$koefisienMap);

        return view('hr.edit', compact('kpiDocument', 'user', 'ciOptions', 'sdOptions', 'hrOptions'));
    }

    /**
     * Update dokumen KPI staff oleh HR/Manager
     */
    public function update(Request $request, KpiDocument $kpiDocument)
    {
        $user = Auth::user();

        $request->validate([
            'status' => 'required|in:submitted,reviewed,approved',
            'notes'  => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $oldData = $kpiDocument->only(['status', 'notes', 'total_score']);
            $changes = [];

            if ($kpiDocument->status !== $request->status) {
                $changes['status'] = ['from' => $kpiDocument->status, 'to' => $request->status];
                $kpiDocument->status = $request->status;
            }

            if ($kpiDocument->notes !== $request->notes) {
                $changes['notes'] = ['from' => $kpiDocument->notes, 'to' => $request->notes];
                $kpiDocument->notes = $request->notes;
            }

            if ($request->has('jobdesc')) {
                foreach ($request->input('jobdesc', []) as $id => $row) {
                    $jd = KpiJobdesc::find($id);
                    if (!$jd || $jd->kpi_document_id !== $kpiDocument->id) continue;
                    $old = $jd->toArray();
                    $jd->penilaian_koefisien_ontime_onbudget = (float)($row['penilaian_koefisien_ontime_onbudget'] ?? 0);
                    $jd->penilaian_grade_project              = (float)($row['penilaian_grade_project'] ?? 0);
                    $jd->nama_kegiatan_bukti                  = $row['nama_kegiatan_bukti'] ?? '';
                    $jd->mandays_proyek                       = (float)($row['mandays_proyek'] ?? 0);
                    $jd->recalculate();
                    $jd->save();
                    $changes['jobdesc'][$id] = ['from' => $old, 'to' => $jd->toArray()];
                }
            }

            if ($request->has('ci_edit')) {
                foreach ($request->input('ci_edit', []) as $id => $row) {
                    $ci = KpiContinuesImprovement::find($id);
                    if (!$ci || $ci->kpi_document_id !== $kpiDocument->id) continue;
                    $old = $ci->toArray();
                    $ci->jenis_kegiatan_bukti = $row['jenis_kegiatan_bukti'] ?? $ci->jenis_kegiatan_bukti;
                    $ci->kegiatan             = $row['kegiatan'] ?? $ci->kegiatan;
                    $ci->mandays              = (float)($row['mandays'] ?? $ci->mandays);
                    $ci->recalculate();
                    $ci->save();
                    $changes['ci'][$id] = ['from' => $old, 'to' => $ci->toArray()];
                }
            }

            if ($request->has('sd_edit')) {
                foreach ($request->input('sd_edit', []) as $id => $row) {
                    $sd = KpiSelfDevelopment::find($id);
                    if (!$sd || $sd->kpi_document_id !== $kpiDocument->id) continue;
                    $old = $sd->toArray();
                    $sd->jenis_sd  = $row['jenis_sd'] ?? $sd->jenis_sd;
                    $sd->kegiatan  = $row['kegiatan'] ?? $sd->kegiatan;
                    $sd->mandays   = (float)($row['mandays'] ?? $sd->mandays);
                    $sd->recalculate();
                    $sd->save();
                    $changes['sd'][$id] = ['from' => $old, 'to' => $sd->toArray()];
                }
            }

            if ($request->has('hr_edit')) {
                foreach ($request->input('hr_edit', []) as $id => $row) {
                    $hr = KpiHrActivity::find($id);
                    if (!$hr || $hr->kpi_document_id !== $kpiDocument->id) continue;
                    $old = $hr->toArray();
                    $hr->jenis_kegiatan = $row['jenis_kegiatan'] ?? $hr->jenis_kegiatan;
                    $hr->kegiatan       = $row['kegiatan'] ?? $hr->kegiatan;
                    $hr->mandays        = (float)($row['mandays'] ?? $hr->mandays);
                    $hr->recalculate();
                    $hr->save();
                    $changes['hr'][$id] = ['from' => $old, 'to' => $hr->toArray()];
                }
            }

            if ($request->has('perilaku_edit')) {
                foreach ($request->input('perilaku_edit', []) as $id => $row) {
                    $kp = KpiKinerjaPerilaku::find($id);
                    if (!$kp || $kp->kpi_document_id !== $kpiDocument->id) continue;
                    $old = $kp->toArray();
                    $kp->score = (float)($row['score'] ?? $kp->score);
                    $kp->save();
                    $changes['perilaku'][$id] = ['from' => $old, 'to' => $kp->toArray()];
                }
            }

            $kpiDocument->recalculateTotalScore();
            $kpiDocument->save();

            if (!empty($changes)) {
                KpiDocumentHistory::create([
                    'kpi_document_id' => $kpiDocument->id,
                    'changed_by'      => $user->id,
                    'action'          => 'update',
                    'section'         => 'document',
                    'old_data'        => $oldData,
                    'new_data'        => array_merge(
                        $kpiDocument->only(['status', 'notes', 'total_score']),
                        ['changes_detail' => $changes]
                    ),
                    'description' => 'Dokumen KPI diperbarui oleh ' . $user->name . ' (' . $user->role_label . ')',
                ]);
            }

            DB::commit();
            return redirect()->route('hr.kpi.show', $kpiDocument->id)
                ->with('success', 'Dokumen KPI berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus dokumen KPI staff
     */
    public function destroy(KpiDocument $kpiDocument)
    {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $kpiDocument->load('user');
            $docData = $kpiDocument->toArray();

            KpiDocumentHistory::create([
                'kpi_document_id' => $kpiDocument->id,
                'changed_by'      => $user->id,
                'action'          => 'delete',
                'section'         => 'document',
                'old_data'        => $docData,
                'description'     => 'Dokumen KPI dihapus oleh ' . $user->name . ' (' . $user->role_label . ')',
            ]);

            $kpiDocument->delete();
            DB::commit();

            return redirect()->route('hr.kpi.index')
                ->with('success', 'Dokumen KPI berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // ── Inline row-level updates ──────────────────────────────────────────────

    public function updateJobdesc(Request $request, KpiDocument $kpiDocument, KpiJobdesc $jobdesc)
    {
        $user    = Auth::user();
        $oldData = $jobdesc->toArray();

        $jobdesc->penilaian_koefisien_ontime_onbudget = (float)$request->penilaian_koefisien_ontime_onbudget;
        $jobdesc->penilaian_grade_project              = (float)$request->penilaian_grade_project;
        $jobdesc->nama_kegiatan_bukti                  = $request->nama_kegiatan_bukti;
        $jobdesc->mandays_proyek                       = (float)$request->mandays_proyek;
        $jobdesc->recalculate();
        $jobdesc->save();
        $kpiDocument->recalculateTotalScore();

        KpiDocumentHistory::create([
            'kpi_document_id' => $kpiDocument->id,
            'changed_by'      => $user->id,
            'action'          => 'update',
            'section'         => 'jobdesc',
            'old_data'        => $oldData,
            'new_data'        => $jobdesc->toArray(),
            'description'     => 'Baris Jobdesc #' . $jobdesc->id . ' diperbarui oleh ' . $user->name,
        ]);

        return back()->with('success', 'Data Jobdesc berhasil diperbarui!');
    }

    public function updateCI(Request $request, KpiDocument $kpiDocument, KpiContinuesImprovement $ci)
    {
        $user    = Auth::user();
        $oldData = $ci->toArray();

        $ci->jenis_kegiatan_bukti = $request->jenis_kegiatan_bukti;
        $ci->kegiatan             = $request->kegiatan;
        $ci->mandays              = (float)$request->mandays;
        $ci->recalculate();
        $ci->save();
        $kpiDocument->recalculateTotalScore();

        KpiDocumentHistory::create([
            'kpi_document_id' => $kpiDocument->id,
            'changed_by'      => $user->id,
            'action'          => 'update',
            'section'         => 'continues_improvement',
            'old_data'        => $oldData,
            'new_data'        => $ci->toArray(),
            'description'     => 'Baris CI #' . $ci->id . ' diperbarui oleh ' . $user->name,
        ]);

        return back()->with('success', 'Data Continues Improvement berhasil diperbarui!');
    }

    public function updateSD(Request $request, KpiDocument $kpiDocument, KpiSelfDevelopment $sd)
    {
        $user    = Auth::user();
        $oldData = $sd->toArray();

        $sd->jenis_sd = $request->jenis_sd;
        $sd->kegiatan = $request->kegiatan;
        $sd->mandays  = (float)$request->mandays;
        $sd->recalculate();
        $sd->save();
        $kpiDocument->recalculateTotalScore();

        KpiDocumentHistory::create([
            'kpi_document_id' => $kpiDocument->id,
            'changed_by'      => $user->id,
            'action'          => 'update',
            'section'         => 'self_development',
            'old_data'        => $oldData,
            'new_data'        => $sd->toArray(),
            'description'     => 'Baris SD #' . $sd->id . ' diperbarui oleh ' . $user->name,
        ]);

        return back()->with('success', 'Data Self Development berhasil diperbarui!');
    }

    public function updateHRActivity(Request $request, KpiDocument $kpiDocument, KpiHrActivity $hrActivity)
    {
        $user    = Auth::user();
        $oldData = $hrActivity->toArray();

        $hrActivity->jenis_kegiatan = $request->jenis_kegiatan;
        $hrActivity->kegiatan       = $request->kegiatan;
        $hrActivity->mandays        = (float)$request->mandays;
        $hrActivity->recalculate();
        $hrActivity->save();
        $kpiDocument->recalculateTotalScore();

        KpiDocumentHistory::create([
            'kpi_document_id' => $kpiDocument->id,
            'changed_by'      => $user->id,
            'action'          => 'update',
            'section'         => 'hr_activity',
            'old_data'        => $oldData,
            'new_data'        => $hrActivity->toArray(),
            'description'     => 'Baris HR Activity #' . $hrActivity->id . ' diperbarui oleh ' . $user->name,
        ]);

        return back()->with('success', 'Data HR Activity berhasil diperbarui!');
    }

    public function updatePerilaku(Request $request, KpiDocument $kpiDocument, KpiKinerjaPerilaku $perilaku)
    {
        $user    = Auth::user();
        $oldData = $perilaku->toArray();

        $perilaku->score = (float)$request->score;
        $perilaku->save();
        $kpiDocument->recalculateTotalScore();

        KpiDocumentHistory::create([
            'kpi_document_id' => $kpiDocument->id,
            'changed_by'      => $user->id,
            'action'          => 'update',
            'section'         => 'kinerja_perilaku',
            'old_data'        => $oldData,
            'new_data'        => $perilaku->toArray(),
            'description'     => 'Kinerja Perilaku "' . $perilaku->aspek_kinerja . '" diperbarui oleh ' . $user->name,
        ]);

        return back()->with('success', 'Score Kinerja Perilaku berhasil diperbarui!');
    }
}