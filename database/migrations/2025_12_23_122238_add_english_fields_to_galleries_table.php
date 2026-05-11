<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {

            // ================= ENGLISH FIELDS =================
            $table->string('title_en')
                ->nullable()
                ->after('title');

            $table->text('description_en')
                ->nullable()
                ->after('description');

            $table->json('tags_en')
                ->nullable()
                ->after('tags');
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn([
                'title_en',
                'description_en',
                'tags_en',
            ]);
        });
    }
};
