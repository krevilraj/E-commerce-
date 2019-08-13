<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
	        $table->increments('id');
	        $table->enum('type',['BASIC','VARIATION','DOWNLOADABLE'])->default('BASIC');
	        $table->string('name')->nullable();
	        $table->string('slug')->nullable();
	        $table->string('isbn')->nullable();
            $table->string('size')->nullable();
            $table->string('page')->nullable();
            $table->string('weight')->nullable();
            $table->string('quantity')->nullable();
            $table->string('edition')->nullable();
            $table->string('publish_year')->nullable();
            $table->string('langauge')->nullable();
	        $table->text('remarks')->nullable();
	        $table->longText('description')->nullable();
	        $table->boolean('track_stock')->default(0);
	        $table->integer('stock_qty')->nullable();
	        $table->tinyInteger('in_stock')->nullable();
	        $table->tinyInteger('is_taxable')->nullable();
	        $table->tinyInteger('is_featured')->nullable();
	        $table->boolean('disable_price')->default(false);
	        $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('products');
    }
}
