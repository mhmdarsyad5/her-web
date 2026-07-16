<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \App\Models\Setting::set('social_facebook', 'https://facebook.com', 'text', 'system');
        \App\Models\Setting::set('social_instagram', 'https://instagram.com', 'text', 'system');
        \App\Models\Setting::set('social_tiktok', 'https://tiktok.com', 'text', 'system');
        \App\Models\Setting::set('social_linkedin', 'https://linkedin.com', 'text', 'system');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\Setting::whereIn('key', [
            'social_facebook',
            'social_instagram',
            'social_tiktok',
            'social_linkedin',
        ])->delete();
    }
};
