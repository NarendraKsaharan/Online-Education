<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPagesTable extends Migration
{
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_page_id')->nullable();
            $table->foreign('parent_page_id', 'parent_page_fk_8766080')->references('id')->on('pages');
        });
    }
}
