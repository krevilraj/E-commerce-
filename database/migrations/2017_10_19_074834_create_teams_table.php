<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
	        $table->increments('id');
	        $table ->integer('user_id')->unsigned();
	        $table->string('name');
	        $table->string('slug')->unique();
	        $table->longText('content')->nullable();
	        $table->string('designation');
	        $table->string('facebook_link')->nullable();
	        $table->string('twitter_link')->nullable();
	        $table->string('googleplus_link')->nullable();
	        $table->string('linkedin_link')->nullable();
	        $table->boolean('status')->default(false);
	        $table->timestamps();

	        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
