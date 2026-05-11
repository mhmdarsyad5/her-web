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
        Schema::table('dss_rules', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['equipment_id']);
            $table->dropColumn('equipment_id');

            // Add standalone product details
            $table->string('product_name')->after('id');
            $table->string('category_name')->nullable()->after('product_name');
            $table->string('brand')->nullable()->after('category_name');
            $table->string('model')->nullable()->after('brand');
            $table->string('image')->nullable()->after('model');
            $table->json('display_specifications')->nullable()->after('conditions');
            
            // Rename 'name' column if it exists to avoid confusion with product_name
            // Or just keep it as rule_name description
            $table->string('name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dss_rules', function (Blueprint $table) {
            $table->unsignedBigInteger('equipment_id')->nullable()->after('id');
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
            
            $table->dropColumn([
                'product_name',
                'category_name',
                'brand',
                'model',
                'image',
                'display_specifications',
            ]);
        });
    }
};
