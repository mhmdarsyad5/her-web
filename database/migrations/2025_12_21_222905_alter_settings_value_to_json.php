<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Bungkus value lama jadi JSON string
        DB::statement("
        UPDATE settings
        SET value = JSON_QUOTE(value)
        WHERE value IS NOT NULL
          AND JSON_VALID(value) = 0
    ");

        DB::statement("
        ALTER TABLE settings
        MODIFY value JSON NULL
    ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE settings
            MODIFY value TEXT NULL
        ");
    }
};
