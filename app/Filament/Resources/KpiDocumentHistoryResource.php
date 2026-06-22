<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KpiDocumentHistoryResource\Pages;
use App\Models\KpiDocumentHistory;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class KpiDocumentHistoryResource extends Resource
{
    protected static ?string $model = KpiDocumentHistory::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Riwayat Dokumen';

    protected static ?string $pluralLabel = 'Riwayat Dokumen';

    protected static ?string $modelLabel = 'Riwayat';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('kpi_document_id')
                    ->label('Dokumen')
                    ->relationship('kpiDocument', 'id')
                    ->required(),
                Forms\Components\Select::make('changed_by')
                    ->label('Diubah Oleh')
                    ->relationship('changedBy', 'name')
                    ->required(),
                Forms\Components\TextInput::make('action')
                    ->label('Aksi')
                    ->required(),
                Forms\Components\TextInput::make('section')
                    ->label('Bagian'),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kpiDocument.id')
                    ->label('Dokumen #')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kpiDocument.user.name')
                    ->label('Karyawan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('changedBy.name')
                    ->label('Diubah Oleh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('action')
                    ->label('Aksi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'create'        => 'success',
                        'update'        => 'warning',
                        'delete'        => 'danger',
                        'submit'        => 'info',
                        'status_change' => 'primary',
                        default         => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'create'        => 'Dibuat',
                        'update'        => 'Diperbarui',
                        'delete'        => 'Dihapus',
                        'submit'        => 'Disubmit',
                        'status_change' => 'Ubah Status',
                        default         => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('section')
                    ->label('Bagian')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'jobdesc'               => 'Jobdesc',
                        'continues_improvement' => 'CI',
                        'self_development'      => 'SD',
                        'hr_activity'           => 'HR Activity',
                        'kinerja_perilaku'      => 'Perilaku',
                        'document'              => 'Dokumen',
                        default                 => ucfirst($state ?? ''),
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(60),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKpiDocumentHistories::route('/'),
            'view'  => Pages\ViewKpiDocumentHistory::route('/{record}'),
        ];
    }
}
