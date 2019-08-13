<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\TestimonialRequest;
use App\Repositories\Testimonial\TestimonialRepository;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller {
	/**
	 * @var TestimonialRepository
	 */
	private $testimonial;

	public function __construct( TestimonialRepository $testimonial ) {
		$this->testimonial = $testimonial;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$testimonialsCount = $this->testimonial->getAll()->count();

		return view( 'backend.testimonials.index', compact( 'testimonialsCount' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'backend.testimonials.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param TestimonialRequest|Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function store( TestimonialRequest $request ) {
		try {

			$this->testimonial->create( $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in saving page: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Testimonial successfully created!' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$testimonial = $this->testimonial->getById( $id );

		return view( 'backend.testimonials.edit', compact( 'testimonial' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function update( Request $request, $id ) {
		try {

			$this->testimonial->update( $id, $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in updating testimonial: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Testimonial successfully updated!' );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function destroy( $id ) {
		try {

			$this->testimonial->delete( $id );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in updating testimonial: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Testimonial successfully deleted!' );
	}

	public function getTestimonialsJson( Request $request ) {
		$testimonials = $this->testimonial->getAll();

		foreach ( $testimonials as $testimonial ) {
			$testimonial->author         = $testimonial->user->full_name;
			$image                       = null !== $testimonial->getImage() ? $testimonial->getImage()->smallUrl : $testimonial->getDefaultImage()->smallUrl;
			$testimonial->featured_image = $image;
		}

		return datatables( $testimonials )->toJson();
	}
}
