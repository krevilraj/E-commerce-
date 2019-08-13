<?php

namespace App\Repositories\Comment;

interface CommentRepository {
	public function getAll();

	public function getComments();

	public function getById( $id );

	public function create( array $attributes );

	public function update( $id, array $attributes );

	public function delete( $id );
}