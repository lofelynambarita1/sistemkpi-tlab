<?php

namespace App\Http\Controllers;

use App\Models\KpiForm;
use App\Models\User;
use App\Services\KpiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewKpiController extends Controller
{
    public function __construct(private KpiService $kpiService) {}

    /**
     * List KPIs for review, filtered by the reviewer's role.
     */
    public function index(Request $request)
    {
        $reviewer = Auth::user();
        $query    = KpiForm::with(['user', 'approvals.actor'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%'));
            });

        match($reviewer->role) {
            'lead' => $query->whereHas('user', fn($q) => $q->whereIn('role', ['associate','intermediate','senior']))
                            ->where('status', KpiForm::STATUS_WAITING_LEAD),

            'lead_hr' => $query->whereHas('user', fn($q) => $q->whereIn('role', ['associate','intermediate','senior','lead','principle']))
                               ->where('status', KpiForm::STATUS_WAITING_LHR),

            'manager' => $query->where('status', KpiForm::STATUS_WAITING_MGR),

            default => $query->whereRaw('1=0'),
        };

        if ($request->filled('sort')) {
            $query->orderBy($request->sort, $request->get('direction', 'asc'));
        } else {
            $query->latest();
        }

        $forms = $query->paginate(15)->withQueryString();

        return view('review.index', compact('forms', 'reviewer'));
    }

    /**
     * Show one KPI form in review mode.
     */
    public function show(KpiForm $kpiForm)
    {
        $kpiForm->load([
            'user',
            'jobdescs',
            'continuousImprovements',
            'selfDevelopments',
            'hrActivities',
            'kinerjaPerilakus',
            'approvals.actor',
        ]);

        return view('review.show', ['form' => $kpiForm, 'reviewer' => Auth::user()]);
    }

    /**
     * Approve a single KPI.
     */
    public function approve(Request $request, KpiForm $kpiForm)
    {
        $request->validate(['komentar' => 'nullable|string|max:1000']);
        $reviewer = Auth::user();

        match($reviewer->role) {
            'lead'    => $this->kpiService->approveByLead($kpiForm, $reviewer, $request->komentar),
            'lead_hr' => $this->kpiService->approveByLeadHR($kpiForm, $reviewer, $request->komentar),
            'manager' => $this->kpiService->approveByManager($kpiForm, $reviewer, $request->komentar),
        };

        return redirect()->route('review.index')->with('success', 'KPI berhasil diapprove.');
    }

    /**
     * Reject a single KPI.
     */
    public function reject(Request $request, KpiForm $kpiForm)
    {
        $request->validate(['komentar' => 'nullable|string|max:1000']);
        $reviewer = Auth::user();

        match($reviewer->role) {
            'lead'    => $this->kpiService->rejectByLead($kpiForm, $reviewer, $request->komentar),
            'lead_hr' => $this->kpiService->rejectByLeadHR($kpiForm, $reviewer, $request->komentar),
            'manager' => $this->kpiService->rejectByManager($kpiForm, $reviewer, $request->komentar),
        };

        return redirect()->route('review.index')->with('success', 'KPI dikembalikan untuk revisi.');
    }

    /**
     * Bulk approve.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ids'      => 'required|array',
            'ids.*'    => 'integer',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $this->kpiService->bulkApprove($request->ids, Auth::user(), $request->komentar);

        return back()->with('success', count($request->ids) . ' KPI berhasil diapprove.');
    }

    /**
     * Bulk reject.
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'ids'      => 'required|array',
            'ids.*'    => 'integer',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $this->kpiService->bulkReject($request->ids, Auth::user(), $request->komentar);

        return back()->with('success', count($request->ids) . ' KPI berhasil direject.');
    }

    /**
     * Export KPI forms to Excel (Manager only).
     */
    public function export(Request $request)
    {
        $ids = $request->input('ids', []);
        $forms = KpiForm::whereIn('id', $ids)->with('user')->get();

        $csv = "Nama,Periode,Status,Skor Akhir\n";
        foreach ($forms as $form) {
            $csv .= implode(',', [
                '"' . str_replace('"', '""', $form->user->name) . '"',
                $form->periode,
                $form->status,
                $form->final_kpi_score,
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="kpi-forms.csv"',
        ]);
    }
}