<?php

namespace App\Filament\Widgets;

use App\Models\KpiDocument;
use App\Models\KpiForm;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalKaryawan = User::whereIn('role', [
            'associate', 'intermediate', 'senior', 'lead', 'principle',
        ])->count();

        $totalDokumen = KpiDocument::count();
        $diajukan     = KpiDocument::where('status', 'submitted')->count();
        $disetujui    = KpiDocument::where('status', 'approved')->count();
        $totalForm    = KpiForm::count();

        return [
            Stat::make('Total Karyawan', $totalKaryawan)
                ->description('Karyawan aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Dokumen KPI', $totalDokumen)
                ->description($diajukan . ' diajukan, ' . $disetujui . ' disetujui')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),

            Stat::make('Form KPI Baru', $totalForm)
                ->description('Form dengan approval')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('warning'),
        ];
    }
}
