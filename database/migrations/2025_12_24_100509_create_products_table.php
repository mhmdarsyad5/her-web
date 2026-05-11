<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // SEO & Control
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            // Multibahasa
            $table->string('name_id');
            $table->string('name_en')->nullable();

            $table->longText('description_id')->nullable();
            $table->longText('description_en')->nullable();

            // Harga
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('sale_price', 15, 2)->nullable();

            // Media (multi image upload, image pertama = thumbnail)
            $table->json('images')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
