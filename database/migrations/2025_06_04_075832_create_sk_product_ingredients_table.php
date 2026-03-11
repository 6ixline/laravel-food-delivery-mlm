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
        Schema::create('sk_product_ingredients', function (Blueprint $table) {
            $table->id();

            // Define the foreign key columns first
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variant_id')->nullable();
            $table->unsignedBigInteger('ingredients_id');

            // Then apply the foreign key constraints
            $table->foreign('product_id')
                ->references('id')
                ->on('sk_products')
                ->onDelete('cascade');

            $table->foreign('product_variant_id')
                ->references('id')
                ->on('sk_product_variants')
                ->onDelete('cascade');

            $table->foreign('ingredients_id')
                ->references('id')
                ->on('sk_ingredients')
                ->onDelete('cascade');
            $table->text("unit")->nullable();
            $table->integer("qty")->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_product_ingredients');
    }
};
