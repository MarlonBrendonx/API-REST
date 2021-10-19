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
            $table->string('status')->nullable()->default(null);
            $table->string('photos')->nullable()->default(null);
            $table->string('information');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('animal_id')->nullable()->default(null);
            
            $table->timestamps();
            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
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
