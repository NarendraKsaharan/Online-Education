<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('heading');
            $table->string('show_in_menu');
            $table->string('show_in_footer');
            $table->string('status');
            $table->longText('description');
            $table->string('slug')->unique();
            $table->string('meta_tag');
            $table->string('meta_title');
            $table->longText('meta_description');
            $table->timestamps();
        });
    }
}
