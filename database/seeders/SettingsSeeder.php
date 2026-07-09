<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->insert([
            ['key' => 'address', 'value' => json_encode(['id' => 'Jl. Raya No. 123, Bandung']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'phone_number', 'value' => json_encode(['id' => '022-1234567']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'whatsapp_number', 'value' => json_encode(['id' => '6281234567890']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'email', 'value' => json_encode(['id' => 'info@mulaisigigital.com']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'facebook', 'value' => json_encode(['id' => 'https://facebook.com/yourpage']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'instagram', 'value' => json_encode(['id' => 'https://instagram.com/yourpage']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'tiktok', 'value' => json_encode(['id' => 'https://tiktok.com/@yourpage']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'youtube', 'value' => json_encode(['id' => 'https://youtube.com/yourchannel']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'site_name', 'value' => json_encode(['id' => 'Nama Website Kamu']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'tagline', 'value' => json_encode(['id' => 'Tagline perusahaan kamu']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'google_maps_link', 'value' => json_encode(['id' => 'https://maps.google.com/?q=-6.123,107.123']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'latitude', 'value' => json_encode(['id' => '-6.123456']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'longitude', 'value' => json_encode(['id' => '107.123456']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'logo', 'value' => json_encode(['path' => 'settings/notion.svg']), 'type' => 'image', 'category' => 'branding', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'primary_color', 'value' => json_encode(['id' => '#2196F3']), 'type' => 'text', 'category' => 'theme', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'secondary_color', 'value' => json_encode(['id' => '#FFC107']), 'type' => 'text', 'category' => 'theme', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'footer_text', 'value' => json_encode(['id' => '© 2025 Nama Perusahaan. All rights reserved.']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'privacy_policy_url', 'value' => json_encode(['id' => '/privacy-policy']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'terms_and_conditions_url', 'value' => json_encode(['id' => '/terms-and-conditions']), 'type' => 'text', 'category' => 'general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'favicon', 'value' => json_encode(['path' => 'settings/figma.svg']), 'type' => 'image', 'category' => 'branding', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // =====================
            // BRANCH 1 - JAKARTA
            // =====================
            ['key' => 'branch_1_name', 'value' => json_encode(['id' => 'Kantor Pusat Jakarta']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_1_address', 'value' => json_encode(['id' => 'Jl. Raya Jakarta No. 123, Jakarta Pusat']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_1_whatsapp', 'value' => json_encode(['id' => '+62 812-3456-7890']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_1_email', 'value' => json_encode(['id' => 'jakarta@herro.id']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_1_map_url', 'value' => json_encode(['id' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6358.383713724025!2d106.74264113880913!3d-6.109899402633105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6a1dca36259207%3A0x54c0df7074b21d11!2sPT%20Herro%20Dynamics%20Indonesia%20(PT%20HDI)!5e0!3m2!1sen!2sid!4v1705548787679!5m2!1sen!2sid']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // =====================
            // BRANCH 2 - BOGOR
            // =====================
            ['key' => 'branch_2_name', 'value' => json_encode(['id' => 'Cabang Bogor']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_2_address', 'value' => json_encode(['id' => 'Jl. Raya Bogor No. 456, Bogor']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_2_whatsapp', 'value' => json_encode(['id' => '+62 811-2345-6789']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_2_email', 'value' => json_encode(['id' => 'bogor@herro.id']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_2_map_url', 'value' => json_encode(['id' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4!2d106.816666!3d-6.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5e2b5c5c5c5%3A0x5c5c5c5c5c5c5c5!2sBogor%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1705548787679!5m2!1sen%2sid']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // =====================
            // BRANCH 3 - BANDUNG
            // =====================
            ['key' => 'branch_3_name', 'value' => json_encode(['id' => 'Cabang Bandung']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_3_address', 'value' => json_encode(['id' => 'Jl. Raya Bandung No. 789, Bandung']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_3_whatsapp', 'value' => json_encode(['id' => '+62 813-4567-8901']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_3_email', 'value' => json_encode(['id' => 'bandung@herro.id']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'branch_3_map_url', 'value' => json_encode(['id' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4!2d107.6!3d-6.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398255c5c5%3A0x5c5c5c5c5c5c5c5!2sBandung%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1705548787679!5m2!1sen%2sid']), 'type' => 'text', 'category' => 'contact', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // =====================
            // DSS / SPK RECOMMENDATION
            // =====================
            ['key' => 'dss_badge', 'value' => json_encode(['id' => '<p>Rekomendasi Alat</p>', 'is_active' => true]), 'type' => 'text', 'category' => 'sections', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'dss_title', 'value' => json_encode(['id' => '<p>Temukan Unit yang Tepat</p>', 'is_active' => true]), 'type' => 'text', 'category' => 'sections', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'dss_subtitle', 'value' => json_encode(['id' => '<p>Gunakan asisten rekomendasi kami untuk menemukan unit forklift atau reach truck yang ideal sesuai kebutuhan operasional Anda.</p>', 'is_active' => true]), 'type' => 'text', 'category' => 'sections', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // =====================
            // HOMEPAGE SERVICES SECTION VISIBILITY TOGGLES
            // =====================
            ['key' => 'service_show_image', 'value' => json_encode(['boolean_value' => true, 'is_active' => true]), 'type' => 'text', 'category' => 'sections', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'service_show_desc', 'value' => json_encode(['boolean_value' => true, 'is_active' => true]), 'type' => 'text', 'category' => 'sections', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
