<?php

namespace App;

use App\Concern\Mediable;
use App\Events\UserRegistered;
use App\Helpers\Image\LocalImageFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable {
	use Notifiable, EntrustUserTrait, Mediable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'phone',
		'password',
		'provider',
		'provider_id',
 'email_token'
	];

	/**
	 * The event map for the model.
	 *
	 * @var array
	 */
	protected $events = [
		'created' => UserRegistered::class,
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	public function getFullNameAttribute() {
		return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
	}

	public function getImagePathAttribute() {
		return ( empty( $this->attributes['image_path'] ) ) ? null : new LocalImageFile( $this->attributes['image_path'] );
	}

	/**
	 * The roles that belong to the user.
	 */
	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}

	/**
	 * Return the user's posts
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function posts() {
		return $this->hasMany( Post::class );
	}

	/**
	 * Return the user's address
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function addresses() {
		return $this->hasMany( Address::class );
	}

	public function userViewedProducts() {
		return $this->hasMany( UserViewedProduct::class );
	}
    public function enquiries() {
        return $this->hasMany( ProductEnquiry::class );
    }

	public function getShippingAddress() {
		$address = $this->addresses()->where( 'type', '=', 'SHIPPING' )->first();

		return $address;
	}

	public function getBillingAddress() {
		$address = $this->addresses()->where( 'type', '=', 'Billing' )->first();

		return $address;
	}

	public function isInWishlist( $productId ) {
		$wishList = Wishlist::where( 'user_id', '=', $this->attributes['id'] )
		                    ->where( 'product_id', '=', $productId )->get();

		if ( count( $wishList ) <= 0 ) {
			return false;
		}

		return true;
	}
}
