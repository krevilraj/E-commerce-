<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/13/2017
 * Time: 11:13 AM
 */

namespace App\Repositories\Slideshow;

interface SlideshowRepository {
	public function getAll();

	public function getById( $id );

	public function create( array $attributes );

	public function update( $id, array $attributes );

	public function delete( $id );
}