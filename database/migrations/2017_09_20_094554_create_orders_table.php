<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('billing_address_id')->unsigned();
	        $table->integer('shipping_address_id')->unsigned();
	        $table->integer('user_id')->unsigned()->nullable();
	        $table->string('shipping_option')->nullable();
	        $table->string('payment_option')->nullable();
	        $table->boolean('enable_tax')->default(0);
	        $table->integer('tax_percentage')->default(0);
	        $table->integer('order_status_id')->unsigned();
	        $table->text('order_note')->nullable();
	        $table->timestamp('order_date')->nullable();
	        $table->timestamps();

	        $table->foreign('billing_address_id')->references('id')->on('addresses');
	        $table->foreign('shipping_address_id')->references('id')->on('addresses');
	        $table->foreign('user_id')->references('id')->on('users');
	        $table->foreign('order_status_id')->references('id')->on('order_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
