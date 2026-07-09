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
                'title' => 'Selamat Datang di Herro Equipment Rentals',
                'description' => 'Solusi persewaan forklift dan alat berat terbaik untuk kebutuhan operasional bisnis Anda.',
                'image' => 'hero/hero1.jpg',
                'button_text' => 'Pelajari Lebih Lanjut',
                'button_url' => '#tentang-kami',
                'created_at' => Carbon::create(2025, 11, 6, 4, 13, 50),
                'updated_at' => Carbon::create(2025, 11, 7, 7, 39, 51),
            ],
        ]);
    }
}
