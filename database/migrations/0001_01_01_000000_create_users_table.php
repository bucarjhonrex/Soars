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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname', 50);
            $table->string('lname', 50);
            $table->string('mname', 50)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role',['user','admin'])->default('user');
             $table->string('user_image')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });



        Schema::create('courses',function(Blueprint $table){
            $table->id();
            $table->string('course', 100);
            $table->timestamps();
        });

        Schema::create('students', function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->string('phone_number', 20)->unique();
            $table->string('place_birth', 100)->nullable();
            $table->date('date_birth')->nullable();
            $table->string('religion', 100)->nullable();
            $table->enum('blood_type',['A','A+','A-','B','B+','B-','AB','AB+','AB-','O','O+','O-'])->nullable();
            $table->enum('gender',['Male','Female'])->nullable();
            $table->enum('civil_status',['Single','Married','Widowed','Divorced'])->nullable();
            $table->enum('student_status', ['Completed', 'Failed','Rejected','Pending'])->default('Pending');
            $table->timestamps();
        });

          Schema::create('addresses', function(Blueprint $table){
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->enum('type',['permanent', 'current']);
            $table->unique(['student_id','type']);
            $table->string('region', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('barangay', 100)->nullable();
            $table->string('zip', 10)->nullable();
            $table->decimal('household_income', 12,2)->nullable();
            $table->timestamps();
        });

        Schema::create('student_schedule', function(Blueprint $table){
              $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('schedule_type', 50);
            $table->date('schedule_date');
            $table->time('scheduled_time_start');
            $table->time('scheduled_time_end');
            $table->string('description', 50)->nullable();
            $table->enum('status', ['Scheduled', 'Completed', 'Cancelled'])->default('Scheduled');
            $table->timestamps();
        });

        Schema::create('documents', function(Blueprint $table){
        $table->id();
         $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
           $table->string('document_name', 50);
            $table->string('file_path');
            $table->enum('Status', [
                'Pending',
                'Approved',
                'Rejected'])->default('Pending');
            $table->timestamps();

        });

        Schema::create('family_info', function(Blueprint $table){
            $table->id();
             $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
             $table->enum('family_member',['father','mother','guardian']);
            $table->string('fname', 50)->nullable();
            $table->string('lname', 50)->nullable();
            $table->string('mname', 50)->nullable();
            $table->string('suffix', 10)->nullable();
            $table->string('contact_no', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('occupation', 100)->nullable();
           $table->enum('livstatus',['living','deceased'])->default('living');
            $table->timestamps();

        });

        Schema::create('application_info', function(Blueprint $table){
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
             $table->string('first_course_applied', 100);
            $table->string('second_course_applied', 100);
            $table->string('third_course_applied', 100);
            $table->integer('lrn')->nullable();
            $table->string('education_level', 50);
            $table->enum('classification', ['New','Old','Transferee','Returnee', 'Shiftee' ])->default('New');
            $table->enum('student_type', ['Local','Online','Other'])->default('Local');
            $table->string('remarks', 100)->nullable();
            $table->timestamps();

        });

        Schema::create('education_info', function(Blueprint $table){
            $table->id();
             $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
             $table->enum('level',['elementary','junoir','senior','college']);
             $table->string('school_name', 100);
            $table->string('address', 100);
            $table->string('year_graduated', 50);
            $table->string('honors', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('exam', function(Blueprint $table){
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->date('exam_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('station', 100)->nullable();
            $table->integer('total_score')->nullable();
            $table->enum('status', ['Scheduled','Complete','Cancelled'])->default('Scheduled');
            $table->timestamps();
        });
        Schema::create('posts', function (Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title', 150);
            $table->longtext('content');
            $table->string('image_path')->nullable();
            $table->timestamp('posted_at')->useCurrent();
            $table->enum('status', ['Published', 'Draft', 'Archived'])->default('Draft');
            $table->timestamps();
        });

        Schema::create('notif', function (Blueprint $table){
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('message', 100);
                $table->timestamp('date_sent')->useCurrent();
                $table->enum('status', ['Sent', 'Read'])->default('Sent');
                $table->timestamps();
        });




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('notif');
    Schema::dropIfExists('posts');
    Schema::dropIfExists('exam');
    Schema::dropIfExists('education_info');
    Schema::dropIfExists('application_info');
    Schema::dropIfExists('family_info');
    Schema::dropIfExists('documents');
    Schema::dropIfExists('student_schedule');
    Schema::dropIfExists('addresses');
    Schema::dropIfExists('students');
    Schema::dropIfExists('courses');
    Schema::dropIfExists('sessions');
    Schema::dropIfExists('password_reset_tokens');
    Schema::dropIfExists('users');


    }
};
