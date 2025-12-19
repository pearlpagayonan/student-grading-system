<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // FIRST, make sure users table exists
        if (!Schema::hasTable('users')) {
            return;
        }
        
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->default(3)->constrained('roles')->after('id');
            $table->string('profile_picture')->nullable()->after('email');
            $table->string('contact_number')->nullable()->after('profile_picture');
            $table->string('student_id')->unique()->nullable()->after('contact_number');
            $table->string('teacher_id')->unique()->nullable()->after('student_id');
            $table->string('year_level')->nullable()->after('teacher_id');
            $table->string('section')->nullable()->after('year_level');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('section');
            $table->boolean('first_login')->default(true)->after('gender');
            $table->softDeletes()->after('updated_at');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn([
                'role_id', 'profile_picture', 'contact_number',
                'student_id', 'teacher_id', 'year_level', 
                'section', 'gender', 'first_login', 'deleted_at'
            ]);
        });
    }
};