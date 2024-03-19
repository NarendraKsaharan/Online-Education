<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentEducationsTable extends Migration
{
    public function up()
    {
        Schema::create('student_educations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class');
            $table->longText('university');
            $table->date('passing_year');
            $table->string('percentage');
            $table->timestamps();
        });
    }
}
