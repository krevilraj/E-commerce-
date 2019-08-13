<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
	        $table->increments('id');
	        $table->enum('type',['PRODUCT','CATEGORY','ORDER','CUSTOMER'])->default('PRODUCT');
	        $table->string('name');
	        $table->string('identifier')->unique();
	        $table->enum('field_type', ['TEXT', 'TEXTAREA', 'CKEDITOR', 'SELECT', 'FILE', 'DATETIME','CHECKBOX','RADIO']);
	        $table->enum('use_as',['SPECIFICATION','VARIATION'])->nullable()->default(null);
	        $table->integer('sort_order')->nullable()->default(0);
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
        Schema::dropIfExists('attributes');
    }
}
