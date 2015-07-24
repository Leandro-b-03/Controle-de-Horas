<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTimesTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_times_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_time_id')->unsigned();
            $table->string('name');
            $table->string('description');
            $table->json('teams');
            $table->timestamps();

            $table->foreign('project_time_id')->references('id')->on('projects_times')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projects_times_tasks');
    }
}
