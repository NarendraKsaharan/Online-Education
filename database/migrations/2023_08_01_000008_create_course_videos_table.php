<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseVideosTable extends Migration
{
    public function up()
    {
        Schema::create('course_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('video_title');
            $table->longText('video_description')->nullable();
            $table->longText('video_source')->nullable();
            $table->timestamps();
        });
    }
}
