<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/19/2017
 * Time: 12:28 PM
 */

namespace App\Http\ViewComposers;


use App\Repositories\Testimonial\TestimonialRepository;
use Illuminate\Contracts\View\View;

class TestimonialListComposer {
	/**
	 * @var TestimonialRepository
	 */
	private $testimonial;

	public function __construct( TestimonialRepository $testimonial ) {
		$this->testimonial = $testimonial;
	}

	/**
	 * Bind data to the view.
	 *
	 * @param View $view
	 */
	public function compose( View $view ) {
		$testimonials = $this->testimonial->getAll();

		$view->with( 'testimonials', $testimonials );
	}
}