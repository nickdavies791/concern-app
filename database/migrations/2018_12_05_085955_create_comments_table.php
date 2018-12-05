<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->unsignedInteger('concern_id')->index();
            //$table->unsignedInteger('group_id')->index();
            $table->string('title');
            $table->text('comment');
            $table->text('action_taken');
            $table->datetime('resolved_on')->nullable();
            $table->increments();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
