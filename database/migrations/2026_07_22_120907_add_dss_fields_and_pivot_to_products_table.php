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
            $table->unsignedInteger('min_capacity_kg')->nullable()->after('load_capacity');
            $table->unsignedInteger('max_capacity_kg')->nullable()->after('min_capacity_kg');
            $table->unsignedInteger('max_lift_height_mm')->nullable()->after('max_capacity_kg');
        });

        Schema::create('dss_criteria_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('dss_criteria_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('dss_criteria_id')->references('id')->on('dss_criteria')->onDelete('cascade');

            $table->unique(['product_id', 'dss_criteria_id'], 'prod_crit_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dss_criteria_product');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['min_capacity_kg', 'max_capacity_kg', 'max_lift_height_mm']);
        });
    }
};
