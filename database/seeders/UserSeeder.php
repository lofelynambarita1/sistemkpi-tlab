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
            ['name' => 'Rian Pratama',   'email' => 'rian.associate@company.com',    'role' => 'associate',    'jabatan' => 'Software Engineer'],
            ['name' => 'Dewi Lestari',   'email' => 'dewi.intermediate@company.com',  'role' => 'intermediate', 'jabatan' => 'Senior Engineer'],
            ['name' => 'Andi Wijaya',    'email' => 'andi.senior@company.com',        'role' => 'senior',       'jabatan' => 'Staff Engineer'],
            ['name' => 'Sari Indah',     'email' => 'sari.principle@company.com',     'role' => 'principle',    'jabatan' => 'Principal Engineer'],
            ['name' => 'Budi Santosa',   'email' => 'budi.lead@company.com',          'role' => 'lead',         'jabatan' => 'Team Lead'],
            // Admin & HR
            ['name' => 'Maya Putri',     'email' => 'maya.leadhr@company.com',        'role' => 'lead_hr',      'jabatan' => 'HR Lead'],
            ['name' => 'Hendra Kusuma',  'email' => 'hendra.manager@company.com',     'role' => 'manager',      'jabatan' => 'Engineering Manager'],
            ['name' => 'Tata Permana',   'email' => 'tata.admin@company.com',         'role' => 'admin',        'jabatan' => 'System Administrator'],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'        => $data['name'],
                    'password'    => Hash::make('password123'),
                    'role'        => $data['role'],
                    'jabatan'     => $data['jabatan'] ?? match($data['role']) {
                        'lead_hr' => 'HR Lead',
                        'manager' => 'Manager',
                        'admin'   => 'Administrator',
                        default   => 'Staff',
                    },
                    'employee_id' => strtoupper(substr($data['role'], 0, 3)) . rand(1000, 9999),
                    'department'  => match($data['role']) {
                        'lead_hr' => 'Human Resources',
                        'manager' => 'Management',
                        'admin'   => 'Information Technology',
                        default   => 'Engineering',
                    },
                ]
            );

            // Buat annual target untuk staff (termasuk lead dan lead_hr yang juga mengisi KPI)
            if (in_array($data['role'], ['associate', 'intermediate', 'senior', 'lead', 'principle', 'lead_hr'])) {
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
