<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foto_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('rest_type_id')->unsigned();
            $table->foreign('rest_type_id')->references('id')->on('rest_types')->onDelete('cascade');
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
        Schema::dropIfExists('foto_reports');
    }
}
