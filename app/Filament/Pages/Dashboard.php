<?php

namespace App\Filament\Pages;

use App\Models\KpiDocument;
use App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Dashboard';

    public function getViewData(): array
    {
        $user = Auth::user();
        $year = date('Y');

        if ($user->isAdmin()) {
            return $this->getAdminData($user);
        }

        if ($user->isHROrManager()) {
            return $this->getHrManagerData($user, $year);
        }

        return $this->getEmployeeData($user, $year);
    }

    private function getAdminData(User $user): array
    {
        $roleCounts = User::selectRaw('role, count(*) as total')
            ->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle', 'hr', 'manager', 'admin'])
            ->groupBy('role')
            ->pluck('total', 'role');

        return compact('user', 'roleCounts');
    }

    private function getHrManagerData(User $user, string $year): array
    {
        $stats = [
            'total_documents' => KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle']))->count(),
            'submitted'       => KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle']))->where('status', 'submitted')->count(),
            'reviewed'        => KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle']))->where('status', 'reviewed')->count(),
            'approved'        => KpiDocument::whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle']))->where('status', 'approved')->count(),
            'total_staff'     => User::whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle'])->count(),
        ];

        return compact('user', 'stats', 'year');
    }

    private function getEmployeeData(User $user, string $year): array
    {
        $myKpis = KpiDocument::where('user_id', $user->id)
            ->orderBy('period_year', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        $totalKpi     = $myKpis->count();
        $approved     = $myKpis->where('status', 'approved')->count();
        $submitted    = $myKpis->where('status', 'submitted')->count();
        $needRevision = $myKpis->where('status', 'need_revision')->count();
        $draft        = $myKpis->where('status', 'draft')->count();

        return compact('user', 'myKpis', 'totalKpi', 'approved', 'submitted', 'needRevision', 'draft');
    }
}
