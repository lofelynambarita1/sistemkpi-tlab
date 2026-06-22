<?php

namespace App\Filament\Resources\KpiAnnualTargetResource\Pages;

use App\Filament\Resources\KpiAnnualTargetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKpiAnnualTarget extends EditRecord
{
    protected static string $resource = KpiAnnualTargetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
