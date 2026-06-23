<?php

namespace App\Http\Controllers;

use App\Models\KpiForm;
use App\Models\KpiApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerKpiController extends Controller
{
    public function indexPending()
    {
        $forms = KpiForm::with('user')
            ->where('status', KpiForm::STATUS_WAITING_MGR)
            ->where('current_approver_id', Auth::id())
            ->orderBy('submitted_at', 'desc')
            ->get();

        return response()->json($forms);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids'    => 'required|array',
            'action' => 'required|in:approve,reject',
        ]);

        foreach ($request->ids as $id) {
            $form = KpiForm::findOrFail($id);

            if ($request->action === 'approve') {
                $form->status = KpiForm::STATUS_APPROVED;
                $form->current_approver_id = null;
                $form->save();

                KpiApproval::create([
                    'kpi_form_id' => $form->id,
                    'actor_id'    => Auth::id(),
                    'action'      => 'approved_manager',
                    'acted_at'    => now(),
                ]);
            } else {
                $form->status = KpiForm::STATUS_NEED_REVISION;
                $form->current_approver_id = null;
                $form->save();

                KpiApproval::create([
                    'kpi_form_id' => $form->id,
                    'actor_id'    => Auth::id(),
                    'action'      => 'rejected_manager',
                    'acted_at'    => now(),
                ]);
            }
        }

        $actionLabel = $request->action === 'approve' ? 'diapprove' : 'direject';
        return response()->json(['message' => count($request->ids) . " KPI berhasil {$actionLabel}."]);
    }

    public function history()
    {
        $histories = KpiApproval::with(['form.user', 'actor'])
            ->where('actor_id', Auth::id())
            ->orderBy('acted_at', 'desc')
            ->get();

        return response()->json($histories);
    }
}
