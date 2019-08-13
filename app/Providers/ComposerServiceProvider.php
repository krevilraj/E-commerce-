<?php

namespace App\Providers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		view()->composer(
			[ 'layouts.app', 'index' ], 'App\Http\ViewComposers\MenuListComposer'
		);

		view()->composer(
			[ 'vendor.harimayco-menu.menu-html' ], 'App\Http\ViewComposers\PageListComposer'
		);

		view()->composer(
			[
				'vendor.harimayco-menu.menu-html',
				'layouts.app',
				'partials.shop-sidebar',
                'single-product.single-product',
                'my-account.index'

			], 'App\Http\ViewComposers\ProductCategoryListComposer'
		);

		view()->composer(
			[ 'partials.shop-sidebar' ], 'App\Http\ViewComposers\BrandListComposer'
		);

		view()->composer([

			'pages.templates.shop',
            'blog.sidebar',
            'my-account.index'
           ],'App\Http\ViewComposers\ProductListComposer'
		);

		view()->composer(
			[ 'pages.templates.blog' ], 'App\Http\ViewComposers\PostListComposer'
		);

		view()->composer(
			[
				'pages.templates.about',
				'pages.templates.testimonials'
			], 'App\Http\ViewComposers\TestimonialListComposer'
		);

		view()->composer(
			[ 'pages.templates.about' ], 'App\Http\ViewComposers\TeamListComposer'
		);


	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
