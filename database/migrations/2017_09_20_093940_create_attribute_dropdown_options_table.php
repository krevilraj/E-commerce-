<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeDropdownOptionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'attribute_dropdown_options', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'attribute_id' )->unsigned();
			$table->string( 'display_text' );
			$table->timestamps();
			$table->foreign( 'attribute_id' )->references( 'id' )->on( 'attributes' )->onDelete( 'cascade' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'attribute_dropdown_options' );
	}
}
