<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Category\CategoryRepository;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller {
	/**
	 * @var CategoryRepository
	 */
	private $category;

	public function __construct( CategoryRepository $category ) {
		$this->category = $category;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$categoriesCount = $this->category->getAll()->count();

		return view( 'backend.categories.index' )
			->with( [
				'allCategories'   => $this->category->getCategories(),
				'categoriesCount' => $categoriesCount
			] );

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
	public function store( Request $request ) {
		$this->validate( $request, [
			'name' => 'required'
		] );

		try {

			$this->category->create( $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in saving category: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Category successfully created!' );
	}

	/**
	 * Edit
	 *
	 * @param $id
	 *
	 * @return $this
	 */
	public function edit( $id ) {
		$cat = $this->category->getById( $id );

		return view( 'backend.categories.edit' )->with( [
			'allCategories' => $this->category->getCategories(),
			'cat'           => $cat
		] );
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
		$this->validate( $request, [
			'name' => 'required'
		] );

		try {

			$this->category->update( $id, $request->all() );

		} catch ( Exception $e ) {

			throw new Exception( 'Error in updating category: ' . $e->getMessage() );
		}

		return redirect()->back()->with( 'success', 'Category successfully updated!' );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		$this->category->delete( $id );

		return redirect()->back()->with( 'success', 'Category successfully deleted!!' );
	}

	public function getCategoriesJson( Request $request ) {
		$categories = $this->category->getAll();

		foreach ( $categories as $categoryKey => $categoryValue ) {
			$categories[ $categoryKey ]['parent'] = isset( $categoryValue->parent->name ) ? $categoryValue->parent : '-';
		}

		return datatables( $categories )->toJson();
	}
}
