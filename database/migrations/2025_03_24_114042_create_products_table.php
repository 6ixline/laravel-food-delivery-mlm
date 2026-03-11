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
        Schema::create('sk_products', function (Blueprint $table) {
            $table->id();
            $table->text("name")->required();
            $table->unsignedBigInteger("category_id")->nullable();
            $table->unsignedBigInteger("kitchen_id")->required();
            $table->enum('pricing_mode', ['qty', 'variant'])->required();
            $table->decimal("mrp", 8, 2)->nullable();
            $table->decimal("price", 8, 2)->nullable();
            $table->decimal("business_volume", 8, 2)->nullable();
            $table->text("ingredients")->nullable();
            $table->text("description")->nullable();
            $table->text('imgName')->nullable();
            $table->boolean("isShowOnHome")->nullable()->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('deleted_at')->nullable(); // Added for soft delete
            $table->timestamps();
            $table->foreign("category_id")->references("id")->on("sk_category")->onDelete("SET NULL");
            $table->foreign("kitchen_id")->references("id")->on("sk_kitchen")->onDelete("CASCADE");
        });

        Schema::table('sk_products', function (Blueprint $table) {
            $table->fullText(['name', 'description', 'ingredients']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_products');
    }
};
