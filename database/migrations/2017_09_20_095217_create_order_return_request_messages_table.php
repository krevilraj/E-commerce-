<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderReturnRequestMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_return_request_messages', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('order_return_request_id')->unsigned();
	        $table->integer('user_id')->unsigned();
	        $table->enum('user_type',['USER','ADMIN_USER']);
	        $table->text('message_text');
	        $table->timestamps();

	        $table->foreign('order_return_request_id')->references('id')->on('order_return_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_return_request_messages');
    }
}
