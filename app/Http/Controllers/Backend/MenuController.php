<?php

namespace App\Http\Controllers\Backend;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller {
	public function index() {
		return view( 'backend.menus.index' );
	}

	public function addmenu( Request $request ) {
		if ( ! $request->has( 'data' ) ) {
			return response()->json( [
				'success' => false,
				'message' => 'Something went wrong!'
			] );
		}

		foreach ( $request->data as $data ) {
			DB::table( 'menu_items' )->insert( [
				'label' => $data['labelmenu'],
				'link'  => $data['linkmenu'],
				'menu'  => $data['idmenu'],
			] );
		}

		return response()->json( [
			'success' => true,
			'message' => 'Menu successfully added!'
		] );
	}
}
