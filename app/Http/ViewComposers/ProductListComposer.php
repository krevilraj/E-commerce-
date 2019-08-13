<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/2/2017
 * Time: 11:47 PM
 */

namespace App\Http\ViewComposers;

use App\Helpers\PaginationHelper;
use App\Product;
use App\ProductPrice;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductListComposer {
	use PaginationHelper;
	/**
	 * @var ProductRepository
	 */
	private $product;

	public function __construct( ProductRepository $product ) {
		$this->product = $product;
	}

	/**
	 * Bind data to the view.
	 *
	 * @param View $view
	 */
	public function compose( View $view )
    {
        $lat=Product::orderBy('id','DESC')->get();
        $products = $this->product->getAll();

        if (request()->has('count')) {
            $count = request()->input('count');
            $products = $this->product->getAll();


        } else {
            $count = 12;
        }


        if (request()->has('orderby')) {
            if (request()->input('orderby') == 2) {

                $products = Product::orderBy('created_at', 'ASC')->get();


            } elseif (request()->input('orderby') == 1) {

                $products = $this->product->getAll();

            } elseif (request()->input('orderby') == 6) {

                $products = Product::leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                    ->orderBy('regular_price', 'DESC')
                    ->get();

            } elseif (request()->input('orderby') == 5) {
                $products = Product::leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                    ->orderBy('regular_price', 'ASC')
                    ->get();


            } elseif (request()->input('orderby') == 3) {

                $products = $this->product->getAll();


            } elseif (request()->input('orderby') == 4) {


                $products = Product::orderBy('created_at', 'DESC')->get();


            }
        }

         $min = request()->input('min_price');
        $max = request()->input('max_price');
        if (  isset( $min )  && isset( $min )) {
            $products = Product::leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                ->where('regular_price', '>', $min)
                ->where('regular_price', '<', $max)
                ->get();
        }








        $paginateProducts = $this->paginateHelper( $products, $count );

		$view->with( 'products', $paginateProducts )
        ->with( 'lat', $lat );
	}
}