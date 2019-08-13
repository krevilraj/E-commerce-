<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('user_id')->unsigned()->nullable()->default(null);
	        $table->enum('type', ['SHIPPING', 'BILLING']);
	        $table->string('first_name');
	        $table->string('last_name');
	        $table->string('email')->nullable()->default(null);
	        $table->string('phone')->nullable()->default(null);
	        $table->string('address1')->nullable()->default(null);
	        $table->string('address2')->nullable()->default(null);
	        $table->string('postcode')->nullable()->default(null);
	        $table->string('city')->nullable()->default(null);
	        $table->integer('state_id')->unsigned()->nullable()->default(null);
	        $table->integer('country_id')->unsigned()->nullable()->default(null);
	        $table->timestamps();

	        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
	        $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
	        $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
