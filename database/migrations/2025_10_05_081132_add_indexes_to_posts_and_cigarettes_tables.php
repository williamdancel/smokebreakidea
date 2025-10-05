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
        Schema::table('posts', function (Blueprint $table) {
            $table->index('status');
            $table->index('is_from_non_registered_user');
            $table->index('created_at');
        });

        Schema::table('cigarettes', function (Blueprint $table) {
            $table->index('brand_id');
            $table->index('is_available');
        });

        Schema::table('cigarette_brands', function (Blueprint $table) {
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['is_from_non_registered_user']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('cigarettes', function (Blueprint $table) {
            $table->dropIndex(['brand_id']);
            $table->dropIndex(['is_available']);
        });

        Schema::table('cigarette_brands', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });
    }
};
