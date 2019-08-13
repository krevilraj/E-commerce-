<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_values', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('attribute_id')->unsigned();
	        $table->integer('product_id')->unsigned();
	        $table->string('value');
	        $table->timestamps();

	        $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
	        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute_values');
    }
}
