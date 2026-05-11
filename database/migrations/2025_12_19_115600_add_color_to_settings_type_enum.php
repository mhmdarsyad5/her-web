<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE settings
            MODIFY COLUMN type ENUM('text', 'image', 'video', 'color')
            NOT NULL
            DEFAULT 'text'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE settings
            MODIFY COLUMN type ENUM('text', 'image', 'video')
            NOT NULL
            DEFAULT 'text'
        ");
    }
};
