<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\BrandRequest;
use App\Repositories\Brand\BrandRepository;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller {
	/**
	 * @var BrandRepository
	 */
	private $brand;

	public function __construct( BrandRepository $brand ) {
		$this->brand = $brand;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$brandsCount = $this->brand->getAll()->count();

		return view( 'backend.brands.index', compact( 'brandsCount' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'backend.brands.create' );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param BrandRequest|Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function store( BrandRequest $request ) {

		try {

			$this->brand->create( $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in saving brand: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Brand successfully created!' );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$brand = $this->brand->getById( $id );

		return view( 'backend.brands.edit', compact( 'brand' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function update( Request $request, $id ) {
		try {

			$this->brand->update( $id, $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in updating brand: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Brand successfully updated!!' );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		$this->brand->delete( $id );

		return redirect()->back()->with( 'success', 'Brand successfully deleted!!' );
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getBrandsJson( Request $request ) {
		$brands = $this->brand->getAll();

		foreach ( $brands as $brand ) {
			$brand->author         = $brand->user->full_name;
			$image                = null !== $brand->getImage() ? $brand->getImage()->smallUrl : $brand->getDefaultImage()->smallUrl;
			$brand->featured_image = $image;
		}

		return datatables( $brands )->toJson();
	}
}
