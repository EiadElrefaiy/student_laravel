<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->unsigned()->index();
            $table->foreign('student_id')->references('id')->on('students');
            $table->integer('survey_id')->unsigned()->index();
            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->double('degree');
            $table->integer('full_degree');
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
        Schema::dropIfExists('result');
    }
}
