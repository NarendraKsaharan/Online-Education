<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentStudentPivotTable extends Migration
{
    public function up()
    {
        Schema::create('assignment_student', function (Blueprint $table) {
            $table->unsignedBigInteger('assignment_id');
            $table->foreign('assignment_id', 'assignment_id_fk_8760077')->references('id')->on('assignments')->onDelete('cascade');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id', 'student_id_fk_8760077')->references('id')->on('students')->onDelete('cascade');
        });
    }
}
