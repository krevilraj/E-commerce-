<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/12/2017
 * Time: 11:50 PM
 */

namespace App\Http\ViewComposers;

use App\Brand;
use App\Helpers\PaginationHelper;
use App\Repositories\Brand\BrandRepository;
use Illuminate\View\View;

class BrandListComposer {
	use PaginationHelper;
	/**
	 * @var BrandRepository
	 */
	private $brand;

	public function __construct( BrandRepository $brand ) {
		$this->brand = $brand;
	}

	/**
	 * Bind data to the view.
	 *
	 * @param View $view
	 */
	public function compose( View $view ) {
        $brands         = Brand::orderBy('priority','ASC')->get();

          $paginateProducts = $this->paginateHelper( $brands, 10 );

           $view->with( 'brands', $paginateProducts );
	}
}