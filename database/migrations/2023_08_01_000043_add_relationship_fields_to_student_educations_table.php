<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStudentEducationsTable extends Migration
{
    public function up()
    {
        Schema::table('student_educations', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id', 'student_fk_8766254')->references('id')->on('students');
        });
    }
}
