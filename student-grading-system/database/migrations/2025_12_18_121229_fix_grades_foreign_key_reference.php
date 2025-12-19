<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('grades', function (Blueprint $table) {
        // Drop existing foreign key
        $table->dropForeign(['student_number']);
        
        // Add new foreign key referencing student_number column
        $table->foreign('student_number')
              ->references('student_number')  // Reference student_number column
              ->on('students')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            //
        });
    }
};
