<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUseCases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_cases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('timesheets_tasks_id')->unsigned();
            $table->integer('ok');
            $table->integer('nok');
            $table->integer('impacted');
            $table->integer('cancelled');
            $table->timestamps();

            $table->foreign('timesheets_tasks_id')->references('id')->on('timesheets_tasks')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('use_cases');
    }
}
