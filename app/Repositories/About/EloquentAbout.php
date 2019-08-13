<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/5/2017
 * Time: 10:39 PM
 */

namespace App\Repositories\About;


use App\About;
use App\Helpers\Image\LocalImageFile;
use App\Media;


class EloquentAbout implements AboutRepository {

	/**
	 * @var Review
	 */
	private $model;

	public function __construct(About $model ) {
		$this->model = $model;
	}

	public function getAll() {
		return $this->model->all();
	}

	public function getById( $id ) {
		return $this->model->findOrFail( $id );
	}

	public function create( array $attributes ) {
		$post= $this->model->create( $attributes );

        if ( isset( $attributes['featured_image'] ) ) {
            $media = new Media();
            $media->upload( $post, $attributes['featured_image'], '/uploads/about' );
        }
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