<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcernGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concern_group', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('concern_id')->index();
            $table->unsignedInteger('group_id')->index();
            $table->foreign('concern_id')->references('id')->on('concerns')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concern_group');
    }
}
