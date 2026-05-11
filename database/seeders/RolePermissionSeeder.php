<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);

        // Asumsinya semua permission sudah dibuat otomatis oleh Filament Shield
        $admin->givePermissionTo(Permission::all());

        // Editor belum dikasih permission, nanti assign manual via UI
    }
}
