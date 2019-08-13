<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('user_id')->unsigned();
	        $table->string('name');
	        $table->string('slug')->unique();
	        $table->string('link')->nullable();
	        $table->text('content')->nullable();
	        $table->boolean('active')->default(true);
	        $table->timestamps();

	        $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
