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
            $table->integer('timesheet_task_id')->unsigned();
            $table->integer('ok');
            $table->integer('nok');
            $table->integer('impacted');
            $table->integer('cancelled');
            $table->timestamps();

            $table->foreign('timesheet_task_id')->references('id')->on('timesheets_tasks')->onUpdate('cascade')->onDelete('cascade');
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
