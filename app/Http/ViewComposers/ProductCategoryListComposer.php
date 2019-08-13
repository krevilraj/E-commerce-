<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/2/2017
 * Time: 11:47 PM
 */

namespace App\Http\ViewComposers;

use App\Category;
use App\Helpers\PaginationHelper;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductCategoryListComposer {
	use PaginationHelper;
	/**
	 * @var CategoryRepository
	 */
	private $category;

	public function __construct( CategoryRepository $category ) {
		$this->category = $category;
	}

	/**
	 * Bind data to the view.
	 *
	 * @param View $view
	 */
	public function compose( View $view ) {
		$categories = $this->category->getCategories();
$main=DB::table('menu_items')->where('menu','2')->where('depth','0')->orderBy('label','ASC')->get();
		$view->with( 'productCategories', $categories )
            ->with( 'mainCategory', $main );
	}
}