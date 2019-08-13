<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderReturnRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_return_requests', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('order_id')->unsigned();
	        $table->enum('user_option',['REFUND','RETURN']);
	        $table->enum('status',['INIT_REQUEST','APPROVE','DISAPPROVE','CUSTOMER_SENT_PRODUCT'])->default('INIT_REQUEST');
	        $table->timestamps();

	        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_return_requests');
    }
}
