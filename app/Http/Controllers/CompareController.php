<?php

namespace App\Http\Controllers;

use App\Product;
use App\Repositories\Product\ProductRepository;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CompareController extends Controller {
	/**
	 * @var ProductRepository
	 */
	private $product;

	public function __construct( ProductRepository $product ) {
		$this->product = $product;
	}

	public function getCompare() {
		$compareList = Cart::instance( 'compare' )->content();

		return view( 'compare.index', compact( 'compareList' ) );
	}

	public function getMiniCompareList() {
		$compareList = Cart::instance( 'compare' )->content();

		return view( 'compare.mini-comparelist', compact( 'compareList' ) );
	}

	public function postCompare( Request $request ) {
		$productId = $request->input( 'product' );
		$product   = $this->product->getById( $productId );

		$cartList = Cart::instance( 'compare' )->add(
			[
				'id'    => $request->input( 'product' ),
				'name'  => $product->name,
				'qty'   => 1,
				'price' => $product->getPrice()
			]
		);

		if ( ! $request->ajax() ) {
			return redirect()->back()->with( 'success', 'Product added to compare list!!' );
		}

		return response()->json( [
			'status'  => 'success',
			'message' => 'Product added to compare list!!'
		], 200 );
	}

	public function clear( $rowId ) {
		Cart::instance( 'compare' )->remove( $rowId );

		if ( ! request()->ajax() ) {
			return redirect()->back()->with( 'success', 'Product added to compare list!!' );
		}

		return response()->json( [
			'status'  => 'success',
			'message' => 'Product successfully removed from compare list!!'
		], 200 );
	}

	public function clearAll() {
		Cart::instance( 'compare' )->destroy();

		return redirect()->back()->with( 'success', 'Compare list cleared!!' );
	}

	public static function getProductInstance( $productId ) {
		return Product::findOrFail( $productId );
	}
}
