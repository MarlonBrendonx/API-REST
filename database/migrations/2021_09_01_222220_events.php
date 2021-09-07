<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Events extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('events', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('type');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('icon');
            $table->string('status');
            $table->string('photos')->nullable()->default(null);
            $table->string('information');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('animal_id');
            
            $table->timestamps();
            $table->foreign('animal_id')->references('id')->on('animals');
            $table->foreign('user_id')->references('id')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
