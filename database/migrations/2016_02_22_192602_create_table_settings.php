<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('Timesheet');
            $table->string('description')->default('Manage the employe time tasks');
            $table->string('api_key');
            $table->string('locktime')->default('10');
            $table->string('default_theme')->default('skin-yellow');
            $table->enum('maintenance', ['Y', 'N'])->default('N');
            $table->string('maintenance_message')->default('Estamos em manutenção aguarde um momento!');
            $table->string('from_address')->default('noreply@timesheet.com.br');
            $table->string('from_name')->default('Timesheet no reply');
            $table->integer('page_size')->default('15');
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
        // Schema::drop('settings');
    }
}
