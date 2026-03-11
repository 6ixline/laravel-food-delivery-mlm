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
        Schema::create('sk_product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id")->required();
            $table->text("title")->required();
            $table->integer("qty")->default(1);
            $table->text("unit")->nullable();
            $table->decimal("mrp", 8, 2)->required();
            $table->decimal("price", 8, 2)->required();
            $table->decimal("business_volume", 8, 2)->required();
            $table->enum('status', ['active', 'inactive']);    
            $table->timestamps();
            $table->foreign("product_id")->references("id")->on("sk_products")->onDelete("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_product_variants');
    }
};
