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
        // DSS Criteria - Stores form field options (lokasi, industri, berat, etc)
        Schema::create('dss_criteria', function (Blueprint $table) {
            $table->id();
            $table->string('field_type'); // 'location', 'industry', 'cargo_type', 'weight', 'unit', 'aisle', 'energy', 'operator', 'height'
            $table->string('code'); // 'indoor', 'outdoor', 'warehouse', etc.
            $table->string('name'); // Indonesian display name
            $table->json('equipment_map')->nullable(); // Maps criteria to equipment specification filters
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Composite unique: field_type + code (same code can exist for different field types)
            $table->unique(['field_type', 'code']);
            $table->index(['field_type', 'is_active']);
            $table->index('field_type');
        });

        // DSS Rules - Maps user input combinations to equipment recommendations
        Schema::create('dss_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id');
            $table->string('name'); // Rule description, e.g., "Lithium Indoor Forklift 1-3t"
            $table->json('conditions'); // Rule condition combinations {location: [...], energy: '...', ...}
            $table->integer('priority')->default(0); // Higher priority = better match
            $table->integer('relevance_score')->default(100); // Weight for ranking (0-100)
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
            $table->index(['equipment_id', 'is_active']);
            $table->index(['is_active', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dss_rules');
        Schema::dropIfExists('dss_criteria');
    }
};
