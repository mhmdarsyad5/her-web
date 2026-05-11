<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class HeroSectionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hero_sections')->insert([
            [
                'title' => 'Selamat Datang di Mulai Digital',
                'description' => 'Kami membantu bisnis Anda tampil profesional dan terpercaya di dunia digital.',
                'image' => 'hero/hero1.jpg',
                'button_text' => 'Pelajari Lebih Lanjut',
                'button_url' => '#tentang-kami',
                'created_at' => Carbon::create(2025, 11, 6, 4, 13, 50),
                'updated_at' => Carbon::create(2025, 11, 7, 7, 39, 51),
            ],
            [
                'title' => 'Bangun Website Profesional Anda',
                'description' => 'Solusi cepat dan efisien untuk company profile yang modern dan responsif.',
                'image' => 'hero/hero2.jpg',
                'button_text' => 'Mulai Sekarang',
                'button_url' => '#kontak',
                'created_at' => Carbon::create(2025, 11, 7, 0, 10, 10),
                'updated_at' => Carbon::create(2025, 11, 7, 0, 10, 10),
            ],
        ]);
    }
}
