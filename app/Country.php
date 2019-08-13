<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Country extends Model {
	protected $fillable = [
		'name',
		'code',
	];

	public function states() {
		return $this->hasMany( State::class );
	}

	public static function getCountriesOptions( $empty = false ) {
		$model = new static();

		if ( true === $empty ) {
			$return = Collection::make( [ '' => 'Please Select' ] + $model->all()->pluck( 'name', 'id' )->toArray() );
		} else {
			$return = $model->all()->pluck( 'name', 'id' );
		}

		return $return;
	}
}
