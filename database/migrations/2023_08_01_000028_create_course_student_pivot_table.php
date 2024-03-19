<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseStudentPivotTable extends Migration
{
    public function up()
    {
        Schema::create('course_student', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id', 'student_id_fk_8800280')->references('id')->on('students')->onDelete('cascade');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id', 'course_id_fk_8800280')->references('id')->on('courses')->onDelete('cascade');
        });
    }
}
