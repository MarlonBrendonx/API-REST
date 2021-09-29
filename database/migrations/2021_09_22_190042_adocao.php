<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Adocao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('adoption', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->string('sex');
            $table->string('photos')->nullable()->default(null);
            $table->string('age');
            $table->string('breed');
            $table->string('species');
            $table->unsignedInteger('animals_id');

            $table->foreign('animals_id')->references('id')->on('animals');

            $table->rememberToken();
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('adocao');
    }
}
