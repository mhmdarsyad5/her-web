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
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['daily_rate', 'weekly_rate', 'monthly_rate']);
            $table->decimal('yearly_rate', 15, 2)->nullable()->after('condition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn('yearly_rate');
            $table->decimal('daily_rate', 15, 2)->nullable();
            $table->decimal('weekly_rate', 15, 2)->nullable();
            $table->decimal('monthly_rate', 15, 2)->nullable();
        });
    }
};
