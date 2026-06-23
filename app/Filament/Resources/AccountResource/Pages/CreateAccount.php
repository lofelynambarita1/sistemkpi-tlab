<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAccount extends CreateRecord
{
    protected static string $resource = AccountResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $roles = $this->form->getState()['roles'] ?? [];
        if (!empty($roles)) {
            $this->record->syncRoles($roles);
        } elseif ($this->record->role) {
            $this->record->assignRole($this->record->role);
        }
    }
}
