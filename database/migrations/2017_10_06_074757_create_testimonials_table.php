<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
	        $table->increments('id');
	        $table ->integer('user_id')->unsigned();
	        $table->string('title');
	        $table->string('slug')->unique();
	        $table->longText('content');
	        $table->string('client_name');
	        $table->string('client_company')->nullable();
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
        Schema::dropIfExists('testimonials');
    }
}
