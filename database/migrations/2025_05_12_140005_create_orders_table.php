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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('restaurant_id');
            $table->uuid('table_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->enum('status', ['pending', 'preparing', 'ready', 'delivered', 'canceled'])->default('pending');
            $table->enum('payment_status', ['paid', 'unpaid', 'partially_paid'])->default('unpaid');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('restaurant_id')
                  ->references('id')
                  ->on('restaurants')
                  ->onDelete('cascade');
                  
            $table->foreign('table_id')
                  ->references('id')
                  ->on('tables')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
