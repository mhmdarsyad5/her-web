<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Drop dss_rules table
        Schema::dropIfExists('dss_rules');

        // 2. Delete all records in dss_criteria where field_type is not 'industry'
        DB::table('dss_criteria')->where('field_type', '!=', 'industry')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Destructive drop migration, no rollback necessary
    }
};
