<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_number');
            $table->string('subject');
            $table->decimal('grade', 5, 2);
            $table->integer('units')->default(3);
            $table->string('school_year');
            $table->string('semester');
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            // Add foreign key constraint
            $table->foreign('student_number')
                  ->references('id')
                  ->on('students')
                  ->onDelete('cascade');
            
            // Add index
            $table->index('student_number');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('grades');
    }
};