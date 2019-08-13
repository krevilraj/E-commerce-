<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Review\ReviewRepository;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller {
	/**
	 * @var ReviewRepository
	 */
	private $review;

	public function __construct( ReviewRepository $review ) {
		$this->review = $review;
	}

	public function index() {

		$reviews = $this->review->getAll();

		return view( 'backend.reviews.index', compact( 'reviews' ) );
	}

	public function getReviewsJson( Request $request ) {
		$reviews = $this->review->getAll();


        foreach ( $reviews as $review ) {
            $review->user_name = $review->user->full_name;
            $review->product_id = optional($review->product()->first())->id;
            $review->product_name = optional($review->product()->first())->name;
        }

		return datatables( $reviews )->toJson();
	}

	public function updateStatus( Request $request, $id ) {
		try {

			$this->review->update( $id, $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in Saving Product: ' . $e->getMessage() );
		}

		return response()->json( [
			'success' => true,
			'message' => 'Review status successfully updated!!'
		] );
	}

	public function destroy( $id ) {
		$this->review->delete( $id );

        return redirect()->back()->with( 'success', 'Review successfully deleted!!' );

    }
}
