<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// In the migration file
public function up()
{
    Schema::table('grades', function (Blueprint $table) {
        // Make student_number nullable
        $table->string('student_number')->nullable()->change();
        
        // Ensure student_id is required (should already be)
        // If you want to verify foreign key
        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('grades', function (Blueprint $table) {
        $table->string('student_number')->nullable(false)->change();
    });
}
};
