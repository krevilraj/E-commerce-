<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/13/2017
 * Time: 11:13 AM
 */

namespace App\Repositories\Slideshow;


use App\Helpers\Image\LocalImageFile;
use App\Media;
use App\Slideshow;

class EloquentSlideshow implements SlideshowRepository {
	/**
	 * @var Slideshow
	 */
	private $model;

	public function __construct( Slideshow $model ) {
		$this->model = $model;
	}

	public function getAll() {
		return $this->model->all();
	}

	public function getById( $id ) {
		return $this->model->findOrFail( $id );
	}

	public function create( array $attributes ) {
		$attributes['user_id'] = auth()->id();

		$slideshow = $this->model->create( $attributes );

		// Upload image
		if ( isset( $attributes['featured_image'] ) ) {
			$media = new Media();
			$media->upload( $slideshow, $attributes['featured_image'], '/uploads/slideshows/' );
		}

		return $slideshow;
	}

	public function update( $id, array $attributes ) {
		$slideshow = $this->getById( $id );

		// Upload image
		if ( isset( $attributes['featured_image'] ) ) {
			// Delete old image from file system
			$path = optional($slideshow->media()->first())->path;
			$this->deleteImage( $path );

			// Clean database links
			$slideshow->media()->delete();

			// Upload new image
			$media = new Media();
			$media->upload( $slideshow, $attributes['featured_image'], '/uploads/slideshows/' );
		}

		$slideshow->update( $attributes );

		return $slideshow;
	}

	public function delete( $id ) {
		$slideshow = $this->getById( $id );

		// Delete image
		$path = optional($slideshow->media()->first())->path;
		$this->deleteImage( $path );

		// Clean image database links
		$slideshow->media()->delete();

		$slideshow->delete();

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