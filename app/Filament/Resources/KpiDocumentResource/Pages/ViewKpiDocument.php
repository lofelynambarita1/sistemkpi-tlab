<?php

namespace App\Filament\Resources\KpiDocumentResource\Pages;

use App\Filament\Resources\KpiDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKpiDocument extends ViewRecord
{
    protected static string $resource = KpiDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
