<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignAssignmentStudentPivotTable extends Migration
{
    public function up()
    {
        Schema::create('assign_assignment_student', function (Blueprint $table) {
            $table->unsignedBigInteger('assign_assignment_id');
            $table->foreign('assign_assignment_id', 'assign_assignment_id_fk_8760083')->references('id')->on('assign_assignments')->onDelete('cascade');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id', 'student_id_fk_8760083')->references('id')->on('students')->onDelete('cascade');
        });
    }
}
