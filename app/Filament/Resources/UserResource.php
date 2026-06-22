<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $pluralLabel = 'Pengguna';

    protected static ?string $modelLabel = 'Pengguna';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
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
                            ->confirmed(),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password')
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Data Karyawan')
                    ->schema([
                        Forms\Components\Select::make('role')
                            ->label('Role')
                            ->required()
                            ->options([
                                'associate'    => 'Associate',
                                'intermediate' => 'Intermediate',
                                'senior'       => 'Senior',
                                'lead'         => 'Lead',
                                'principle'    => 'Principle',
                                'lead_hr'      => 'Lead HR',
                                'hr'           => 'HR',
                                'manager'      => 'Manager',
                                'admin'        => 'Admin',
                            ]),
                        Forms\Components\TextInput::make('employee_id')
                            ->label('NIK')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('atasan_id')
                            ->label('Atasan')
                            ->relationship('atasan', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('department')
                            ->label('Divisi')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->maxLength(255),
                        Forms\Components\Select::make('status_akun')
                            ->label('Status Akun')
                            ->required()
                            ->options([
                                'aktif'   => 'Aktif',
                                'nonaktif' => 'Nonaktif',
                            ]),
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin'        => 'danger',
                        'manager'      => 'warning',
                        'lead_hr'      => 'info',
                        'lead'         => 'primary',
                        'principle'    => 'success',
                        'senior'       => 'success',
                        'intermediate' => 'gray',
                        'associate'    => 'gray',
                        default        => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'associate'    => 'Associate',
                        'intermediate' => 'Intermediate',
                        'senior'       => 'Senior',
                        'lead'         => 'Lead',
                        'principle'    => 'Principle',
                        'lead_hr'      => 'Lead HR',
                        'hr'           => 'HR',
                        'manager'      => 'Manager',
                        'admin'        => 'Admin',
                        default        => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('department')
                    ->label('Divisi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('atasan.name')
                    ->label('Atasan')
                    ->default('-'),
                Tables\Columns\TextColumn::make('status_akun')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'aktif' ? 'success' : 'danger')
                    ->formatStateUsing(fn (string $state): string => $state === 'aktif' ? 'Aktif' : 'Nonaktif'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'associate'    => 'Associate',
                        'intermediate' => 'Intermediate',
                        'senior'       => 'Senior',
                        'lead'         => 'Lead',
                        'principle'    => 'Principle',
                        'lead_hr'      => 'Lead HR',
                        'hr'           => 'HR',
                        'manager'      => 'Manager',
                        'admin'        => 'Admin',
                    ]),
                Tables\Filters\SelectFilter::make('status_akun')
                    ->label('Status')
                    ->options([
                        'aktif'   => 'Aktif',
                        'nonaktif' => 'Nonaktif',
                    ]),
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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
