<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDownload extends Model
{
    /**
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'product_id',
		'title',
		'link'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo( User::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function product() {
		return $this->belongsTo( Product::class );
	}
}
