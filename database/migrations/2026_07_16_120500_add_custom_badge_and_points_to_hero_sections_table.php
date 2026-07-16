<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->string('badge_large')->nullable()->default('24/7');
            $table->string('badge_small')->nullable()->default('Teknisi Siaga');
            $table->json('key_points')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->dropColumn(['badge_large', 'badge_small', 'key_points']);
        });
    }
};
