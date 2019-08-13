<?php

use App\OrderStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('name');
	        $table->tinyInteger('is_default')->default(false);
	        $table->timestamps();
        });

	    OrderStatus::insert([
		    ['name' => 'Pending', 'is_default' => 1],
		    ['name' => 'Approved', 'is_default' => 0],
		    ['name' => 'Delivered', 'is_default' => 0],
		    ['name' => 'Received', 'is_default' => 0],
		    ['name' => 'Canceled', 'is_default' => 0],
	    ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_statuses');
    }
}
