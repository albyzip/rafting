<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rest_options', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('options_id')->unsigned();
            $table->foreign('options_id')->references('id')->on('options')->onDelete('cascade');
            $table->integer('rest_id')->unsigned();
            $table->foreign('rest_id')->references('id')->on('rests')->onDelete('cascade');
            $table->string('value');
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
        Schema::dropIfExists('rest_options');
    }
}
