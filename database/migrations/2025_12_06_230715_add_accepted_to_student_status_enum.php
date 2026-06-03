<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE `students`
            MODIFY COLUMN `student_status`
            ENUM('Completed','Failed','Rejected','Pending','Accepted')
            DEFAULT 'Pending'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE `students`
            MODIFY COLUMN `student_status`
            ENUM('Completed','Failed','Rejected','Pending')
            DEFAULT 'Pending'
        ");
    }
};
