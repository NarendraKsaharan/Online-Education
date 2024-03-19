<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseFeeRecordPivotTable extends Migration
{
    public function up()
    {
        Schema::create('course_fee_record', function (Blueprint $table) {
            $table->unsignedBigInteger('fee_record_id');
            $table->foreign('fee_record_id', 'fee_record_id_fk_8800282')->references('id')->on('fee_records')->onDelete('cascade');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id', 'course_id_fk_8800282')->references('id')->on('courses')->onDelete('cascade');
        });
    }
}
