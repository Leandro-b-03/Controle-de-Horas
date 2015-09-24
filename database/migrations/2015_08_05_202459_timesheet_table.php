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
            $table->time('lunch_start');
            $table->time('lunch_end');
            $table->decimal('lunch_hours', 4, 2);
            $table->time('end');
            $table->decimal('hours', 4, 2);
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
