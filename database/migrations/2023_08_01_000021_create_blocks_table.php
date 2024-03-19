<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksTable extends Migration
{
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('heading');
            $table->string('status');
            $table->longText('description');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }
}
