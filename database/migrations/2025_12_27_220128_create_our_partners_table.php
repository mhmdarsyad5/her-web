<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('our_partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo'); // simpan path / filename image
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('our_partners');
    }
};
