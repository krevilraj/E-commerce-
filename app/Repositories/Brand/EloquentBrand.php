<?php
/**
 * Created by PhpStorm.
 * User: Mahesh Bohara <maheshbohara0101@gmail.com>
 * Date: 10/7/2017
 * Time: 10:39 PM
 */

namespace App\Repositories\Brand;

use App\Brand;
use App\Helpers\Image\LocalImageFile;
use App\Media;

class EloquentBrand implements BrandRepository {

	/**
	 * @var Brand
	 */
	private $model;

	public function __construct( Brand $model ) {
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

		$brand = $this->model->create( $attributes );

		// Upload image
		if ( isset( $attributes['featured_image'] ) ) {
			$media = new Media();
			$media->upload( $brand, $attributes['featured_image'], '/uploads/brands/' );
		}

		return $brand;
	}

	public function update( $id, array $attributes ) {
		$brand = $this->getById( $id );

		// Upload image
		if ( isset( $attributes['featured_image'] ) ) {
			// Delete old image from file system
			$path = optional($brand->media()->first())->path;
			$this->deleteImage( $path );

			// Clean database links
			$brand->media()->delete();

			// Upload new image
			$media = new Media();
			$media->upload( $brand, $attributes['featured_image'], '/uploads/brands/' );
		}

		$brand->update( $attributes );

		return $brand;
	}

	public function delete( $id ) {
		$brand = $this->getById( $id );

		// Delete image
		$path = optional($brand->media()->first())->path;
		$this->deleteImage( $path );

		// Clean image database links
		$brand->media()->delete();

		$brand->delete();

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