<?php

namespace App\Filament\Resources\KpiDocumentResource\Pages;

use App\Filament\Resources\KpiDocumentResource;
use App\Models\KpiKinerjaPerilaku;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateKpiDocument extends CreateRecord
{
    protected static string $resource = KpiDocumentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $record = parent::handleRecordCreation($data);

        $masterData = KpiKinerjaPerilaku::getMasterData();
        foreach ($masterData as $i => $master) {
            $record->kinerjaPerilakus()->create([
                'score'           => 0,
                'aspek_kinerja'   => $master['aspek_kinerja'],
                'definisi'        => $master['definisi'],
                'minimum_capaian' => $master['minimum_capaian'],
                'indikator'       => $master['indikator'],
                'deskripsi'       => $master['deskripsi'],
                'row_order'       => $i,
            ]);
        }

        $record->recalculateTotalScore();

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
