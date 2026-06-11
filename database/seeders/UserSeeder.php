<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KpiAnnualTarget;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $year = date('Y');

        $users = [
            // Staff
            ['name' => 'Budi Santoso',    'email' => 'budi@example.com',    'role' => 'associate'],
            ['name' => 'Sari Dewi',       'email' => 'sari@example.com',    'role' => 'intermediate'],
            ['name' => 'Andi Pratama',    'email' => 'andi@example.com',    'role' => 'senior'],
            ['name' => 'Rina Kusuma',     'email' => 'rina@example.com',    'role' => 'lead'],
            ['name' => 'Doni Wijaya',     'email' => 'doni@example.com',    'role' => 'principle'],
            // Admin roles
            ['name' => 'Hana Fitriani',  'email' => 'hr@example.com',      'role' => 'hr'],
            ['name' => 'Bima Aditya',    'email' => 'manager@example.com', 'role' => 'manager'],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'        => $data['name'],
                    'password'    => Hash::make('password123'),
                    'role'        => $data['role'],
                    'employee_id' => strtoupper(substr($data['role'], 0, 3)) . rand(1000, 9999),
                    'department'  => match($data['role']) {
                        'hr'      => 'Human Resources',
                        'manager' => 'Management',
                        default   => 'Engineering',
                    },
                ]
            );

            // Buat annual target untuk staff
            if (in_array($data['role'], ['associate', 'intermediate', 'senior', 'lead', 'principle'])) {
                KpiAnnualTarget::firstOrCreate(
                    ['user_id' => $user->id, 'period_year' => $year],
                    [
                        'target_jobdesc'               => 100,
                        'target_continues_improvement' => 50,
                        'target_self_development'      => 50,
                        'target_hr_activity'           => 30,
                        'target_kinerja_perilaku'      => 100,
                        'target_total'                 => 330,
                    ]
                );
            }
        }
    }
}
