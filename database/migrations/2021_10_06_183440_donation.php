<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Donation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('donation', function (Blueprint $table) {

            $table->increments('id');
            $table->string('title');
            $table->string('sobre');
            $table->string('link');
            
            $table->string('photos')->nullable()->default(null);
            $table->unsignedInteger('users_id');

            $table->foreign('users_id')->references('id')->on('users');

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
        Schema::dropIfExists('donation');
    }
}
