<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFeesTable extends Migration
{
    public function up()
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id', 'course_fk_8818234')->references('id')->on('courses');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id', 'student_fk_8766113')->references('id')->on('students');
        });
    }
}
