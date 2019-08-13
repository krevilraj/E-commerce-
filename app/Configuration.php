<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'configuration_key',
		'configuration_value',
	];

	public static function getConfiguration( $key ) {
		$model = new static();

		$row = $model->where( 'configuration_key', '=', $key )->first();
		if ( $row != null ) {
			return $row->configuration_value;
		}
	}
}