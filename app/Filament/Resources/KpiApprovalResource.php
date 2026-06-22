<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KpiApprovalResource\Pages;
use App\Models\KpiApproval;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class KpiApprovalResource extends Resource
{
    protected static ?string $model = KpiApproval::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationLabel = 'Riwayat Approval';

    protected static ?string $pluralLabel = 'Riwayat Approval';

    protected static ?string $modelLabel = 'Approval';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('kpi_form_id')
                    ->label('Form KPI')
                    ->relationship('form', 'id')
                    ->required(),
                Forms\Components\Select::make('actor_id')
                    ->label('Aktor')
                    ->relationship('actor', 'name')
                    ->required(),
                Forms\Components\TextInput::make('action')
                    ->label('Aksi')
                    ->required(),
                Forms\Components\Textarea::make('komentar')
                    ->label('Komentar')
                    ->maxLength(65535),
                Forms\Components\DateTimePicker::make('acted_at')
                    ->label('Waktu'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('form.id')
                    ->label('Form #')
                    ->sortable(),
                Tables\Columns\TextColumn::make('actor.name')
                    ->label('Aktor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('action')
                    ->label('Aksi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'submitted' => 'info',
                        'approved_lead', 'approved_lead_hr', 'approved_manager' => 'success',
                        'rejected_lead', 'rejected_lead_hr', 'rejected_manager' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'submitted'       => 'Diajukan',
                        'approved_lead'   => 'Disetujui Lead',
                        'approved_lead_hr'=> 'Disetujui Lead HR',
                        'approved_manager'=> 'Disetujui Manager',
                        'rejected_lead'   => 'Ditolak Lead',
                        'rejected_lead_hr'=> 'Ditolak Lead HR',
                        'rejected_manager'=> 'Ditolak Manager',
                        default           => ucfirst(str_replace('_', ' ', $state)),
                    }),
                Tables\Columns\TextColumn::make('komentar')
                    ->label('Komentar')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('acted_at')
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
            'index' => Pages\ListKpiApprovals::route('/'),
            'view'  => Pages\ViewKpiApproval::route('/{record}'),
        ];
    }
}
