<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConcernTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concern_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('concern_id');
            $table->unsignedInteger('tag_id');
            $table->foreign('concern_id')->references('id')->on('concerns');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concern_tag');
    }
}
