<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'pages', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( 'user_id' )->unsigned();
			$table->string( 'name' );
			$table->string( 'slug' )->unique();
			$table->text( 'content' )->nullable();
			$table->integer( 'parent' )->nullable()->default(0);
			$table->string( 'template' )->nullable();
			$table->string( 'meta_title' )->nullable();
			$table->string( 'meta_description' )->nullable();
			$table->timestamps();

			$table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'pages' );
	}
}
