<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiblingStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sibling_student', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sibling_id');
            $table->unsignedInteger('student_id');
            $table->foreign('sibling_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sibling_student');
    }
}
