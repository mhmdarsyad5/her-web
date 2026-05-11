<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_maintenances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('equipment_id')
                ->constrained('equipment')
                ->cascadeOnDelete();

            $table->foreignId('performed_by')            // Teknisi / admin
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('maintenance_type', ['routine', 'repair', 'inspection'])
                ->default('routine');

            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('cost', 15, 2)->default(0);

            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('next_maintenance_date')->nullable();

            $table->enum('status', ['scheduled', 'in_progress', 'completed'])
                ->default('scheduled');

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_maintenances');
    }
};
