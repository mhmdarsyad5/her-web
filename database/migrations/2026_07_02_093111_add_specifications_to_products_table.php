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
            $table->string('tagline')->nullable()->after('description_id');
            $table->string('battery_type')->nullable()->after('tagline');
            $table->string('lift_height')->nullable()->after('battery_type');
            $table->string('load_capacity')->nullable()->after('lift_height');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['tagline', 'battery_type', 'lift_height', 'load_capacity']);
        });
    }
};
