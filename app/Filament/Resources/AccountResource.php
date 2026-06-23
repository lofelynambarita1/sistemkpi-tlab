<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use BackedEnum;
use Spatie\Permission\Models\Role;

class AccountResource extends Resource
{
    protected static ?string $model = User::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'Management Akun';

    protected static ?string $pluralLabel = 'Management Akun';

    protected static ?string $modelLabel = 'Akun';

    protected static ?string $slug = 'accounts';

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
                            ->label('Role (Legacy)')
                            ->helperText('Role untuk backward compatibility. Gunakan "Atur Role" untuk manajemen role berbasis Shield.')
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
                        Forms\Components\Select::make('roles')
                            ->label('Role (Shield)')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable(),
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
                Tables\Columns\TextColumn::make('department')
                    ->label('Divisi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin'  => 'danger',
                        'admin'        => 'danger',
                        'manager'      => 'warning',
                        'lead_hr'      => 'info',
                        'lead'         => 'primary',
                        'principle'    => 'success',
                        'senior'       => 'success',
                        'intermediate' => 'gray',
                        'associate'    => 'gray',
                        'hr'           => 'info',
                        default        => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'super_admin'  => 'Super Admin',
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
                Tables\Filters\SelectFilter::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),
                Tables\Filters\SelectFilter::make('status_akun')
                    ->label('Status')
                    ->options([
                        'aktif'   => 'Aktif',
                        'nonaktif' => 'Nonaktif',
                    ]),
                Tables\Filters\SelectFilter::make('department')
                    ->label('Divisi')
                    ->options(fn () => User::whereNotNull('department')->pluck('department', 'department')->toArray())
                    ->searchable(),
            ])
            ->actions([
                Action::make('view_detail')
                    ->label('View Detail')
                    ->icon('heroicon-o-eye')
                    ->url(fn (User $record): string => AccountResource::getUrl('view', ['record' => $record]))
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->label('Update Data')
                    ->icon('heroicon-o-pencil'),
                Action::make('atur_role')
                    ->label('Atur Role')
                    ->icon('heroicon-o-lock-closed')
                    ->color('warning')
                    ->form([
                        Forms\Components\Select::make('roles')
                            ->label('Role')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->required(),
                    ])
                    ->action(function (User $record, array $data): void {
                        $record->syncRoles($data['roles']);
                    })
                    ->modalHeading('Atur Role Pengguna')
                    ->modalSubmitActionLabel('Simpan'),
                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->modalHeading('Konfirmasi Hapus')
                        ->modalDescription('Apakah Anda yakin ingin menghapus pengguna yang dipilih? Tindakan ini tidak dapat dibatalkan.')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal'),
                    Tables\Actions\BulkAction::make('import_users')
                        ->label('Import Pengguna')
                        ->icon('heroicon-o-arrow-up-on-square')
                        ->color('success')
                        ->form([
                            FileUpload::make('file')
                                ->label('File Excel/CSV')
                                ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                                ->maxSize(5120)
                                ->required(),
                        ])
                        ->action(function (array $data): void {
                            $file = $data['file'];
                            if (!file_exists(storage_path('app/public/' . $file))) {
                                return;
                            }
                            // Process CSV/Excel
                            $path = storage_path('app/public/' . $file);
                            $rows = array_map('str_getcsv', file($path));
                            $header = array_shift($rows);

                            $imported = 0;
                            $errors = [];

                            foreach ($rows as $index => $row) {
                                $data = array_combine($header, $row);
                                try {
                                    $user = User::create([
                                        'name' => $data['name'] ?? '',
                                        'email' => $data['email'] ?? '',
                                        'password' => Hash::make($data['password'] ?? 'password123'),
                                        'role' => $data['role'] ?? 'associate',
                                        'employee_id' => $data['employee_id'] ?? null,
                                        'department' => $data['department'] ?? null,
                                        'jabatan' => $data['jabatan'] ?? null,
                                        'status_akun' => $data['status_akun'] ?? 'aktif',
                                    ]);

                                    if (!empty($data['roles'])) {
                                        $roles = array_map('trim', explode(',', $data['roles']));
                                        $user->assignRole($roles);
                                    } else {
                                        $user->assignRole($data['role'] ?? 'associate');
                                    }

                                    $imported++;
                                } catch (\Exception $e) {
                                    $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                                }
                            }

                            if (file_exists($path)) {
                                unlink($path);
                            }

                            $message = "Berhasil mengimport {$imported} pengguna.";
                            if (!empty($errors)) {
                                $message .= " Gagal: " . implode('; ', array_slice($errors, 0, 5));
                            }

                            \Filament\Notifications\Notification::make()
                                ->title('Hasil Import')
                                ->body($message)
                                ->success()
                                ->send();
                        })
                        ->modalHeading('Import Pengguna')
                        ->modalDescription('Upload file CSV/Excel dengan kolom: name, email, password, role, employee_id, department, jabatan, status_akun, roles')
                        ->modalSubmitActionLabel('Import'),
                ]),
            ])
            ->selectable()
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'view'   => Pages\ViewAccount::route('/{record}'),
            'edit'   => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
