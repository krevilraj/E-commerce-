<?php

namespace App;

use App\Helpers\Image\LocalImageFile;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model {
	/**
	 * @var array
	 */
	protected $fillable = [ 'product_id', 'path', 'is_main_image' ];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function products() {
		return $this->belongsTo( Product::class );
	}

	public function getPathAttribute() {
		if ( null === $this->attributes['path'] || empty( $this->attributes['path'] ) ) {
			return null;
		}
		$localImage = new LocalImageFile( $this->attributes['path'] );

		return $localImage;
	}

}
