<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('invoice_no')->unique();
            $table->unsignedBigInteger('total_price');
            $table->enum('status', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])
                ->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, failed
            $table->text('shipping_address');
            $table->string('shipping_name');
            $table->string('shipping_phone');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('invoice_no');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
