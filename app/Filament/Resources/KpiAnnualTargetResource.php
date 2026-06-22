<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KpiAnnualTargetResource\Pages;
use App\Models\KpiAnnualTarget;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class KpiAnnualTargetResource extends Resource
{
    protected static ?string $model = KpiAnnualTarget::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Target Tahunan';

    protected static ?string $pluralLabel = 'Target Tahunan';

    protected static ?string $modelLabel = 'Target Tahunan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Informasi Target')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Karyawan')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('period_year')
                            ->label('Tahun')
                            ->required()
                            ->default(date('Y'))
                            ->maxLength(4),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Target')
                    ->schema([
                        Forms\Components\TextInput::make('target_jobdesc')
                            ->label('Target Jobdesc')
                            ->numeric()
                            ->default(100)
                            ->required(),
                        Forms\Components\TextInput::make('target_continues_improvement')
                            ->label('Target Continuous Improvement')
                            ->numeric()
                            ->default(50)
                            ->required(),
                        Forms\Components\TextInput::make('target_self_development')
                            ->label('Target Self Development')
                            ->numeric()
                            ->default(50)
                            ->required(),
                        Forms\Components\TextInput::make('target_hr_activity')
                            ->label('Target HR Activity')
                            ->numeric()
                            ->default(30)
                            ->required(),
                        Forms\Components\TextInput::make('target_kinerja_perilaku')
                            ->label('Target Kinerja Perilaku')
                            ->numeric()
                            ->default(100)
                            ->required(),
                        Forms\Components\TextInput::make('target_total')
                            ->label('Target Total')
                            ->numeric()
                            ->default(330)
                            ->required(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Capaian')
                    ->schema([
                        Forms\Components\TextInput::make('capaian_jobdesc')
                            ->label('Capaian Jobdesc')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('capaian_continues_improvement')
                            ->label('Capaian Continuous Improvement')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('capaian_self_development')
                            ->label('Capaian Self Development')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('capaian_hr_activity')
                            ->label('Capaian HR Activity')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('capaian_kinerja_perilaku')
                            ->label('Capaian Kinerja Perilaku')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('capaian_total')
                            ->label('Capaian Total')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Karyawan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('period_year')
                    ->label('Tahun')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_total')
                    ->label('Target Total')
                    ->numeric(2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('capaian_total')
                    ->label('Capaian Total')
                    ->numeric(2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('persentase_total')
                    ->label('Persentase')
                    ->badge()
                    ->color(fn (float $state): string => match (true) {
                        $state >= 90 => 'success',
                        $state >= 70 => 'warning',
                        default      => 'danger',
                    })
                    ->formatStateUsing(fn (float $state): string => $state . '%'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('period_year')
                    ->label('Tahun')
                    ->options(fn () => KpiAnnualTarget::distinct()->pluck('period_year', 'period_year')->sort()->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKpiAnnualTargets::route('/'),
            'create' => Pages\CreateKpiAnnualTarget::route('/create'),
            'edit'   => Pages\EditKpiAnnualTarget::route('/{record}/edit'),
        ];
    }
}
