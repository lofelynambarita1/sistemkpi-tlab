<?php

namespace App\Http\Controllers;

use App\Models\KpiAnnualTarget;
use App\Models\KpiDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $year = date('Y');

        if ($user->isHROrManager()) {
            return $this->hrManagerDashboard($user, $year);
        }

        return $this->staffDashboard($user, $year);
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

        // Update capaian from submitted documents
        $documents = KpiDocument::where('user_id', $user->id)
            ->where('period_year', $year)
            ->whereIn('status', ['submitted', 'reviewed', 'approved'])
            ->get();

        $capaianJobdesc = 0;
        $capaianCI      = 0;
        $capaianSD      = 0;
        $capaianHR      = 0;
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
}
