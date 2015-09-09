<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolydaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holydays', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->integer('day');
            $table->integer('month');
            $table->enum('holiday_type', ['N', 'O', 'S', 'E']);
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
        Schema::drop('holydays');
    }
}
