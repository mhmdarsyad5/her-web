<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('equipment', 'yearly_rate') && ! Schema::hasColumn('equipment', 'monthly_rate')) {
            DB::statement('ALTER TABLE `equipment` CHANGE `yearly_rate` `monthly_rate` DECIMAL(15, 2) NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('equipment', 'monthly_rate') && ! Schema::hasColumn('equipment', 'yearly_rate')) {
            DB::statement('ALTER TABLE `equipment` CHANGE `monthly_rate` `yearly_rate` DECIMAL(15, 2) NULL');
        }
    }
};
