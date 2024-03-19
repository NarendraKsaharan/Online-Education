<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('status');
            $table->longText('description');
            $table->decimal('fee', 15, 2)->nullable();
            $table->string('fee_type');
            $table->timestamps();
        });
    }
}
