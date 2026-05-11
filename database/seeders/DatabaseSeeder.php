<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role admin dulu (kalau belum ada)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Buat user admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin Mulai Digital Offcial',
                'password' => bcrypt('admin@mail.com'), // Ganti kalau mau lebih aman
            ]
        );

        // Assign role admin
        $admin->assignRole($adminRole);

        // Jalankan SettingsSeeder
        $this->call(SettingsSeeder::class);
        $this->call(HeroSectionSeeder::class);
    }
}
