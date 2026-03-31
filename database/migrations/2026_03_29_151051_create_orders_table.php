<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->text('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_country');
            $table->string('shipping_zip')->nullable();
            $table->decimal('shipping_cost', 8, 2)->default(0);
            $table->decimal('tax', 8, 2)->default(0);
            $table->decimal('total', 8, 2);
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->enum('payment_method', ['cod', 'credit'])->default('cod');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
