<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('equipment_categories')
                ->restrictOnDelete();

            $table->string('code')->unique();            // Kode unik alat: EXC-001
            $table->string('name');                      // Nama alat
            $table->string('brand')->nullable();         // Merek
            $table->string('model')->nullable();         // Model/seri
            $table->year('year')->nullable();            // Tahun pembuatan
            $table->enum('condition', ['excellent', 'good', 'fair', 'poor'])->default('good');
            $table->enum('status', ['available', 'rented', 'maintenance', 'retired'])
                ->default('available');

            $table->text('description')->nullable();
            $table->json('specifications')->nullable();  // [{key, value}]
            $table->json('images')->nullable();           // Array path gambar

            // Harga
            $table->decimal('daily_rate', 15, 2)->nullable();
            $table->decimal('weekly_rate', 15, 2)->nullable();
            $table->decimal('monthly_rate', 15, 2)->nullable();
            $table->decimal('deposit', 15, 2)->nullable();

            $table->string('location')->nullable();      // Lokasi/gudang
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
