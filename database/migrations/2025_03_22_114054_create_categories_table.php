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
        Schema::create('sk_category', function (Blueprint $table) {
            $table->id();
            $table->text("title")->required();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger("kitchen_id")->required();
            $table->text('imgName')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('deleted_at')->nullable(); // Added for soft delete
            $table->timestamps();
            $table->foreign('kitchen_id')->references('id')->on('sk_kitchen')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_category');
    }
};
