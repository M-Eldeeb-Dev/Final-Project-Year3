<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->string('product_name');
            $table->decimal('product_price', 8, 2);
            $table->string('selected_size')->nullable();
            $table->string('selected_color')->nullable();
            $table->integer('quantity');
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
