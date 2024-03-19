<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('status');
            $table->decimal('price', 15, 2);
            $table->decimal('special_price', 15, 2)->nullable();
            $table->timestamps();
        });
    }
}
