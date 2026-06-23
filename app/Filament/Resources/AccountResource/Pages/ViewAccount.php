<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewAccount extends ViewRecord
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Update Data'),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Akun')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('employee_id')
                            ->label('NIK')
                            ->default('-'),
                    ])
                    ->columns(3),

                Section::make('Data Karyawan')
                    ->schema([
                        TextEntry::make('department')
                            ->label('Divisi')
                            ->default('-'),
                        TextEntry::make('jabatan')
                            ->label('Jabatan')
                            ->default('-'),
                        TextEntry::make('atasan.name')
                            ->label('Atasan')
                            ->default('-'),
                        TextEntry::make('status_akun')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => $state === 'aktif' ? 'success' : 'danger')
                            ->formatStateUsing(fn (string $state): string => $state === 'aktif' ? 'Aktif' : 'Nonaktif'),
                    ])
                    ->columns(2),

                Section::make('Role & Hak Akses')
                    ->schema([
                        TextEntry::make('roles')
                            ->label('Role (Shield)')
                            ->formatStateUsing(fn ($state): string => $state->pluck('name')->implode(', ') ?: '-'),
                        TextEntry::make('role')
                            ->label('Role (Legacy)')
                            ->formatStateUsing(fn (?string $state): string => $state ? ucfirst($state) : '-'),
                    ])
                    ->columns(2),

                Section::make('Informasi Sistem')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime('d M Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Diperbarui')
                            ->dateTime('d M Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}
