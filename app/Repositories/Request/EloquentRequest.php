<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/5/2017
 * Time: 10:39 PM
 */

namespace App\Repositories\Request;


use App\RequestProduct;


class EloquentRequest implements RequestRepository {

	/**
	 * @var Review
	 */
	private $model;

	public function __construct(RequestProduct $model ) {
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


	public function delete( $id ) {
		$review = $this->getById( $id );
		$review->delete();

		return true;
	}
}