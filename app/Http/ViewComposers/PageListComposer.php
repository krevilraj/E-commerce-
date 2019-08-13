<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/6/2017
 * Time: 6:27 PM
 */

namespace App\Http\ViewComposers;

use App\Helpers\PaginationHelper;
use App\Repositories\Page\PageRepository;
use Illuminate\Contracts\View\View;

class PageListComposer {
	use PaginationHelper;
	/**
	 * @var PageRepository
	 */
	private $page;

	public function __construct( PageRepository $page ) {
		$this->page = $page;
	}

	/**
	 * Bind data to the view.
	 *
	 * @param View $view
	 */
	public function compose( View $view ) {
		$pages         = $this->page->getAll();

		$view->with( 'pages', $pages );
	}
}