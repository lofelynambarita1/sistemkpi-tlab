<?php

namespace App\Filament\Pages;

use BackedEnum;
use BezhanSalleh\FilamentShield\Resources\RoleResource;
use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;

class ManagementUser extends Page
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-users';

    protected string $view = 'filament.pages.management-user';

    protected static ?string $navigationLabel = 'Management User';

    protected static ?string $title = 'Management User & Hak Akses';

    public function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ScreenMedium;
    }

    public function getViewData(): array
    {
        return [
            'userModeUrl' => \App\Filament\Resources\AccountResource::getUrl('index'),
            'roleModeUrl' => RoleResource::getUrl('index'),
            'dataModeResources' => $this->getDataModeResources(),
        ];
    }

    private function getDataModeResources(): array
    {
        return [
            [
                'name' => 'KPI Documents',
                'url' => \App\Filament\Resources\KpiDocumentResource::getUrl('index'),
                'icon' => 'heroicon-o-document-text',
                'description' => 'Kelola dokumen KPI',
            ],
            [
                'name' => 'KPI Approvals',
                'url' => \App\Filament\Resources\KpiApprovalResource::getUrl('index'),
                'icon' => 'heroicon-o-check-badge',
                'description' => 'Kelola approval KPI',
            ],
            [
                'name' => 'Annual Targets',
                'url' => \App\Filament\Resources\KpiAnnualTargetResource::getUrl('index'),
                'icon' => 'heroicon-o-calendar',
                'description' => 'Kelola target tahunan',
            ],
            [
                'name' => 'KPI Document History',
                'url' => \App\Filament\Resources\KpiDocumentHistoryResource::getUrl('index'),
                'icon' => 'heroicon-o-clock',
                'description' => 'Riwayat dokumen KPI',
            ],
        ];
    }
}
