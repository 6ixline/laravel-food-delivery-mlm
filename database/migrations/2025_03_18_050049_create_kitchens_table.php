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
        // Ensure the sk_kitchen_manager table exists before this migration
        Schema::create('sk_kitchen', function (Blueprint $table) {
            $table->id()->primary();
            $table->text("name")->required();
            $table->longText("address")->required();
            $table->unsignedBigInteger("primary_pincode_id")->nullable();
            $table->unsignedBigInteger('kitchen_manager_id')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('deleted_at')->nullable(); // Added for soft delete
            $table->timestamps();
            $table->foreign('kitchen_manager_id')->references('id')->on('sk_kitchen_manager')->onDelete('SET NULL');
            $table->foreign('primary_pincode_id')->references('id')->on('sk_pincode_master')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_kitchen');
    }
};
