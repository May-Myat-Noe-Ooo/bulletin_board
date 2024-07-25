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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title',255)->unique();
            $table->string('description');
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('create_user_id');
            $table->unsignedBigInteger('updated_user_id');
            $table->unsignedBigInteger('deleted_user_id')->nullable();
            $table->timestamps();

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
        Schema::table('posts', function (Blueprint $table) {
            // Dropping foreign key constraints
            $table->dropForeign(['create_user_id']);
            $table->dropForeign(['updated_user_id']);
        });

        Schema::dropIfExists('posts');
    }
};
