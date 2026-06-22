<?php

namespace App\Filament\Resources\KpiAnnualTargetResource\Pages;

use App\Filament\Resources\KpiAnnualTargetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKpiAnnualTarget extends CreateRecord
{
    protected static string $resource = KpiAnnualTargetResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
