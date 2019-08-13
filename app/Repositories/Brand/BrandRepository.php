<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/7/2017
 * Time: 10:38 PM
 */

namespace App\Repositories\Brand;


interface BrandRepository {
	public function getAll();

	public function getById( $id );

	public function create( array $attributes );

	public function update( $id, array $attributes );

	public function delete( $id );
}