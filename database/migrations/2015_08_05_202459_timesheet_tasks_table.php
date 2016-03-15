<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimesheetTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('timesheet_id')->unsigned();
            $table->integer('project_id');
            $table->integer('work_package_id');
            $table->string('hours')->default('00:00:00');
            $table->time('start')->default('00:00:00');
            $table->time('end')->default('00:00:00');
            $table->timestamps();

            $table->foreign('timesheet_id')->references('id')->on('timesheets')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timesheets_tasks');
    }
}
