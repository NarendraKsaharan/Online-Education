<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignAssignmentAssignmentPivotTable extends Migration
{
    public function up()
    {
        Schema::create('assign_assignment_assignment', function (Blueprint $table) {
            $table->unsignedBigInteger('assign_assignment_id');
            $table->foreign('assign_assignment_id', 'assign_assignment_id_fk_8760084')->references('id')->on('assign_assignments')->onDelete('cascade');
            $table->unsignedBigInteger('assignment_id');
            $table->foreign('assignment_id', 'assignment_id_fk_8760084')->references('id')->on('assignments')->onDelete('cascade');
        });
    }
}
