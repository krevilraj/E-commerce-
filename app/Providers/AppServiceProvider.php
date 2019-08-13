<?php

namespace App\Providers;

use App\Repositories\Brand\BrandRepository;
use App\Repositories\Brand\EloquentBrand;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\EloquentComment;
use App\Repositories\Order\EloquentOrder;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Page\EloquentPage;
use App\Repositories\Page\PageRepository;
use App\Repositories\Post\EloquentPost;
use App\Repositories\Post\PostRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\EloquentProduct;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\EloquentCategory;
use App\Repositories\Review\EloquentReview;
use App\Repositories\Review\ReviewRepository;
use App\Repositories\Slideshow\EloquentSlideshow;
use App\Repositories\Slideshow\SlideshowRepository;
use App\Repositories\Team\EloquentTeam;
use App\Repositories\Team\TeamRepository;
use App\Repositories\Testimonial\EloquentTestimonial;
use App\Repositories\Testimonial\TestimonialRepository;
use App\Repositories\User\EloquentUser;
use App\Repositories\User\UserRepository;
use App\Repositories\Message\EloquentMessage;
use App\Repositories\Message\MessageRepository;
use App\Repositories\Request\RequestRepository;
use App\Repositories\Request\EloquentRequest;
use App\Repositories\About\AboutRepository;
use App\Repositories\About\EloquentAbout;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Schema::defaultStringLength( 191 );
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->singleton( ProductRepository::class, EloquentProduct::class );
		$this->app->singleton( CategoryRepository::class, EloquentCategory::class );
		$this->app->singleton( OrderRepository::class, EloquentOrder::class );
		$this->app->singleton( PageRepository::class, EloquentPage::class );
		$this->app->singleton( ReviewRepository::class, EloquentReview::class );
		$this->app->singleton( PostRepository::class, EloquentPost::class );
		$this->app->singleton( BrandRepository::class, EloquentBrand::class );
		$this->app->singleton( UserRepository::class, EloquentUser::class );
		$this->app->singleton( SlideshowRepository::class, EloquentSlideshow::class );
		$this->app->singleton( TestimonialRepository::class, EloquentTestimonial::class );
		$this->app->singleton( TeamRepository::class, EloquentTeam::class );
        $this->app->singleton( RequestRepository::class, EloquentRequest::class );
        $this->app->singleton( MessageRepository::class, EloquentMessage::class );

        $this->app->singleton( CommentRepository::class, EloquentComment::class );
        $this->app->singleton( AboutRepository::class, EloquentAbout::class );

    }
}
