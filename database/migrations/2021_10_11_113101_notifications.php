<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Notifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('user_id_event');
            $table->unsignedInteger('id_event');
            $table->string('message');
            $table->integer("type");
            $table->timestamps();

       
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_event')->references('id')->on('events')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}

