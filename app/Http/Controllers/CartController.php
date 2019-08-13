<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Repositories\Product\ProductRepository;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller {

	/**
	 * @var ProductRepository
	 */
	private $product;

	public function __construct( ProductRepository $product ) {
		$this->product = $product;
	}

	public function index() {
		return view( 'cart.index' );
	}

	public function store( CartRequest $request ) {
		$productId = $request->input( 'product' );
		$quantity  = $request->input( 'quantity' );

		$product = $this->product->getById( $productId );
		$price   = $this->getProductPrice( $product );

		Cart::add( [
			'id'    => $product->id,
			'name'  => $product->name,
			'qty'   => $quantity,
			'price' => $price
		] );

		if(!$request->ajax()){
			return redirect()->back()->with( 'success', 'Product added to cart!!' );
		}

		return response()->json( [
			'status'  => 'success',
			'message' => 'Product successfully added to cart.'
		], 200 );

	}

	public function update( Request $request ) {

		foreach ( $request->input( 'cartContents' ) as $cartContent ) {
			$rowId    = $cartContent['rowId'];
			$quantity = $cartContent['quantity'];

			// Update the quantity
			Cart::update( $rowId, $quantity );
		}

		return response()->json( [
			'status'  => 'success',
			'message' => 'Cart successfully updated.'
		], 200 );
	}

	public function destroyRow( $rowId ) {
		Cart::remove( $rowId );

		return response()->json( [
			'status'  => 'success',
			'message' => 'Product successfully removed from cart.'
		], 200 );
	}

	public function destroy() {
		Cart::destroy();

		return response()->json( [
			'status'  => 'success',
			'message' => 'Cart successfully cleared.'
		], 200 );
	}

	public function getMiniCart() {
		$cartContents = Cart::content();
		$cartTotal    = Cart::total();

		return view( 'cart.mini-cart', compact( 'cartContents', 'cartTotal' ) );
	}

	protected function getProductPrice( $product ) {
		return isset( $product->prices->first()->sale_price ) ? $product->prices->first()->sale_price : $product->prices->first()->regular_price;
	}

}
