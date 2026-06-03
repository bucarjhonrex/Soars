<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('application_info', function (Blueprint $table) {
            // Drop old VARCHAR course columns
            $table->dropColumn(['first_course_applied', 'second_course_applied', 'third_course_applied']);

            // Add new foreign key columns
            $table->foreignId('first_course_applied_id')->after('student_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('second_course_applied_id')->after('first_course_applied_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('third_course_applied_id')->after('second_course_applied_id')->constrained('courses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('application_info', function (Blueprint $table) {
            // Drop new foreign keys
            $table->dropForeign(['first_course_applied_id']);
            $table->dropForeign(['second_course_applied_id']);
            $table->dropForeign(['third_course_applied_id']);

            $table->dropColumn(['first_course_applied_id', 'second_course_applied_id', 'third_course_applied_id']);

            // Add back old VARCHAR columns
            $table->string('first_course_applied', 100);
            $table->string('second_course_applied', 100);
            $table->string('third_course_applied', 100);
        });
    }
};

