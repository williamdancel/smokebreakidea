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
            $table->string('title');
            $table->text('body');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->string('status')->default('published');
            $table->boolean('is_from_non_registered_user')->default(false);
            $table->foreignId('cigarette_id')->nullable()->constrained('cigarettes');
            $table->integer('cigarettes_count')->default(1);
            $table->integer('rating')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
