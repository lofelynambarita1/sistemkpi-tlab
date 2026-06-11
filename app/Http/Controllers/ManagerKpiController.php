<?php

// app/Http/Controllers/ManagerKpiController.php

namespace App\Http\Controllers;

use App\Models\Kpi;
use App\Models\KpiReview;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ManagerKpiController extends Controller
{
    public function indexPending()
    {
        $user = auth()->user();
        $kpis = Kpi::where('manager_id', $user->user_id)
            ->where('status', 'Submitted')
            ->with('employee')
            ->get();
            
        return response()->json($kpis);
    }

    
    public function bulkAction(Request $request)
    {
        $request->validate([
            'kpi_ids' => 'required|array|min:1',
            'kpi_ids.*' => 'exists:kpis,kpi_id',
            'action' => 'required|in:Accept,Decline',
            'komentar' => 'required_if:action,Decline|string'
        ]);

        
        DB::beginTransaction();
        try {
            $managerId = auth()->user()->user_id;
            $newStatus = $request->action === 'Accept' ? 'Approved' : 'Rejected';

            foreach ($request->kpi_ids as $kpiId) {
                $kpi = Kpi::findOrFail($kpiId);
                $kpi->update(['status' => $newStatus]);

                KpiReview::create([
                    'kpi_id' => $kpiId,
                    'reviewer_id' => $managerId,
                    'komentar' => $request->komentar,
                    'keputusan' => $request->action,
                ]);

                
                History::create([
                    'user_id' => $managerId,
                    'action' => "Bulk {$request->action} KPI",
                    'model_type' => Kpi::class,
                    'model_id' => $kpiId,
                ]);
            }

            DB::commit();
            return response()->json(['message' => "Berhasil melakukan {$request->action} pada " . count($request->kpi_ids) . " KPI"]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal memproses bulk action'], 500);
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