<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Animal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('animals', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->string('sex');
            $table->string('photos')->nullable()->default(null);
            $table->string('information');
            $table->unsignedInteger('users_id');
            $table->string('age');
            $table->string('species');
            $table->string('breed');
            $table->foreign('users_id')->references('id')->on('users');

            $table->rememberToken();
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
        //
    }
}
