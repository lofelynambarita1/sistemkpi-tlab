<?php

namespace App\Filament\Resources\KpiDocumentResource\Pages;

use App\Filament\Resources\KpiDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKpiDocuments extends ListRecords
{
    protected static string $resource = KpiDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Dokumen KPI Baru'),
        ];
    }
}
