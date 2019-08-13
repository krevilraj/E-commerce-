<?php

namespace App\Repositories\Category;

interface CategoryRepository {
	public function getAll();

	public function getCategories();

	public function selectChild( $id );

	public function addRelation( $categories );

	public function getById( $id );

	public function create( array $attributes );

	public function update( $id, array $attributes );

	public function delete( $id );
}