<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamPlanPivotTable extends Migration
{
    public function up()
    {
        Schema::create('exam_plan', function (Blueprint $table) {
            $table->unsignedBigInteger('exam_id');
            $table->foreign('exam_id', 'exam_id_fk_8766189')->references('id')->on('exams')->onDelete('cascade');
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id', 'plan_id_fk_8766189')->references('id')->on('plans')->onDelete('cascade');
        });
    }
}
