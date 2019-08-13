<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/9/2017
 * Time: 9:18 PM
 */

namespace App\Repositories\User;

use App\Helpers\Image\LocalImageFile;

use App\User;
use App\Media;


class EloquentUser implements UserRepository {

	/**
	 * @var User
	 */
	private $model;

	public function __construct( User $model ) {
		$this->model = $model;
	}

	public function getAll() {
 $users = User::where( 'active', 1 )
       ->get();

        return $users;	}

	public function getByRole( $role ) {
		$users = User::whereHas( 'roles', function ( $q ) use ( $role ) {
			$q->where( 'name', $role );
            $q->where( 'active', 1 );

		} )->get();

		return $users;
	}

	public function getVisitors() {
		$users = User::whereDoesntHave( 'roles', function ( $q ) {
			$q->where( 'name', 'admin' );
			$q->orWhere( 'name', 'manager' );
		} )->get();

		return $users;
	}
 public function getNonActive() {
        $users = User::where('active',null)->get();



        return $users;
    }

	public function getById( $id ) {
		return $this->model->findOrFail( $id );
	}

	public function create( array $attributes ) {
		$attributes['password'] = bcrypt( $attributes['password'] );

		$user = $this->model->create( $attributes );

		//Attach role
		if ( $attributes['role'] != 0 ) {
			$user->roles()->attach( $attributes['role'] );
		}
        if ( isset( $attributes['image_path'] ) ) {
            $media = new Media();
            $media->upload( $user, $attributes['image_path'], '/uploads/users' );
        }

		return $user;
	}

	public function update( $id, array $attributes ) {
		$user = $this->getById( $id );

        if ( isset( $attributes['image_path'] ) ) {
            // Delete old image from file system
            $path = optional($user->media()->first())->path;
            $this->deleteImage( $path );

            // Clean database links
            $user->media()->delete();

            // Upload new image
            $media = new Media();
            $media->upload( $user, $attributes['image_path'], '/uploads/users' );
        }
		$user->first_name = $attributes['first_name'];
		$user->last_name  = $attributes['last_name'];
		$user->email      = $attributes['email'];
		$user->phone      = $attributes['phone'];
        $user->active = $attributes['active'];

		if ( isset( $attributes['password'] ) ) {
			$user->password = bcrypt( $attributes['password'] );
		}

		$user->save();

		// Update role
		if ( $attributes['role'] != 0 ) {
			$user->roles()->sync( [ $attributes['role'] ] );
		} else {
			$user->roles()->detach();
		}

		return $user;
	}

	public function delete( $id ) {

		$user = $this->getById( $id );

        $path = optional($user->media()->first())->path;

        $this->deleteImage( $path );

        // Clean image database links
        $user->media()->delete();

		// Detach roles
		$user->roles()->detach();
		// Delete prices

		// Delete product
		$user->delete();

		return true;
	}
    public function deleteImage( $path ) {
        if ( null === $path ) {
            return false;
        }

        $localImageFile = new LocalImageFile( $path );
        $localImageFile->destroy();

        return true;
    }
}