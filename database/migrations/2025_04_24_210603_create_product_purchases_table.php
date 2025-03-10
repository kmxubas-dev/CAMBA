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
        Schema::create('product_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('product_id')->constrained('products');
            $table->morphs('purchasable');
            $table->decimal('amount', total:14, places:4);
            $table->string('status')->default('pending');
            $table->json('purchase_info')->nullable(); // { code, product_snapshot, etc. }
            $table->json('payment_info')->nullable(); // { method, status, reference }
            $table->timestamps();

            // Optimization Note: 
            // 1. Later, consider adding virtual columns and indexes for frequently queried fields, 
            //    such as 'status' (from purchase_info) and 'payment_status' (from payment_info), 
            //    to speed up filtering and ordering operations.
            // 2. You can use virtual columns with expressions like:
            //    - $table->string('status')->virtualAs("json_unquote(json_extract(purchase_info, '$.status'))");
            //    - $table->index('status');
            // 3. Only move fields to normal columns if performance becomes a concern with growing data.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_purchases');
    }
};
