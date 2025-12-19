<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            
            // Student Information
            $table->string('student_number')->unique()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('gender', ['Male', 'Female', 'Other'])->default('Male');
            $table->string('section');
            $table->string('year_level');
            
            // Optional Information
            $table->string('profile_picture')->nullable();
            $table->text('address')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_contact')->nullable();
            
            // Academic Information
            $table->decimal('average_grade', 5, 2)->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Graduated', 'Transferred'])->default('Active');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes(); // ADD THIS IF YOU WANT SOFT DELETES
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};