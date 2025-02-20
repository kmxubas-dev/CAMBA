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
        Schema::create('product_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->constrained('product_auctions');
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('amount', total:14, places:4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_bids');
    }
};
