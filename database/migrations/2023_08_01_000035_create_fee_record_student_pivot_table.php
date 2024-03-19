<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeRecordStudentPivotTable extends Migration
{
    public function up()
    {
        Schema::create('fee_record_student', function (Blueprint $table) {
            $table->unsignedBigInteger('fee_record_id');
            $table->foreign('fee_record_id', 'fee_record_id_fk_8795541')->references('id')->on('fee_records')->onDelete('cascade');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id', 'student_id_fk_8795541')->references('id')->on('students')->onDelete('cascade');
        });
    }
}
