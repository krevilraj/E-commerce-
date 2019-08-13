<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {
	public function storeReview( Request $request ) {
		$request->validate( [
			'star'    => 'required',
			'comment' => 'required',
		] );

		$review             = new Review();
		$review->user_id    = auth()->id();
		$review->product_id = $request->product_id;
		$review->star       = $request->star;
		$review->comment    = $request->comment;

		$review->save();

		return redirect()->back()->with( 'success', 'Review successfully added!' );
	}
}
