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
        Schema::create('sk_pincode_master', function (Blueprint $table) {
            $table->id();
            $table->text("pincode")->required();
            $table->text("area")->required();
            $table->text("city")->required();
            $table->text("state")->required();
            $table->text("country")->required();
            $table->text('remarks')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('deleted_at')->nullable(); // Added for soft delete
            $table->timestamps();
        });

        Schema::table('sk_pincode_master', function (Blueprint $table) {
            $table->fullText(['pincode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_pincode_master');
    }
};
