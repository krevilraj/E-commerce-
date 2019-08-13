<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	use Sluggable;

	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
	 */
	public function sluggable() {
		return [
			'slug' => [
				'source' => 'name'
			]
		];
	}

	/**
	 * @var array
	 */
	protected $fillable = [
		'parent_id',
		'name',
		'slug'
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'created_at',
		'updated_at'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function products() {
		return $this->belongsToMany( Product::class );
	}

	public function getParentAttribute() {
		return Category::where( 'id', '=', $this->attributes['parent_id'] )->first();
	}

	public function getCreatedAtAttribute( $value ) {
		return Carbon::parse( $value )->format( 'F j, Y g:i a' );
	}

}
