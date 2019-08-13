<?php

namespace App;

use App\Helpers\Image\LocalImageFile;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
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
		'type',
		'name',
		'slug',
		'sku',
		'short_description',
		'description',
		'track_stock',
		'stock_qty',
		'in_stock',
		'is_taxable',
		'is_featured',
		'disable_price',
		'status',
		'page_title',
		'page_description',
	];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function reviews() {
		return $this->hasMany( Review::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function prices() {
		return $this->hasMany( ProductPrice::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function images() {
		return $this->hasMany( ProductImage::class );
	}

	public function categories() {
		return $this->belongsToMany( Category::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function enquiries() {
		return $this->hasMany( ProductEnquiry::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function orders() {
		return $this->hasMany( Order::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function specifications() {
		return $this->hasMany( ProductSpecification::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function faqs() {
		return $this->hasMany( ProductFaq::class );
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function downloads() {
		return $this->hasMany( ProductDownload::class );
	}

	/**
	 * Get regular product for the product
	 *
	 * @return mixed|null
	 */
	public function getRegularPriceAttribute() {
		$row = $this->prices()->first();

		return ( isset( $row->regular_price ) ) ? $row->regular_price : null;
	}

	/**
	 * Get sale price for the product
	 *
	 * @return mixed|null
	 */
	public function getSalePriceAttribute() {
		$row = $this->prices()->first();

		return ( isset( $row->sale_price ) ) ? $row->sale_price : null;
	}

	public function getPrice() {
		return $this->getSalePriceAttribute() ? $this->getSalePriceAttribute() : $this->getRegularPriceAttribute();
	}

	public function getDiscountPercentage() {
		if ( ! $this->getSalePriceAttribute() ) {
			return 0;
		}

		$percentage = round( ( ( $this->getRegularPriceAttribute() - $this->getSalePriceAttribute() ) / $this->getRegularPriceAttribute() ) * 100 );

		return $percentage;
	}

	/**
	 * Return default image or LocalImageFile Object
	 *
	 * @return LocalImageFile|mixed
	 */
	public function getImageAttribute() {
		$defaultPath = "/img/default-product.jpg";
		$image       = $this->images()->where( 'is_main_image', '=', 1 )->first();

		if ( null === $image ) {
			return new LocalImageFile( $defaultPath );
		}

		if ( $image->path instanceof LocalImageFile ) {
			return $image->path;
		}

	}

	public function getProductGallery() {
		$gallery = $this->images()->get();

		if ( null === $gallery ) {
			return null;
		}

		$galleryArray = [];

		foreach ( $gallery as $gal ) {
			$galleryArray[] = $gal->path;
		}

		return $galleryArray;
	}

	public function getReviews() {
		return $this->reviews()->where( 'status', '=', 'ENABLED' )->get();
	}

	public function getAverageRating() {
		return $this->reviews()->where( 'status', '=', 'ENABLED' )->avg( 'star' );
	}

	public function getRatingPercentage() {
		return ( $this->getAverageRating() * 100 ) / 5;
	}

}
