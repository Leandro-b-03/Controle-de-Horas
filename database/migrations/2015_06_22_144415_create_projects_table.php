<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('client_id')->references('id')->on('clients');
            $table->string('name');
            $table->string('short_description');
            $table->text('description');
            $table->integer('schedule_time');
            $table->integer('time_spend');
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
        Schema::drop('projects');
    }
}
