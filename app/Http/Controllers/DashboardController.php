<?php

namespace App\Http\Controllers;

use App\Models\KpiAnnualTarget;
use App\Models\KpiDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $year = date('Y');

        return match($user->role) {
            'admin'           => $this->adminDashboard($user),
            'hr', 'manager'   => $this->hrManagerDashboard($user, $year),
            'lead_hr'         => $this->leadHrDashboard($user, $year),
            'lead'            => $this->leadDashboard($user, $year),
            'principle'       => $this->principleDashboard($user, $year),
            default           => $this->employeeDashboard($user, $year),
        };
    }

    private function adminDashboard(User $user)
    {
        $roleCounts = User::selectRaw('role, count(*) as total')
            ->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle', 'hr', 'manager', 'admin'])
            ->groupBy('role')
            ->pluck('total', 'role');

        return view('dashboard.admin', compact('user', 'roleCounts'));
    }

    private function hrManagerDashboard(User $user, string $year)
    {
        $documents = KpiDocument::with(['user'])
            ->whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle']))
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        $stats = [
            'total_documents' => KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle']))->count(),
            'submitted'       => KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle']))->where('status', 'submitted')->count(),
            'reviewed'        => KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle']))->where('status', 'reviewed')->count(),
            'approved'        => KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle']))->where('status', 'approved')->count(),
            'total_staff'     => User::whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle'])->count(),
        ];

        return view('dashboard.hr_manager', compact('user', 'documents', 'stats', 'year'));
    }

    private function leadHrDashboard(User $user, string $year)
    {
        $bawahanRoles = ['associate', 'intermediate', 'senior', 'lead', 'principle'];

        $totalBawahan = User::whereIn('role', $bawahanRoles)->count();
        $kpiMenunggu  = KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', $bawahanRoles))
            ->where('status', 'submitted')->count();
        $kpiApproved  = KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', $bawahanRoles))
            ->where('status', 'approved')->count();
        $kpiDitolak   = KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', $bawahanRoles))
            ->where('status', 'need_revision')->count();

        $statusStats = KpiDocument::selectRaw('status, count(*) as total')
            ->whereHas('user', fn($q) => $q->whereIn('role', $bawahanRoles))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('dashboard.lead_hr', compact('user', 'totalBawahan', 'kpiMenunggu', 'kpiApproved', 'kpiDitolak', 'statusStats'));
    }

    private function leadDashboard(User $user, string $year)
    {
        $totalEmployee  = User::whereIn('role', ['associate', 'intermediate', 'senior'])->count();
        $totalSubmitted = KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior']))
            ->where('status', 'submitted')->count();

        return view('dashboard.lead', compact('user', 'totalEmployee', 'totalSubmitted'));
    }

    private function principleDashboard(User $user, string $year)
    {
        return $this->employeeDashboard($user, $year, 'dashboard.principle');
    }

    private function employeeDashboard(User $user, string $year, ?string $view = null)
    {
        $view  = $view ?? 'dashboard.employee';
        $myKpis = KpiDocument::where('user_id', $user->id)
            ->orderBy('period_year', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        $totalKpi     = $myKpis->count();
        $approved     = $myKpis->where('status', 'approved')->count();
        $submitted    = $myKpis->where('status', 'submitted')->count();
        $needRevision = $myKpis->where('status', 'need_revision')->count();
        $draft        = $myKpis->where('status', 'draft')->count();
        $latestKpi    = $myKpis->first();

        return view($view, compact('user', 'myKpis', 'totalKpi', 'approved', 'submitted', 'needRevision', 'draft', 'latestKpi'));
    }

    private function staffDashboard(User $user, string $year)
    {
        $target = KpiAnnualTarget::firstOrCreate(
            ['user_id' => $user->id, 'period_year' => $year],
            [
                'target_jobdesc'               => 100,
                'target_continues_improvement' => 50,
                'target_self_development'      => 50,
                'target_hr_activity'           => 30,
                'target_kinerja_perilaku'      => 100,
                'target_total'                 => 330,
            ]
        );

        $documents = KpiDocument::where('user_id', $user->id)
            ->where('period_year', $year)
            ->whereIn('status', ['submitted', 'reviewed', 'approved'])
            ->get();

        $capaianJobdesc  = 0;
        $capaianCI       = 0;
        $capaianSD       = 0;
        $capaianHR       = 0;
        $capaianPerilaku = 0;

        foreach ($documents as $doc) {
            $capaianJobdesc  += $doc->jobdescs()->sum('total_mandays_penugasan');
            $capaianCI       += $doc->continuesImprovements()->sum('point');
            $capaianSD       += $doc->selfDevelopments()->sum('point');
            $capaianHR       += $doc->hrActivities()->sum('point');
            $capaianPerilaku += $doc->kinerjaPerilakus()->sum('score');
        }

        $target->update([
            'capaian_jobdesc'               => $capaianJobdesc,
            'capaian_continues_improvement' => $capaianCI,
            'capaian_self_development'      => $capaianSD,
            'capaian_hr_activity'           => $capaianHR,
            'capaian_kinerja_perilaku'      => $capaianPerilaku,
            'capaian_total'                 => $capaianJobdesc + $capaianCI + $capaianSD + $capaianHR + $capaianPerilaku,
        ]);

        $recentDocs = KpiDocument::where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.staff', compact('user', 'target', 'year', 'recentDocs'));
    }
}
