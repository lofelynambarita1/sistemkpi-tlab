<?php

namespace App\Filament\Resources\KpiDocumentResource\Pages;

use App\Filament\Resources\KpiDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditKpiDocument extends EditRecord
{
    protected static string $resource = KpiDocumentResource::class;

    protected function afterSave(): void
    {
        $this->record->recalculateTotalScore();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
