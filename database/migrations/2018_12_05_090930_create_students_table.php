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
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('mis_id')->unique();
            $table->string('admission_number')->unique();
            $table->string('upn')->unique();
            $table->text('forename');
            $table->text('surname');
            $table->integer('year_group');
            $table->date('birth_date');
            $table->string('sen_category')->nullable();
            $table->string('photo_hash')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();
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
