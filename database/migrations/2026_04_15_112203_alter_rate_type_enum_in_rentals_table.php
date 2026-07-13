<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE rentals MODIFY COLUMN rate_type ENUM('daily', 'weekly', 'monthly', 'yearly') DEFAULT 'yearly'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE rentals MODIFY COLUMN rate_type ENUM('daily', 'weekly', 'monthly') DEFAULT 'daily'");
    }
};
