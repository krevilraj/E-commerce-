<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/6/2017
 * Time: 6:27 PM
 */

namespace App\Http\ViewComposers;

use App\Helpers\PaginationHelper;
use App\Repositories\Post\PostRepository;
use Illuminate\Contracts\View\View;

class PostListComposer {
	use PaginationHelper;
	/**
	 * @var PostRepository
	 */
	private $post;

	public function __construct( PostRepository $post ) {
		$this->post = $post;
	}

	/**
	 * Bind data to the view.
	 *
	 * @param View $view
	 */
	public function compose( View $view ) {
		$posts         = $this->post->getAll();
		$paginatePosts = $this->paginateHelper( $posts, 8 );

		$view->with( 'posts', $paginatePosts );
	}
}