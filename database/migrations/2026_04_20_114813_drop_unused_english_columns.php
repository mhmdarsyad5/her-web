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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'description_en']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'description_en']);
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'description_en', 'tags_en']);
        });

        Schema::table('hero_sections', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'description_en', 'button_text_en']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_en')->nullable();
            $table->longText('description_en')->nullable();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('name_en')->nullable();
            $table->longText('description_en')->nullable();
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->string('title_en')->nullable();
            $table->text('description_en')->nullable();
            $table->json('tags_en')->nullable();
        });

        Schema::table('hero_sections', function (Blueprint $table) {
            $table->string('title_en')->nullable();
            $table->text('description_en')->nullable();
            $table->string('button_text_en')->nullable();
        });
    }
};
