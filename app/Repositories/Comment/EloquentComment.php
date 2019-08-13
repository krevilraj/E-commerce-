<?php

namespace App\Repositories\Comment;

use App\Comment;

class EloquentComment implements CommentRepository {

	/**
	 * @var Comment
	 */
	private $model;

	public function __construct( Comment $model ) {
		$this->model = $model;
	}

	public function getAll() {
		return $this->model->all();
	}

	public function getComments() {

		$comments = Comment::where( 'reply_id', 0 )->get();

		$comments = $this->addRelation( $comments );

		return $comments;

	}

	public function getById( $id ) {
		return $this->model->findOrFail( $id );
	}

	public function create( array $attributes ) {
		return $this->model->create( $attributes );
	}

	public function update( $id, array $attributes ) {
		$comment = $this->getById( $id );
		$comment->update( $attributes );

		return $comment;

	}

	public function delete( $id ) {
		$comment = $this->getById( $id );

		$comment->delete();

		return true;
	}

	public function selectChild( $id ) {
		$comments = Comment::where( 'reply_id', $id )->get();

		$comments = $this->addRelation( $comments );

		return $comments;

	}

	public function addRelation( $comments ) {

		$comments->map( function ( $item, $key ) {

			$sub = $this->selectChild( $item->id );

			return $item = array_add( $item, 'replies', $sub );

		} );

		return $comments;
	}
}