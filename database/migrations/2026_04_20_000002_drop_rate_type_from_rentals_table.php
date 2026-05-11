<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('rentals', 'rate_type')) {
            Schema::table('rentals', function (Blueprint $table) {
                $table->dropColumn('rate_type');
            });
        }
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->enum('rate_type', ['daily', 'weekly', 'monthly', 'yearly'])->default('monthly')->after('duration_days');
        });
    }
};
