<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name')->default('System');
            $table->string('action'); // 'create', 'update', 'delete', 'upload', 'move', 'login'
            $table->string('subject_type')->nullable(); // 'Product', 'Media', 'Setting', etc.
            $table->string('subject_id')->nullable();
            $table->text('description');
            $table->string('ip_address')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();

            $table->index(['created_at', 'action']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
