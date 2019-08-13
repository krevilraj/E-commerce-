<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/5/2017
 * Time: 10:39 PM
 */

namespace App\Repositories\Review;


use App\Review;

class EloquentReview implements ReviewRepository {

	/**
	 * @var Review
	 */
	private $model;

	public function __construct( Review $model ) {
		$this->model = $model;
	}

	public function getAll() {
		return $this->model->all();
	}

	public function getById( $id ) {
		return $this->model->findOrFail( $id );
	}

	public function create( array $attributes ) {
		return $this->model->create( $attributes );
	}

	public function update( $id, array $attributes ) {
		$review               = $this->getById( $id );
		$attributes['status'] = $attributes['status'] == 'ENABLED' ? 'DISABLED' : 'ENABLED';

		$review->update( $attributes );

		return $review;
	}

	public function delete( $id ) {
		$review = $this->getById( $id );
		$review->delete();

		return true;
	}
}