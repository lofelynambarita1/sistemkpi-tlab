<?php

namespace App\Http\Controllers;

use App\Models\KpiContinuousImprovement;
use App\Models\KpiForm;
use App\Models\KpiHrActivity;
use App\Models\KpiJobdesc;
use App\Models\KpiKinerjaPerilaku;
use App\Models\KpiSelfDevelopment;
use App\Models\User;
use App\Services\KpiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KpiFormController extends Controller
{
    public function __construct(private KpiService $kpiService) {}

    // ── Show the KPI form (create or edit) ─────────────────────────
    public function index()
    {
        $user = Auth::user();
        $form = KpiForm::with([
            'jobdescs',
            'continuousImprovements',
            'selfDevelopments',
            'hrActivities',
            'kinerjaPerilakus',
            'approvals.actor',
        ])->where('user_id', $user->id)
          ->where('periode', date('Y'))
          ->first();

        return view('kpi.form', compact('user', 'form'));
    }

    // ── Save draft ──────────────────────────────────────────────────
    public function saveDraft(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'total_cuti'          => 'nullable|integer|min:0|max:12',
            // Jobdesc rows
            'jobdescs'            => 'nullable|array',
            'jobdescs.*.penilaian_ontime_onbudget' => 'required_with:jobdescs|string',
            'jobdescs.*.grade_project'             => 'required_with:jobdescs|in:A,B,C',
            'jobdescs.*.nama_kegiatan_bukti'       => 'required_with:jobdescs|string',
            'jobdescs.*.mandays_proyek'            => 'required_with:jobdescs|integer|min:1',
            // CI rows
            'continuous_improvements'              => 'nullable|array',
            'continuous_improvements.*.jenis_kegiatan_bukti' => 'required_with:continuous_improvements|string',
            'continuous_improvements.*.kegiatan_ci'          => 'required_with:continuous_improvements|string',
            'continuous_improvements.*.mandays_ci'           => 'required_with:continuous_improvements|integer|min:1',
            // SD rows
            'self_developments'                    => 'nullable|array',
            'self_developments.*.jenis_kegiatan_sd' => 'required_with:self_developments|string',
            'self_developments.*.kegiatan_sd'       => 'required_with:self_developments|string',
            'self_developments.*.mandays_sd'        => 'required_with:self_developments|integer|min:1',
            // HRA rows
            'hr_activities'                        => 'nullable|array',
            'hr_activities.*.jenis_kegiatan_hra'  => 'required_with:hr_activities|string',
            'hr_activities.*.kegiatan_hra'        => 'required_with:hr_activities|string',
            'hr_activities.*.mandays_hra'         => 'required_with:hr_activities|integer|min:1',
            // Kinerja Perilaku rows
            'kinerja_perilakus'                   => 'nullable|array',
            'kinerja_perilakus.*.aspek'           => 'required_with:kinerja_perilakus|string',
            'kinerja_perilakus.*.nilai'           => 'required_with:kinerja_perilakus|numeric|min:0|max:100',
        ]);

        DB::transaction(function () use ($request, $user) {
            // Create or find draft form
            $form = KpiForm::firstOrCreate(
                ['user_id' => $user->id, 'periode' => date('Y'), 'status' => KpiForm::STATUS_DRAFT],
                ['status'  => KpiForm::STATUS_DRAFT]
            );

            if (!$form->isEditable()) {
                abort(403, 'Form tidak dapat diedit.');
            }

            // Update cuti & recalculate targets
            $form->total_cuti = $request->input('total_cuti', 0);
            $form->save();
            $form->load('user');
            $form->recalculateTargets();

            // ── Jobdescs ──────────────────────────────────────────
            $form->jobdescs()->delete();
            foreach ($request->input('jobdescs', []) as $row) {
                $koefOtob  = KpiJobdesc::$ontimeOptions[$row['penilaian_ontime_onbudget']] ?? 0;
                $koefGrade = $user->gradeProjectCoefficient($row['grade_project']);
                $jumlah    = $koefOtob + $koefGrade;
                $totalMD   = ($row['mandays_proyek'] * $jumlah) / 2;

                KpiJobdesc::create([
                    'kpi_form_id'                => $form->id,
                    'penilaian_ontime_onbudget'  => $row['penilaian_ontime_onbudget'],
                    'koefisien_ontime_onbudget'  => $koefOtob,
                    'grade_project'              => $row['grade_project'],
                    'koefisien_grade_project'    => $koefGrade,
                    'jumlah_koefisien'           => $jumlah,
                    'nama_kegiatan_bukti'        => $row['nama_kegiatan_bukti'],
                    'mandays_proyek'             => $row['mandays_proyek'],
                    'total_mandays_penugasan'    => $totalMD,
                ]);
            }

            // ── Continuous Improvements ───────────────────────────
            $form->continuousImprovements()->delete();
            foreach ($request->input('continuous_improvements', []) as $row) {
                $koef  = KpiContinuousImprovement::$jenisOptions[$row['jenis_kegiatan_bukti']] ?? 0;
                $point = $koef * $row['mandays_ci'];

                KpiContinuousImprovement::create([
                    'kpi_form_id'         => $form->id,
                    'jenis_kegiatan_bukti'=> $row['jenis_kegiatan_bukti'],
                    'koefisien'           => $koef,
                    'kegiatan_ci'         => $row['kegiatan_ci'],
                    'mandays_ci'          => $row['mandays_ci'],
                    'point_ci'            => $point,
                ]);
            }

            // ── Self Developments ─────────────────────────────────
            $form->selfDevelopments()->delete();
            foreach ($request->input('self_developments', []) as $row) {
                $koef  = KpiSelfDevelopment::$jenisOptions[$row['jenis_kegiatan_sd']] ?? 0;
                $point = $koef * $row['mandays_sd'];

                KpiSelfDevelopment::create([
                    'kpi_form_id'      => $form->id,
                    'jenis_kegiatan_sd'=> $row['jenis_kegiatan_sd'],
                    'koefisien_sd'     => $koef,
                    'kegiatan_sd'      => $row['kegiatan_sd'],
                    'mandays_sd'       => $row['mandays_sd'],
                    'point_sd'         => $point,
                ]);
            }

            // ── HR Activities ─────────────────────────────────────
            $form->hrActivities()->delete();
            foreach ($request->input('hr_activities', []) as $row) {
                $koef  = KpiHrActivity::$jenisOptions[$row['jenis_kegiatan_hra']] ?? 0;
                $point = $koef * $row['mandays_hra'];

                KpiHrActivity::create([
                    'kpi_form_id'       => $form->id,
                    'jenis_kegiatan_hra'=> $row['jenis_kegiatan_hra'],
                    'koefisien_hra'     => $koef,
                    'kegiatan_hra'      => $row['kegiatan_hra'],
                    'mandays_hra'       => $row['mandays_hra'],
                    'point_hra'         => $point,
                ]);
            }

            // ── Kinerja Perilaku ──────────────────────────────────
            $form->kinerjaPerilakus()->delete();
            foreach ($request->input('kinerja_perilakus', []) as $row) {
                KpiKinerjaPerilaku::create([
                    'kpi_form_id' => $form->id,
                    'aspek'       => $row['aspek'],
                    'deskripsi'   => $row['deskripsi'] ?? null,
                    'nilai'       => $row['nilai'],
                    'catatan'     => $row['catatan'] ?? null,
                ]);
            }

            // Log update
            \App\Models\KpiApproval::create([
                'kpi_form_id' => $form->id,
                'actor_id'    => $user->id,
                'action'      => 'updated',
                'acted_at'    => now(),
            ]);
        });

        return back()->with('success', 'Draft KPI berhasil disimpan.');
    }

    // ── Submit KPI ──────────────────────────────────────────────────
    public function submit(Request $request)
    {
        $user = Auth::user();
        $form = KpiForm::where('user_id', $user->id)
            ->where('periode', date('Y'))
            ->firstOrFail();

        if (!$form->isEditable()) {
            return back()->withErrors(['form' => 'Form tidak dapat disubmit saat ini.']);
        }

        $this->kpiService->submit($form, $user);

        return redirect()->back()->with('success', 'KPI berhasil disubmit.');
    }

    // ── History ─────────────────────────────────────────────────────
    public function history()
    {
        $user = Auth::user();
        $approvals = \App\Models\KpiApproval::with(['kpiForm', 'actor'])
            ->whereHas('kpiForm', fn($q) => $q->where('user_id', $user->id))
            ->orderByDesc('acted_at')
            ->paginate(20);

        return view('kpi.history', compact('approvals'));
    }
}