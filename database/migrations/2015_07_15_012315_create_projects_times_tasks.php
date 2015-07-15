<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTimesTasks extends Migration
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
            $table->integer('project_time_id')->references('id')->on('projects_times');
            $table->string('name');
            $table->string('description');
            $table->json('teams');
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
        Schema::drop('projects_times_tasks');
    }
}
