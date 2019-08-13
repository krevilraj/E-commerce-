<?php

namespace App\Http\Controllers;
use App\Brand;

use App\Repositories\Brand\BrandRepository;
use Illuminate\Http\Request;

class BrandController extends Controller {
	/**
	 * @var BrandRepository
	 */
	private $brand;

	public function __construct( BrandRepository $brand ) {
		$this->brand = $brand;
	}

	public function index() {
		$brands = Brand::orderBy('priority','ASC')->get();


		return view( 'brands.index', compact( 'brands' ) );
	}
}
