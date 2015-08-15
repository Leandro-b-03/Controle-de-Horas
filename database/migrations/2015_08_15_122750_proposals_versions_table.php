<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProposalsVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals_versions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposal_id')->unsigned();
            $table->text('proposal');
            $table->string('version');
            $table->integer('send');
            $table->boolean('authorise');
            $table->date('data_authorise');
            $table->boolean('signing_board');
            $table->date('date_signing_board');
            $table->date('date_return');
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposals')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('proposals_versions');
    }
}
