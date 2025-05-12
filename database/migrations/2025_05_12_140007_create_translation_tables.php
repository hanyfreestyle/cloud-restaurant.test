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
        // Create Category Translations table
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->uuid('category_id');
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
        });

        // Create Product Translations table
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->uuid('product_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();

            $table->unique(['product_id', 'locale']);
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('product_translations');
    }
};
