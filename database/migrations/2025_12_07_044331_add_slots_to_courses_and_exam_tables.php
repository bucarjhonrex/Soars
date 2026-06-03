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
            Schema::table('courses', function (Blueprint $table) {
            $table->integer('slots')->default(0);
            $table->integer('used_slots')->default(0);
        });

        Schema::table('exam', function (Blueprint $table) {
            $table->integer('slots')->default(0);
            $table->integer('used_slots')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['slots', 'used_slots']);
        });

        Schema::table('exam', function (Blueprint $table) {
            $table->dropColumn(['slots', 'used_slots']);
        });
    }
};
