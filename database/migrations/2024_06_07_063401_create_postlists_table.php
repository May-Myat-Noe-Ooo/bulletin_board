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
        Schema::create('postlists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->integer('status');
            $table->integer('create_user_id');
            $table->integer('updated_user_id');
            $table->integer('deleted_user_id');
            $table->datetime('created_at');
            $table->datetime('updated_at');
            $table->datetime('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postlists');
    }
};
