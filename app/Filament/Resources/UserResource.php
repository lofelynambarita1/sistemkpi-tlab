<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Kelola Pengguna';

    protected static ?string $pluralLabel = 'Pengguna';

    protected static ?string $modelLabel = 'Pengguna';

    public static function getNavigationIcon(): string|\BackedEnum|null
    {
        return 'heroicon-o-users';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'User';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'import',
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([

            Forms\Components\Section::make('Informasi Akun')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->minLength(8)
                        ->maxLength(255)
                        ->confirmed()
                        ->helperText('Kosongkan jika tidak ingin mengubah password'),

                    Forms\Components\TextInput::make('password_confirmation')
                        ->label('Konfirmasi Password')
                        ->password()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(false),
                ])
                ->columns(2),

            Forms\Components\Section::make('Data Karyawan')
                ->schema([
                    Forms\Components\TextInput::make('employee_id')
                        ->label('NIK')
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\Select::make('roles')
                        ->label('Role')
                        ->required()
                        ->options(
                            Role::whereNotIn('name', ['super_admin'])
                                ->pluck('name', 'name')
                                ->map(fn ($name) => ucfirst(str_replace('_', ' ', $name)))
                        )
                        ->searchable()
                        ->preload()
                        ->saveRelationshipsUsing(function (User $record, $state) {
                            $record->syncRoles([$state]);
                        })
                        ->afterStateHydrated(function (Forms\Components\Select $component, User $record) {
                            $component->state($record->roles->first()?->name);
                        }),

                    Forms\Components\Select::make('atasan_id')
                        ->label('Atasan')
                        ->relationship('atasan', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    Forms\Components\TextInput::make('department')
                        ->label('Divisi')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('jabatan')
                        ->label('Jabatan')
                        ->maxLength(255),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Status Aktif')
                        ->default(true)
                        ->onColor('success')
                        ->offColor('danger'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('employee_id')
                    ->label('NIK')
                    ->searchable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin', 'super_admin' => 'danger',
                        'manager'              => 'warning',
                        'lead_hr'              => 'info',
                        'lead'                 => 'primary',
                        'principal'            => 'success',
                        'senior'               => 'success',
                        'intermediate'         => 'gray',
                        'associate'            => 'gray',
                        default                => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),

                Tables\Columns\TextColumn::make('department')
                    ->label('Divisi')
                    ->searchable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('atasan.name')
                    ->label('Atasan')
                    ->default('-'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->options(
                        Role::whereNotIn('name', ['super_admin'])
                            ->pluck('name', 'name')
                            ->map(fn ($name) => ucfirst(str_replace('_', ' ', $name)))
                    ),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif')
                    ->placeholder('Semua'),

                Tables\Filters\SelectFilter::make('department')
                    ->label('Divisi')
                    ->options(
                        User::distinct()->pluck('department', 'department')->filter()->sort()
                    ),
            ])

            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('toggle_active')
                    ->label(fn (User $record): string => $record->is_active ? 'Nonaktifkan' : 'Aktifkan')
                    ->icon(fn (User $record): string => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (User $record): string => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn (User $record): string => $record->is_active ? 'Nonaktifkan Pengguna' : 'Aktifkan Pengguna')
                    ->modalDescription(fn (User $record): string => $record->is_active
                        ? "Yakin ingin menonaktifkan akun {$record->name}?"
                        : "Yakin ingin mengaktifkan kembali akun {$record->name}?")
                    ->action(function (User $record): void {
                        $record->update(['is_active' => ! $record->is_active]);
                        Notification::make()
                            ->title($record->is_active ? 'Akun diaktifkan' : 'Akun dinonaktifkan')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('reset_password')
                    ->label('Reset Password')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalDescription('Password baru akan dikirim ke email pengguna.')
                    ->action(function (User $record): void {
                        $newPassword = \Illuminate\Support\Str::random(10);
                        $record->update(['password' => Hash::make($newPassword)]);
                        Notification::make()
                            ->title('Password berhasil direset')
                            ->body("Password sementara: {$newPassword}")
                            ->warning()
                            ->persistent()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->modalDescription('Data pengguna akan dinonaktifkan (soft-delete).')
                    ->action(function (User $record): void {
                        $record->update(['is_active' => false]);
                    }),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Nonaktifkan Terpilih')
                        ->modalDescription('Pengguna yang dipilih akan dinonaktifkan.')
                        ->action(function ($records): void {
                            $records->each(fn (User $record) => $record->update(['is_active' => false]));
                        }),
                ]),
            ])

            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view'   => Pages\ViewUser::route('/{record}'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}