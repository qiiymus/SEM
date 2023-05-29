<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id', 100)->unique();
            $table->string('product_name', 100);
            $table->float('product_cost', 9, 2);
            $table->float('product_price', 9, 2);
            $table->integer('product_quantity');
            $table->string('product_category', 100);
            $table->string('product_brand', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
