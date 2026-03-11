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
        Schema::create('mlm_performance_bonus', function (Blueprint $table) {
            $table->id();
            $table->text("title")->required();
            $table->decimal("bv_range_start", 8, 2)->required();
            $table->decimal("bv_range_end", 8, 2)->required();
            $table->decimal("incentive", 8, 2)->required();
            $table->decimal("monthly_self_bv", 8, 2)->required();
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
        Schema::dropIfExists('performance_bonuses');
    }
};
