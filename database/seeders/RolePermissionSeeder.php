<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ─── Buat semua role ──────────────────────────────────
        $roles = [
            'super_admin',
            'admin',
            'manager',
            'principal',
            'lead',
            'lead_hr',
            'senior',
            'intermediate',
            'associate',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // ─── Generate permission Shield ───────────────────────
        // Jalankan dulu: php artisan shield:generate --all
        // Setelah itu, assign permission ke role:

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(Permission::all());

        $manager = Role::findByName('manager');
        $managerPermissions = Permission::where('name', 'like', 'view_%')
            ->orWhere('name', 'like', '%_master_%')
            ->get()
            ->filter(fn ($p) => str_starts_with($p->name, 'view'));
        $manager->syncPermissions($managerPermissions);

        // Role lain tidak punya permission Admin Panel
        // (lead, lead_hr, principal, senior, intermediate, associate)
    }
}