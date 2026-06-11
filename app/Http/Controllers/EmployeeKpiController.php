<?php

// app/Http/Controllers/EmployeeKpiController.php

namespace App\Http\Controllers;

use App\Models\Kpi;
use App\Models\KpiJobdesc;
use App\Models\KpiContinuesImprovement;
use App\Models\KpiSelfDevelopment;
use App\Models\KpiHrActivity;
use App\Models\KpiBehavior;
use App\Models\History;
use App\Services\KpiCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EmployeeKpiController extends Controller
{
    protected $calcService;

    public function __construct(KpiCalculationService $calcService)
    {
        $this->calcService = $calcService;
    }

    public function store(Request $request)
    {
                $validated = $request->validate([
            'periode_penilaian' => 'required|string',
            'tahun' => 'required|integer',
            'jobdesc.koefisien_ontime_budget' => 'required|numeric',
            'jobdesc.grade_project' => 'required|in:A,B,C',
            'jobdesc.nama_kegiatan_bukti' => 'required|string',
            'jobdesc.mandays_proyek' => 'required|integer|min:1',
            'ci' => 'nullable|array',
            'ci.*.jenis_kegiatan' => 'required|string',
            'ci.*.koefisien' => 'required|numeric',
            'ci.*.kegiatan' => 'nullable|string',
            'ci.*.mandays' => 'required|integer|min:1',
            'sd' => 'nullable|array',
            'sd.*.jenis_kegiatan' => 'required|string',
            'sd.*.koefisien' => 'required|numeric',
            'sd.*.kegiatan' => 'nullable|string',
            'sd.*.mandays' => 'required|integer|min:1',
            'hr' => 'nullable|array',
            'hr.*.jenis_kegiatan' => 'required|string',
            'hr.*.koefisien' => 'required|numeric',
            'hr.*.kegiatan' => 'nullable|string',
            'hr.*.mandays' => 'required|integer|min:1',
            'behaviors' => 'nullable|array',
             ]);

                     DB::beginTransaction();
        try {
            $user = auth()->user();
            
            $kpi = Kpi::create([
                'employee_id' => $user->user_id,
                'manager_id' => $user->manager_id,
                'periode_penilaian' => $validated['periode_penilaian'],
                'tahun' => $validated['tahun'],
                'status' => 'Submitted',
            ]);

            $koefisienGrade = $this->calcService->getGradeProjectCoefficient($user->role->name, $validated['jobdesc']['grade_project']);
            $totalMandays = $this->calcService->calculateTotalMandaysPenugasan(
                $validated['jobdesc']['mandays_proyek'],
                $validated['jobdesc']['koefisien_ontime_budget'],
                $koefisienGrade
            );
            
            
            KpiJobdesc::create([
                'kpi_id' => $kpi->kpi_id,
                'koefisien_ontime_budget' => $validated['jobdesc']['koefisien_ontime_budget'],
                'grade_project' => $validated['jobdesc']['grade_project'],
                'koefisien_grade_project' => $koefisienGrade,
                'nama_kegiatan_bukti' => $validated['jobdesc']['nama_kegiatan_bukti'],
                'mandays_proyek' => $validated['jobdesc']['mandays_proyek'],
                'total_mandays_penugasan' => $totalMandays,
            ]);

                        foreach ($validated['ci'] ?? [] as $item) {
                KpiContinuesImprovement::create([
                    'kpi_id' => $kpi->kpi_id,
                    'jenis_kegiatan' => $item['jenis_kegiatan'],
                    'koefisien' => $item['koefisien'],
                    'kegiatan' => $item['kegiatan'] ?? null,
                    'mandays' => $item['mandays'],
                    'point' => $this->calcService->calculatePoint($item['koefisien'], $item['mandays'])
                ]);
            }

            
            foreach ($validated['sd'] ?? [] as $item) {
                KpiSelfDevelopment::create([
                    'kpi_id' => $kpi->kpi_id,
                    'jenis_kegiatan' => $item['jenis_kegiatan'],
                    'koefisien' => $item['koefisien'],
                    'kegiatan' => $item['kegiatan'] ?? null,
                    'mandays' => $item['mandays'],
                    'point' => $this->calcService->calculatePoint($item['koefisien'], $item['mandays'])
                ]);
            }

                        foreach ($validated['hr'] ?? [] as $item) {
                KpiHrActivity::create([
                    'kpi_id' => $kpi->kpi_id,
                    'jenis_kegiatan' => $item['jenis_kegiatan'],
                    'koefisien' => $item['koefisien'],
                    'kegiatan' => $item['kegiatan'] ?? null,
                    'mandays' => $item['mandays'],
                    'point' => $this->calcService->calculatePoint($item['koefisien'], $item['mandays'])
                ]);
            }

            
            foreach ($validated['behaviors'] ?? [] as $kategori => $data) {
                KpiBehavior::create([
                    'kpi_id' => $kpi->kpi_id,
                    'kategori' => $kategori,
                    'score' => $data['score'] ?? null,
                    'deskripsi' => $data['deskripsi'] ?? null,
                ]);
            }

            
            History::create([
                'user_id' => $user->user_id,
                'action' => 'Submit KPI',
                'model_type' => Kpi::class,
                'model_id' => $kpi->kpi_id,
                'details' => ['status' => 'Submitted']
            ]);

            DB::commit();
            return response()->json(['message' => 'KPI berhasil dikirim ke Manager'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

        public function history()
    {
        $histories = History::where('user_id', auth()->user()->user_id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($histories);
    }
}