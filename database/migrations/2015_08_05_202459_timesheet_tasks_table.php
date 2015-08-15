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
            $table->integer('project_time_task_id')->unsigned();
            $table->decimal('hours', 2, 2);
            $table->time('start');
            $table->time('end');
            $table->timestamps();

            $table->foreign('timesheet_id')->references('id')->on('timesheets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('project_time_task_id')->references('id')->on('projects_times_tasks')->onUpdate('cascade')->onDelete('cascade');
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
