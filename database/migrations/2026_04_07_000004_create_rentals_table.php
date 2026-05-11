<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->string('rental_code')->unique();     // RNT-2026-0001

            $table->foreignId('equipment_id')
                ->constrained('equipment')
                ->restrictOnDelete();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            $table->foreignId('operator_id')            // Admin/staff yg input
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('rental_start');
            $table->date('rental_end');                  // Estimasi kembali
            $table->date('actual_return')->nullable();   // Tanggal kembali aktual
            $table->unsignedInteger('duration_days');

            $table->enum('rate_type', ['daily', 'weekly', 'monthly'])->default('daily');
            $table->decimal('rate_amount', 15, 2);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->decimal('deposit', 15, 2)->default(0);

            $table->enum('status', ['pending', 'active', 'returned', 'overdue', 'cancelled'])
                ->default('pending');

            $table->text('notes')->nullable();
            $table->text('return_notes')->nullable();
            $table->enum('return_condition', ['excellent', 'good', 'damaged'])->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
