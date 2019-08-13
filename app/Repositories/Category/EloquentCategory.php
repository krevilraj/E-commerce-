<?php

namespace App\Repositories\Category;

use App\Category;

class EloquentCategory implements CategoryRepository {

	/**
	 * @var Category
	 */
	private $model;

	public function __construct( Category $model ) {
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
		$category = $this->getById( $id );
		$category->update( $attributes );

		return $category;

	}

	public function delete( $id ) {
		$category = $this->getById( $id );
		// Delete from pivot table as well
		$category->products()->detach( $id );

		$category->delete();

		return true;
	}

	public function getCategories() {

		$categories = Category::where( 'parent_id', 0 )->get();

		$categories = $this->addRelation( $categories );

		return $categories;

	}

	public function selectChild( $id ) {
		$categories = Category::where( 'parent_id', $id )->get(); //rooney

		$categories = $this->addRelation( $categories );

		return $categories;

	}

	public function addRelation( $categories ) {

		$categories->map( function ( $item, $key ) {

			$sub = $this->selectChild( $item->id );

			return $item = array_add( $item, 'subCategory', $sub );

		} );

		return $categories;
	}
}