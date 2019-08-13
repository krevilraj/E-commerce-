<?php

namespace App\Http\Controllers;

use App\Category;
use App\Helpers\PaginationHelper;

class CategoryController extends Controller {
	use PaginationHelper;

	public function index( $slug ) {
		$category = Category::where( 'slug', $slug )->firstOrFail();

        $products = $category->products;
        

        $parent=Category::where('slug',$slug)->first();

        $childProduct=Category::where( 'parent_id', $parent->id)->take(10)->get();


        if (request()->has('count')) {
            $count = request()->input('count');


        } else {
            $count = 12;
        }
        if (request()->has('orderby')) {
            if (request()->input('orderby') == 2) {

                $products = $category->products()->orderBy('created_at', 'ASC')->get();


            }
            elseif (request()->input('orderby') == 1) {

                $products = $category->products;

            }
            elseif (request()->input('orderby') == 3) {


                $products = $category->products()->orderBy('created_at', 'DESC')->get();

            }elseif (request()->input('orderby') == 5) {

                $products = $category->products()->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                    ->orderBy('regular_price', 'DESC')
                    ->get();

            } elseif (request()->input('orderby') == 4) {
                $products = $category->products()->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                    ->orderBy('regular_price', 'ASC')
                    ->get();


            }



            }

        $min = request()->input('min_price');
        $max = request()->input('max_price');
        if (  isset( $min )  && isset( $min )) {
            $products = $category->products()->leftJoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                ->where('regular_price', '>', $min)
                ->where('regular_price', '<', $max)
                ->get();
        }





            $paginateProducts = $this->paginateHelper( $products, $count );

        return view( 'pages.product-category-archive' )
			->with( [
				'category' => $category,
				'childProduct'=>$childProduct,
				'products' => $paginateProducts
			] );
	}
}
