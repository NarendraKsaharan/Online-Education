<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('fee_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('fee', 15, 2);
            $table->decimal('balance', 15, 2)->nullable();
            $table->date('join_date')->nullable();
            $table->timestamps();
        });
    }
}
