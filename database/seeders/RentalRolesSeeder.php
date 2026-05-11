<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RentalRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ── PERMISSIONS ──────────────────────────────────────────────
        $permissions = [
            // Alat
            'view_equipment',
            'create_equipment',
            'edit_equipment',
            'delete_equipment',

            // Kategori
            'view_equipment_category',
            'create_equipment_category',
            'edit_equipment_category',
            'delete_equipment_category',

            // Customer
            'view_customer',
            'create_customer',
            'edit_customer',
            'delete_customer',

            // Rental
            'view_rental',
            'create_rental',
            'edit_rental',
            'delete_rental',
            'activate_rental',
            'return_rental',
            'cancel_rental',

            // Maintenance
            'view_maintenance',
            'create_maintenance',
            'edit_maintenance',
            'delete_maintenance',
            'complete_maintenance',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // ── ROLES ── ─────────────────────────────────────────────────

        // Super Admin → semua permission (via Gate::before di shield)
        Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        // Manager → lihat semua + approve/return rental
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $manager->givePermissionTo([
            'view_equipment', 'edit_equipment',
            'view_equipment_category',
            'view_customer', 'create_customer', 'edit_customer',
            'view_rental', 'create_rental', 'edit_rental',
            'activate_rental', 'return_rental', 'cancel_rental',
            'view_maintenance', 'create_maintenance', 'edit_maintenance', 'complete_maintenance',
        ]);

        // Staff → input & update rental, lihat alat
        $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $staff->givePermissionTo([
            'view_equipment',
            'view_customer', 'create_customer',
            'view_rental', 'create_rental', 'edit_rental',
            'activate_rental', 'return_rental',
            'view_maintenance',
        ]);

        // Teknisi → hanya maintenance
        $teknisi = Role::firstOrCreate(['name' => 'teknisi', 'guard_name' => 'web']);
        $teknisi->givePermissionTo([
            'view_equipment',
            'view_maintenance', 'create_maintenance', 'edit_maintenance', 'complete_maintenance',
        ]);

        $this->command->info('✅ Rental roles & permissions berhasil dibuat:');
        $this->command->info('   Roles: super_admin, manager, staff, teknisi');
    }
}
