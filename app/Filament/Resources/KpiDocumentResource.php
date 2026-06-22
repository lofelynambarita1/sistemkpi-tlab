<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KpiDocumentResource\Pages;
use App\Models\KpiContinuesImprovement;
use App\Models\KpiDocument;
use App\Models\KpiHrActivity;
use App\Models\KpiKinerjaPerilaku;
use App\Models\KpiSelfDevelopment;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class KpiDocumentResource extends Resource
{
    protected static ?string $model = KpiDocument::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Dokumen KPI';

    protected static ?string $pluralLabel = 'Dokumen KPI';

    protected static ?string $modelLabel = 'Dokumen KPI';

    public static function form(Schema $schema): Schema
    {
        $ciOptions = array_keys(KpiContinuesImprovement::$koefisienMap);
        $sdOptions = array_keys(KpiSelfDevelopment::$koefisienMap);
        $hrOptions = array_keys(KpiHrActivity::$koefisienMap);

        return $schema
            ->schema([
                Forms\Components\Section::make('Informasi Dokumen')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Karyawan')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(fn () => Auth::user()->isStaff() ? Auth::id() : null)
                            ->disabled(fn () => Auth::user()->isStaff()),
                        Forms\Components\TextInput::make('period_year')
                            ->label('Tahun Periode')
                            ->required()
                            ->default(date('Y'))
                            ->maxLength(4),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->required()
                            ->default('draft')
                            ->options([
                                'draft'     => 'Draft',
                                'submitted' => 'Diajukan',
                                'reviewed'  => 'Ditinjau',
                                'approved'  => 'Disetujui',
                                'need_revision' => 'Perlu Revisi',
                            ]),
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan')
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Jobdesc')
                    ->description('Data penugasan proyek')
                    ->schema([
                        Forms\Components\Repeater::make('jobdescs')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('penilaian_koefisien_ontime_onbudget')
                                    ->label('Koefisien On Time & On Budget')
                                    ->required()
                                    ->options([
                                        0   => '0 - Tidak Tepat',
                                        0.5 => '0.5 - Kurang Tepat',
                                        1   => '1 - Tepat',
                                        1.5 => '1.5 - Sangat Tepat',
                                        2   => '2 - Luar Biasa',
                                    ])
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $ontime = (float) ($state ?? 0);
                                        $grade  = (float) ($get('penilaian_grade_project') ?? 0);
                                        $jumlah = $ontime + $grade;
                                        $set('jumlah_koefisien', $jumlah);
                                        $mandays = (float) ($get('mandays_proyek') ?? 0);
                                        $set('total_mandays_penugasan', $jumlah * $mandays);
                                    }),
                                Forms\Components\Select::make('penilaian_grade_project')
                                    ->label('Grade Project')
                                    ->required()
                                    ->options([
                                        0   => '0 - Tidak Memuaskan',
                                        0.5 => '0.5 - Cukup',
                                        1   => '1 - Baik',
                                        1.5 => '1.5 - Sangat Baik',
                                        2   => '2 - Excellent',
                                    ])
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $ontime = (float) ($get('penilaian_koefisien_ontime_onbudget') ?? 0);
                                        $grade  = (float) ($state ?? 0);
                                        $jumlah = $ontime + $grade;
                                        $set('jumlah_koefisien', $jumlah);
                                        $mandays = (float) ($get('mandays_proyek') ?? 0);
                                        $set('total_mandays_penugasan', $jumlah * $mandays);
                                    }),
                                Forms\Components\TextInput::make('nama_kegiatan_bukti')
                                    ->label('Nama Kegiatan / Bukti')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('mandays_proyek')
                                    ->label('Mandays Proyek')
                                    ->numeric()
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $ontime = (float) ($get('penilaian_koefisien_ontime_onbudget') ?? 0);
                                        $grade  = (float) ($get('penilaian_grade_project') ?? 0);
                                        $jumlah = $ontime + $grade;
                                        $set('jumlah_koefisien', $jumlah);
                                        $mandays = (float) ($state ?? 0);
                                        $set('total_mandays_penugasan', $jumlah * $mandays);
                                    }),
                                Forms\Components\TextInput::make('jumlah_koefisien')
                                    ->label('Jumlah Koefisien')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->numeric(),
                                Forms\Components\TextInput::make('total_mandays_penugasan')
                                    ->label('Total Mandays')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->numeric(),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Baris Jobdesc'),
                    ]),

                Forms\Components\Section::make('Continuous Improvement')
                    ->schema([
                        Forms\Components\Repeater::make('continuesImprovements')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('jenis_kegiatan_bukti')
                                    ->label('Jenis Kegiatan')
                                    ->required()
                                    ->options(array_combine($ciOptions, $ciOptions))
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $koef = KpiContinuesImprovement::$koefisienMap[$state] ?? 0.5;
                                        $set('koefisien', $koef);
                                        $mandays = (float) ($get('mandays') ?? 0);
                                        $set('point', $koef * $mandays);
                                    }),
                                Forms\Components\TextInput::make('kegiatan')
                                    ->label('Kegiatan')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('mandays')
                                    ->label('Mandays')
                                    ->numeric()
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $koef    = (float) ($get('koefisien') ?? 0);
                                        $mandays = (float) ($state ?? 0);
                                        $set('point', $koef * $mandays);
                                    }),
                                Forms\Components\TextInput::make('koefisien')
                                    ->label('Koefisien')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->numeric()
                                    ->step(0.0001),
                                Forms\Components\TextInput::make('point')
                                    ->label('Point')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->numeric()
                                    ->step(0.0001),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Baris CI'),
                    ]),

                Forms\Components\Section::make('Self Development')
                    ->schema([
                        Forms\Components\Repeater::make('selfDevelopments')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('jenis_sd')
                                    ->label('Jenis SD')
                                    ->required()
                                    ->options(array_combine($sdOptions, $sdOptions))
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $koef = KpiSelfDevelopment::$koefisienMap[$state] ?? 0.5;
                                        $set('koefisien', $koef);
                                        $mandays = (float) ($get('mandays') ?? 0);
                                        $set('point', $koef * $mandays);
                                    }),
                                Forms\Components\TextInput::make('kegiatan')
                                    ->label('Kegiatan')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('mandays')
                                    ->label('Mandays')
                                    ->numeric()
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $koef    = (float) ($get('koefisien') ?? 0);
                                        $mandays = (float) ($state ?? 0);
                                        $set('point', $koef * $mandays);
                                    }),
                                Forms\Components\TextInput::make('koefisien')
                                    ->label('Koefisien')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->numeric()
                                    ->step(0.0001),
                                Forms\Components\TextInput::make('point')
                                    ->label('Point')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->numeric()
                                    ->step(0.0001),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Baris SD'),
                    ]),

                Forms\Components\Section::make('HR Activity')
                    ->schema([
                        Forms\Components\Repeater::make('hrActivities')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('jenis_kegiatan')
                                    ->label('Jenis Kegiatan')
                                    ->required()
                                    ->options(array_combine($hrOptions, $hrOptions))
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $koef = KpiHrActivity::$koefisienMap[$state] ?? 0.5;
                                        $set('koefisien', $koef);
                                        $mandays = (float) ($get('mandays') ?? 0);
                                        $set('point', $koef * $mandays);
                                    }),
                                Forms\Components\TextInput::make('kegiatan')
                                    ->label('Kegiatan')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('mandays')
                                    ->label('Mandays')
                                    ->numeric()
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $koef    = (float) ($get('koefisien') ?? 0);
                                        $mandays = (float) ($state ?? 0);
                                        $set('point', $koef * $mandays);
                                    }),
                                Forms\Components\TextInput::make('koefisien')
                                    ->label('Koefisien')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->numeric()
                                    ->step(0.0001),
                                Forms\Components\TextInput::make('point')
                                    ->label('Point')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->numeric()
                                    ->step(0.0001),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Baris HR Activity'),
                    ]),

                Forms\Components\Section::make('Kinerja Perilaku')
                    ->description('Penilaian aspek perilaku berdasarkan master data')
                    ->schema([
                        Forms\Components\Repeater::make('kinerjaPerilakus')
                            ->label('')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('aspek_kinerja')
                                    ->label('Aspek')
                                    ->disabled()
                                    ->dehydrated(false),
                                Forms\Components\TextInput::make('definisi')
                                    ->label('Definisi')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('minimum_capaian')
                                    ->label('Min. Capaian')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->numeric(),
                                Forms\Components\TextInput::make('score')
                                    ->label('Score')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->maxValue(100),
                                Forms\Components\TextInput::make('indikator')
                                    ->label('Indikator')
                                    ->disabled()
                                    ->dehydrated(false),
                                Forms\Components\Textarea::make('deskripsi')
                                    ->label('Deskripsi')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Aspek Perilaku')
                            ->disabled(fn (string $operation): bool => $operation === 'create'),
                    ]),
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
                    ->label('Periode')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft'        => 'Draft',
                        'submitted'    => 'Diajukan',
                        'reviewed'     => 'Ditinjau',
                        'approved'     => 'Disetujui',
                        'need_revision'=> 'Perlu Revisi',
                        default        => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('total_score')
                    ->label('Total Skor')
                    ->numeric(2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Diajukan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft'        => 'Draft',
                        'submitted'    => 'Diajukan',
                        'reviewed'     => 'Ditinjau',
                        'approved'     => 'Disetujui',
                        'need_revision'=> 'Perlu Revisi',
                    ]),
                Tables\Filters\SelectFilter::make('period_year')
                    ->label('Tahun')
                    ->options(fn () => KpiDocument::distinct()->pluck('period_year', 'period_year')->sort()->toArray()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index'  => Pages\ListKpiDocuments::route('/'),
            'create' => Pages\CreateKpiDocument::route('/create'),
            'view'   => Pages\ViewKpiDocument::route('/{record}'),
            'edit'   => Pages\EditKpiDocument::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (Auth::user()->isStaff()) {
            return $query->where('user_id', Auth::id());
        }

        return $query;
    }
}
