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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->text('password');
            $table->string('profile')->nullable();
            $table->string('type', 1)->default('1');
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->unsignedBigInteger('create_user_id')->nullable();
            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->unsignedBigInteger('deleted_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Adding foreign key constraints
            $table->foreign('create_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dropping foreign key constraints
            $table->dropForeign(['create_user_id']);
            $table->dropForeign(['updated_user_id']);
        });

        Schema::dropIfExists('users');
    }
};
