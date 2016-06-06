<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimesheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->date('workday');
            $table->time('start');
            $table->time('lunch_start')->default('00:00:00');
            $table->time('lunch_end')->default('00:00:00');
            $table->string('lunch_hours')->default('00:00:00');
            $table->time('end')->default('00:00:00');
            $table->string('hours')->default('00:00:00');
            $table->time('nightly_start')->default('00:00:00');
            $table->time('nightly_end')->default('00:00:00');
            $table->string('nightly_hours')->default('00:00:00');
            $table->enum('status', ['W', 'F', 'P', 'N'])->default('N');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timesheets');
    }
}
