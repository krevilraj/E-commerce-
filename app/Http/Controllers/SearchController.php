<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Product;
use Illuminate\Http\Request;
use App\Category;

class SearchController extends Controller {
	use PaginationHelper;

	public function getSearch( Request $request ) {
		$queryParam    = $request->get( 'q' );
		$queryCategory =  $request->get( 'cat' );


		if (  isset( $queryCategory ) ) {
            $products = Product::whereHas( 'categories', function ( $query ) use ( $queryParam, $queryCategory ) {
                $query->where( 'categories.id', $queryCategory );
                $query->where( 'products.slug', 'like', '%' . $queryParam . '%' );
                $query->where( 'products.name', 'like', '%' . $queryParam . '%' );

                $query->where( 'products.status', '=', 1 );
            } )->get();
            $childProduct=Category::where('parent_id','=','0')->take(10)->get();

            return view( 'pages.search' )
                ->with( 'queryParam', $queryParam )
                ->with( 'queryCategory', $queryCategory)

                ->with('childProduct',$childProduct)
                ->with( 'products2', $this->paginateHelper( $products,20) );
        }






			$products = Product::where( 'name', 'LIKE', '%' . $queryParam . '%' )->where( 'status', '=', 1 )->get();

        $childProduct=Category::where('parent_id','=','0')->take(10)->get();

$queryCategory="";
 
        return view( 'pages.search' )
                ->with( 'queryCategory', $queryCategory)

            ->with( 'queryParam', $queryParam )
            ->with('childProduct',$childProduct)
            ->with( 'products2', $this->paginateHelper( $products,20 ) );
		}


}
