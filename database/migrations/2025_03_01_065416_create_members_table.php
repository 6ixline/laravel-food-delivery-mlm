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
        Schema::create('sk_registrations', function (Blueprint $table) {
            $table->id();
            $table->text('membership_id')->required()->notnull()->unique();
            $table->text('membership_id_value')->required()->notnull()->unique();
            $table->text('sponsor_id')->required()->notnull();
            $table->text('sponsor_name')->required()->notnull();
            $table->integer('planid')->nullable()->default(0);
            $table->integer('rewardid')->nullable()->default(0);
            $table->text('name')->required()->notnull();
            $table->text('father_name')->nullable();
            $table->text('username')->required()->notnull()->unique();
            $table->text('relation_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->text('email')->required()->notnull()->unique();
            $table->string('password')->nullable();
            $table->string('password_text')->nullable();
            $table->text('mobile')->required()->notnull()->unique();
            $table->text('mobile_alter')->nullable();
            $table->text('address')->nullable();
            $table->text('pincode')->required()->notnull()->nullable();
            $table->text('nominee_name')->nullable();
            $table->text('kycdoc')->nullable();
            $table->text('panImage')->nullable();
            $table->text('bankdoc')->nullable();
            $table->text('nominee_relation')->nullable();
            $table->text('nominee_age')->nullable();
            $table->text('bank_name')->nullable();
            $table->text('branch_name')->nullable();
            $table->text('account_number')->nullable();
            $table->text('ifsc_code')->nullable();
            $table->text('account_name')->nullable();
            $table->text('pan_card')->nullable();
            $table->text('aadhar_card')->nullable();
            $table->text('imgName')->nullable();
            $table->text('remarks')->nullable();
            $table->text("isVerified")->boolval()->default(false);
            $table->enum('status', ['active', 'inactive'])->nullable();
            $table->timestamp('deleted_at')->nullable(); // Added for soft delete
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_registrations');
    }
};
