<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedBigInteger('price_snapshot'); // harga saat ditambahkan, untuk histori
            $table->string('variant')->nullable(); // ukuran/rasa jika ada
            $table->timestamps();

            $table->unique(['user_id', 'product_id', 'variant']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
