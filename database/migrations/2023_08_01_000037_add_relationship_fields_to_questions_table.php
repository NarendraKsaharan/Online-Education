<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToQuestionsTable extends Migration
{
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id', 'course_fk_8766199')->references('id')->on('courses');
            $table->unsignedBigInteger('exam_id')->nullable();
            $table->foreign('exam_id', 'exam_fk_8766200')->references('id')->on('exams');
        });
    }
}
