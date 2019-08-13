<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishlistRequest;
use App\Product;
use App\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller {
	/**
	 * Display wishlist
	 *
	 * @return $this
	 */
	public function index() {
		$wishlists = Wishlist::where( [
			'user_id' => auth()->id()
		] )->get();


		return view( 'my-account.wishlist' )
			->with( 'wishlists', $wishlists );
	}

	/**
	 * Add product to user wishlist
	 *
	 * @param WishlistRequest|Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @internal param $productId
	 *
	 * @internal param $id
	 */
	public function store( WishlistRequest $request ) {
		if ( auth()->guest() ) {
			return response()->json( [
				'status'  => 'error',
				'message' => 'Please login to add this product in your wishlist!!'
			], 401 );
		}

		$productId = $request->input('product');

		$wishlist = new Wishlist();

		if ( $wishlist->isInWishlist( $productId ) ) {
			return response()->json( [
				'status'  => 'success',
				'message' => 'Product added into your wishlist!!'
			], 200 );
		}

		$product = Product::findOrFail( $productId );

		$wishlist->create( [
			'user_id'    => auth()->id(),
			'product_id' => $product->id,
		] );

		return response()->json( [
			'status'  => 'success',
			'message' => 'Product added into your wishlist!!'
		], 201 );

	}

	/**
	 * Destroy product form wishlist
	 *
	 * @param $productId
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @internal param $id
	 *
	 */
	public function destroy( $productId ) {
		$product = Product::findOrFail( $productId );

		Wishlist::where( [
			'user_id'    => auth()->id(),
			'product_id' => $product->id,
		] )->delete();

		return redirect()->back()->with( 'success', 'Product removed from your wishlist!!' );
	}
}
