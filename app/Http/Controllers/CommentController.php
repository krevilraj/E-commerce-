<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Repositories\Comment\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller {
	/**
	 * @var CommentRepository
	 */
	private $comment;

	/**
	 * CommentController constructor.
	 *
	 * @param CommentRepository $comment
	 */
	public function __construct( CommentRepository $comment ) {
		$this->comment = $comment;
	}

	/**
	 * @param CommentRequest $request
	 * @param $postId
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function storeComment( CommentRequest $request, $postId ) {
		if ( auth()->guest() ) {
			return response()->json( [
				'status'  => 'error',
				'message' => 'Please login to comment!!'
			], 401 );
		}

		$comment = new Comment();

		$comment->user_id  = auth()->id();
		$comment->post_id  = $postId;
		$comment->comment  = $request->input( 'comment' );
		$comment->reply_id = $request->input( 'reply_id' );

		$comment->save();

		return response()->json( [
			'status'  => 'success',
			'message' => 'Comment successfully posted!!'
		] );
	}
}
