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
        Schema::table('pages', function (Blueprint $table) {
            $table->string('status')->default('draft')->after('category_id');
            $table->string('seo_title')->nullable()->after('content');
            $table->text('meta_description')->nullable()->after('seo_title');
            $table->text('meta_keywords')->nullable()->after('meta_description');
        });

        // Migrate existing is_published column data to status
        \Illuminate\Support\Facades\DB::table('pages')->where('is_published', true)->update(['status' => 'published']);
        \Illuminate\Support\Facades\DB::table('pages')->where('is_published', false)->update(['status' => 'draft']);

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('is_published')->default(false)->after('category_id');
        });

        \Illuminate\Support\Facades\DB::table('pages')->where('status', 'published')->update(['is_published' => true]);

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['status', 'seo_title', 'meta_description', 'meta_keywords']);
        });
    }
};
