<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('admission_number')->unique();
            $table->string('upn')->unique();
            $table->string('forename');
            $table->string('surname');
            $table->integer('year_group');
            $table->date('birth_date');
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
        Schema::dropIfExists('students');
    }
}
