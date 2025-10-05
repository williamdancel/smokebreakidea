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
        Schema::create('cigarettes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('cigarette_brands');
            $table->string('name');
            $table->string('strength')->nullable();
            $table->text('description')->nullable();
            $table->decimal('tar_content', 5, 2)->nullable();
            $table->decimal('nicotine_content', 5, 2)->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
