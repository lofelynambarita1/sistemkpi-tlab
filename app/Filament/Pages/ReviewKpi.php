<?php

namespace App\Filament\Pages;

use App\Models\KpiForm;
use App\Services\KpiService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Support\Facades\Auth;

class ReviewKpi extends Page implements Tables\Contracts\HasTable
{
    use InteractsWithTable;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Review KPI';

    protected static ?string $title = 'Review KPI';

    protected string $view = 'filament.pages.review-kpi';

    public function table(Table $table): Table
    {
        $reviewer = Auth::user();
        $query = KpiForm::with(['user', 'approvals.actor']);

        match ($reviewer->role) {
            'lead'    => $query->whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior']))
                               ->where('status', KpiForm::STATUS_WAITING_LEAD),
            'lead_hr' => $query->whereHas('user', fn($q) => $q->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle']))
                               ->where('status', KpiForm::STATUS_WAITING_LHR),
            'manager' => $query->where('status', KpiForm::STATUS_WAITING_MGR),
            default   => $query->whereRaw('1=0'),
        };

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Karyawan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.role')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'associate'    => 'Associate',
                        'intermediate' => 'Intermediate',
                        'senior'       => 'Senior',
                        'lead'         => 'Lead',
                        'principle'    => 'Principle',
                        'lead_hr'      => 'Lead HR',
                        default        => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'waiting_lead', 'waiting_lhr', 'waiting_mgr' => 'warning',
                        'approved' => 'success',
                        'need_revision' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => KpiForm::getStatusLabel($state)),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->form([
                        \Filament\Forms\Components\Textarea::make('komentar')
                            ->label('Komentar (opsional)'),
                    ])
                    ->action(function (KpiForm $record, array $data) {
                        $reviewer = Auth::user();
                        $service = app(KpiService::class);
                        match ($reviewer->role) {
                            'lead'    => $service->approveByLead($record, $reviewer, $data['komentar'] ?? null),
                            'lead_hr' => $service->approveByLeadHR($record, $reviewer, $data['komentar'] ?? null),
                            'manager' => $service->approveByManager($record, $reviewer, $data['komentar'] ?? null),
                        };
                        Notification::make()->title('KPI berhasil disetujui')->success()->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        \Filament\Forms\Components\Textarea::make('komentar')
                            ->label('Alasan')
                            ->required(),
                    ])
                    ->action(function (KpiForm $record, array $data) {
                        $reviewer = Auth::user();
                        $service = app(KpiService::class);
                        match ($reviewer->role) {
                            'lead'    => $service->rejectByLead($record, $reviewer, $data['komentar']),
                            'lead_hr' => $service->rejectByLeadHR($record, $reviewer, $data['komentar']),
                            'manager' => $service->rejectByManager($record, $reviewer, $data['komentar']),
                        };
                        Notification::make()->title('KPI ditolak')->danger()->send();
                    }),
            ])
            ->bulkActions([]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && in_array($user->role, ['lead', 'lead_hr', 'manager']);
    }
}
