<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class BlogController extends Controller {
	public function index() {
		$posts = Post::orderby( 'id', 'DESC' )->paginate(8);

		return view( 'blog.index', compact( 'posts' ) );
	}

	public function show( $slug ) {
		$post = Post::where( 'slug', $slug )->first();

		return view( 'blog.blog-single', compact( 'post' ) );
	}
}
