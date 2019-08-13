<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/3/2017
 * Time: 1:19 PM
 */

namespace App\Http\ViewComposers;


use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\View\View;

class CartListComposer {
	/**
	 * Bind data to the view.
	 *
	 * @param View $view
	 */
	public function compose( View $view ) {
		$cartContents = Cart::content();
		$cartTotal    = Cart::total();
		$enquiryList = Cart::instance( 'enquiry' )->content();
		$compareList = Cart::instance( 'compare' )->content();

		$view->with( [
			'cartContents' => $cartContents,
			'cartTotal'    => $cartTotal,
			'enquiryList'  => $enquiryList,
			'compareList'  => $compareList,
		] );
	}
}