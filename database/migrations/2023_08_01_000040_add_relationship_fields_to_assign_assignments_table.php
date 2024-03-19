<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAssignAssignmentsTable extends Migration
{
    public function up()
    {
        Schema::table('assign_assignments', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id', 'course_fk_8760082')->references('id')->on('courses');
        });
    }
}
