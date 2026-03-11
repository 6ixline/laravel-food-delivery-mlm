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
        Schema::create('mlm_plans', function (Blueprint $table) {
            $table->id();
            $table->text("title")->required();
            $table->decimal("tds", 8, 2)->required();
            $table->decimal("activation_reward_point", 8, 2)->required();
            $table->decimal("direct_referral_per", 8, 2)->required();
            $table->decimal("minimum_order", 8, 2)->required();
            $table->text('remarks')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('deleted_at')->nullable(); // Added for soft delete
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mlm_plans');
    }
};
