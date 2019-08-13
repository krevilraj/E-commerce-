<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {
	protected $fillable = [
		'user_id',
		'type',
		'user_id',
		'first_name',
		'last_name',
		'address1',
		'address2',
		'postcode',
		'city',
		'state_id',
		'country_id',
		'email',
		'phone',
	];

	public function state() {
		return $this->belongsTo( State::class );
	}

	public function country() {
		return $this->belongsTo( Country::class );
	}

	public function getStateIdAttribute() {

		$state = State::findorfail( $this->attributes['state_id'] );

		return $state;
	}

	public function getCountryIdAttribute() {

		if ( isset( $this->attributes['country_id'] ) && $this->attributes['country_id'] > 0 ) {
			return $this->attributes['country_id'];
		}

		$defaultCountry = Configuration::getConfiguration( 'address_default_country' );

		if ( isset( $defaultCountry ) ) {
			return $defaultCountry;
		}

		return "";
	}
}
