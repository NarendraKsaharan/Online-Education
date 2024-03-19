<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCourseVideosTable extends Migration
{
    public function up()
    {
        Schema::table('course_videos', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id', 'course_fk_8760053')->references('id')->on('courses');
            $table->unsignedBigInteger('topic_id')->nullable();
            $table->foreign('topic_id', 'topic_fk_8766248')->references('id')->on('topics');
        });
    }
}
