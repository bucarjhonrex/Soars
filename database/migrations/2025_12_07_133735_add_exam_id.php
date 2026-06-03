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
                // Add exam_id to students
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('exam_id')->nullable()->after('course_id')->constrained('exam')->nullOnDelete();
        });

        // Remove student_id from exam
        Schema::table('exam', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback changes
        Schema::table('exam', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['exam_id']);
            $table->dropColumn('exam_id');
        });
    }
};
