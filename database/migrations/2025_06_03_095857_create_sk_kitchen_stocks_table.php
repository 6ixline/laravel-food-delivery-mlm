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
        Schema::create('sk_kitchen_stocks', function (Blueprint $table) {
        
                $table->id();

                $table->unsignedBigInteger('ingredients_id');
                $table->foreign('ingredients_id')
                    ->references('id')
                    ->on('sk_ingredients')
                    ->onDelete('cascade');

                $table->integer('qty')->default(1);

                $table->unsignedBigInteger('kitchen_id');
                $table->foreign('kitchen_id')
                    ->references('id')
                    ->on('sk_kitchen')
                    ->onDelete('cascade');

                $table->enum('status', ['active', 'inactive']);

                $table->timestamps();
         

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_kitchen_stocks');
    }
};
