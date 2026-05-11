<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('customer_type', ['individual', 'company'])->default('individual');
            $table->string('company_name')->nullable();
            $table->string('phone');                     // No. HP / WA
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('id_number')->nullable();     // No. KTP / NPWP
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
