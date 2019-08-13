<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Image\LocalImageFile;
use App\Http\Requests\ProfileRequest;
use App\Media;
use Auth;
use App\Http\Controllers\Controller;

class ProfileController extends Controller {
	public function getProfile() {
		$user = Auth::user();

		return view( 'backend.profile.index', compact( 'user' ) );
	}

	public function postProfile( ProfileRequest $request ) {
		$user = Auth::user();

		$user->first_name = $request->input( 'first_name' );
		$user->last_name  = $request->input( 'last_name' );
		$user->email      = $request->input( 'email' );
		$user->phone      = $request->input( 'phone' );

		if ( $request->has( 'password' ) ) {
			$user->password = bcrypt( $request->input( 'password' ) );
		}

		$user->save();

		// Upload image
		if ( $request->has( 'avatar' ) ) {
			// Delete old image from file system
			$path = optional( $user->media()->first() )->path;
			$this->deleteImage( $path );

			// Clean database links
			$user->media()->delete();

			// Upload new image
			$media = new Media();
			$media->upload( $user, $request->file( 'avatar' ), '/uploads/users/' . str_slug( $user->getFullNameAttribute(), '-' ) . '/' );
		}

		return redirect()->back()->with( 'success', 'Profile successfully updated!' );
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
