<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('password');
            $table->string('profile');
            $table->string('type');
            $table->string('phone');
            $table->string('address');
            $table->date('dob');
            $table->integer('create_user_id');
            $table->integer('updated_user_id');
            $table->integer('deleted_user_id');
            $table->datetime('creatd_at');
            $table->datetime('updated_at');
            $table->datetime('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
