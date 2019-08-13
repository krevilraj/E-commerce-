<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/6/2017
 * Time: 1:46 PM
 */

namespace App\Repositories\Post;

use App\Helpers\Image\LocalImageFile;
use App\Media;
use App\Post;

class EloquentPost implements PostRepository {
	/**
	 * @var Post
	 */
	private $model;

	public function __construct( Post $model ) {
		$this->model = $model;
	}

	public function getAll() {
		return $this->model->all();
	}

	public function getById( $id ) {
		return $this->model->findOrFail( $id );
	}

	/**
	 * @param array $attributes
	 *
	 * @return mixed
	 */
	public function create( array $attributes ) {
		$attributes['user_id'] = auth()->id();

		$post = $this->model->create( $attributes );

		// Upload image
		if ( isset( $attributes['featured_image'] ) ) {
			$media = new Media();
			$media->upload( $post, $attributes['featured_image'], '/uploads/posts/' );
		}

		return $post;
	}

	public function update( $id, array $attributes ) {
		$post = $this->getById( $id );

		// Upload image
		if ( isset( $attributes['featured_image'] ) ) {
			// Delete old image from file system
			$path = optional($post->media()->first())->path;
			$this->deleteImage( $path );

			// Clean database links
			$post->media()->delete();

			// Upload new image
			$media = new Media();
			$media->upload( $post, $attributes['featured_image'], '/uploads/posts/' );
		}

		$post->update( $attributes );

		return $post;
	}

	public function delete( $id ) {
		$post = $this->getById( $id );

		// Delete image
		$path = optional($post->media()->first())->path;
		$this->deleteImage( $path );

		// Clean image database links
		$post->media()->delete();

		$post->delete();

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