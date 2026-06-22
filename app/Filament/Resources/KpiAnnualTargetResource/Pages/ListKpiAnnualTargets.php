<?php

namespace App\Filament\Resources\KpiAnnualTargetResource\Pages;

use App\Filament\Resources\KpiAnnualTargetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKpiAnnualTargets extends ListRecords
{
    protected static string $resource = KpiAnnualTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Target Baru'),
        ];
    }
}
