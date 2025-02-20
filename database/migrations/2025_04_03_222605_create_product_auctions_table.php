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
        Schema::create('product_auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->enum('status', [
                'inactive',
                'active',
                'completed',
                'cancelled',
                'sold'
            ])->default('inactive');
            $table->decimal('price', total:14, places:4);
            $table->datetime('start');
            $table->datetime('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_auctions');
    }
};
