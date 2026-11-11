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
        // 1. School Classes
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Class 6, Class 10
            $table->string('section')->default('A');
            $table->string('class_teacher')->nullable();
            $table->string('room')->nullable();
            $table->integer('student_capacity')->default(35);
            $table->timestamps();
        });

        // 2. Teachers / Faculty
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id')->unique(); // T-01
            $table->string('name');
            $table->string('designation');
            $table->string('subject');
            $table->string('qualification')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('salary', 12, 2)->default(90000);
            $table->string('status')->default('Active');
            $table->string('avatar')->nullable();
            $table->date('join_date')->nullable();
            $table->timestamps();
        });

        // 3. Students
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_code')->unique(); // STU-001
            $table->string('admission_no')->unique(); // ADM-2026-101
            $table->string('name');
            $table->string('father_name');
            $table->string('class_name');
            $table->string('section')->default('A');
            $table->integer('roll_no');
            $table->string('gender')->default('Male');
            $table->date('dob')->nullable();
            $table->string('blood_group')->default('O+');
            $table->string('phone');
            $table->string('guardian_email')->nullable();
            $table->text('address')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('attendance_rate')->default(95); // 0-100%
            $table->string('fee_status')->default('Pending'); // Paid, Pending, Overdue
            $table->decimal('fee_amount', 10, 2)->default(9500);
            $table->date('fee_due_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('rfid_tag')->nullable()->unique();
            $table->json('marks')->nullable(); // Subject wise scores
            $table->timestamps();
        });

        // 4. Attendance Logs
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->date('date');
            $table->time('punch_time')->nullable();
            $table->string('status')->default('Present'); // Present, Absent, Late, Excused
            $table->string('method')->default('RFID'); // RFID, Manual, Biometric
            $table->timestamps();
        });

        // 5. Notices / Circulars
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('notice_id')->unique();
            $table->string('title');
            $table->string('category')->default('General');
            $table->string('audience')->default('All'); // All, Parents, Teachers, Students
            $table->string('priority')->default('normal'); // normal, urgent, high
            $table->date('date');
            $table->text('content');
            $table->timestamps();
        });

        // 6. Recent Activity Log
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // fee, attendance, academic, notice, student
            $table->string('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('notices');
        Schema::dropIfExists('attendance_records');
        Schema::dropIfExists('students');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('school_classes');
    }
};
