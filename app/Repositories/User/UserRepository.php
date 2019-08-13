<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/9/2017
 * Time: 9:17 PM
 */

namespace App\Repositories\User;


interface UserRepository {
	public function getAll();

	public function getByRole($role);

	public function getVisitors();

	public function getById( $id );

	public function create( array $attributes );

	public function update( $id, array $attributes );

	public function delete( $id );
}