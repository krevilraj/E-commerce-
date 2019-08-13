<?php

Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/user-login', 'WelcomeController@my_account');


Route::get('/about-messages', 'WelcomeController@about')->name('about-message');
Route::get('/vertification', 'WelcomeController@get')->name('vertification');
Route::get('/pending', 'WelcomeController@pending')->name('pending');

Auth::routes();
Route::get('resendmail/{email}', 'WelcomeController@send');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');
Route::get('/request-confirmed', 'WelcomeController@request')->name('request.confirmed');


Route::get('/search', 'SearchController@getSearch')->name('search');
Route::post('/suscriber', 'WelcomeController@addSuscriber')->name('suscriber');

Route::get('/shop', 'ProductController@getShop')->name('shop');

Route::get('/brand', 'NavController@brand')->name('brand');
Route::get('/best_selling', 'NavController@best_selling')->name('best.selling');
Route::get('/flash_deals', 'NavController@flash_deals')->name('flash.deals');
Route::get('/tech_discovery', 'NavController@tech_discovery')->name('tech_discovery');
Route::get('/trending_style', 'NavController@trending_style')->name('treding.style');


Route::get('/product/{slug}', 'ProductController@getProduct')->name('product.show');
Route::get('/product2/{id}', 'ProductController@getProduct2');

Route::get('/product-quick-view', 'ProductController@getQuickView')->name('product.quick.view');

Route::get('/brands', 'BrandController@index')->name('brands');

Route::get('/blog', 'BlogController@index')->name('blog');
Route::get('/blog/{slug}', 'BlogController@show')->name('post.show');

Route::get('/category/{slug}', 'CategoryController@index')->name('category');

Route::post('contact-us', 'ContactController@postContact')->name('contact-us');
Route::get('contact-us', 'ContactController@contact')->name('request-new-product');
Route::post('contact-us-add', 'ContactController@contactAdd')->name('contact.post');

Route::post('request-us-add', 'ContactController@NewRequestAdd')->name('request-product.post');

Route::get('/cart', 'CartController@index')->name('cart.index');
Route::get('/mini-cart', 'CartController@getMiniCart')->name('cart.mini');
Route::post('/cart', 'CartController@store')->name('cart.store');
Route::post('/cart/update', 'CartController@update')->name('cart.update');
Route::post('/cart/destroy/{rowId}', 'CartController@destroyRow')->name('cart.destroy.row');
Route::post('/cart/destroy', 'CartController@destroy')->name('cart.destroy');

Route::post('/wishlist', 'WishlistController@store')->name('wishlist.store');

Route::get('/compare', 'CompareController@getCompare')->name('compare');
Route::post('/compare', 'CompareController@postCompare')->name('compare.store');
Route::get('/mini-comparelist', 'CompareController@getMiniCompareList')->name('comparelist.mini');
Route::post('/compare/clear/{product}', 'CompareController@clear')->name('compare.clear');
Route::post('/compare/clear', 'CompareController@clearAll')->name('compare.clearall');

Route::post('/enquiry-list', 'ProductEnquiryController@postEnquiryList')->name('enquiry.list.store');

//Route::group( [ 'middleware' => 'auth' ], function () {
Route::post('/review', 'ReviewController@storeReview')->name('review.store');

Route::post('/comment/{postId}', 'CommentController@storeComment')->name('comment.store');

Route::get('/enquiry', 'ProductEnquiryController@getEnquiry')->name('enquiry');
Route::post('/enquiry-list/update', 'ProductEnquiryController@updateEnquiry')->name('enquiry.row.update');
Route::post('/enquiry-list/delete', 'ProductEnquiryController@deleteEnquiry')->name('enquiry.row.destroy');
Route::post('/enquiry', 'ProductEnquiryController@handleEnquiry')->name('enquiry.store');
Route::get('/enquiry/enquiry-received', 'ProductEnquiryController@handleEnquiryStatus')->name('enquiry.enquiry-status');
Route::get('contact_us', 'ContactController@testimional')->name('testimional.add');


Route::get('/checkout', 'CheckoutController@getCheckout')->name('checkout');
Route::post('/checkout', 'CheckoutController@handleCheckout')->name('checkout.store');
Route::get('/checkout/order-received', 'CheckoutController@handleOrderStatus')->name('checkout.order-status');

Route::get('/my-account', 'AccountController@index')->name('my-account');
Route::get('/my-account/edit-account', 'AccountController@editAccount')->name('my-account.edit-account');
Route::post('/my-account/edit-account/{id}', 'AccountController@updateAccount')->name('my-account.update-account');
Route::get('/my-account/change-password', 'AccountController@editPassword')->name('my-account.change-password');
Route::post('/my-account/change-password', 'AccountController@updatePassword')->name('my-account.update-password');

Route::get('/my-account/enquiries', 'AccountController@getProductEnquiries')->name('my-account.enquiries');
Route::post('/my-account/enquiries/order', 'AccountController@postProductEnquiryOrder')->name('my-account.enquiries.order');
Route::post('/my-account/enquiries/order', 'AccountController@deleteProductEnquiryOrder')->name('my-account.enquiries.cancel');

Route::get('/my-account/orders', 'AccountController@getOrders')->name('my-account.orders');
Route::get('/my-account/order/cancel/{id}', 'AccountController@cancelOrder')->name('my-account.order.cancel');
Route::get('/my-account/order/view/{id}', 'AccountController@viewOrder')->name('my-account.order.view');

Route::get('/my-account/wishlist', 'WishlistController@index')->name('my-account.wishlist');
Route::delete('/my-account/wishlist/{productId}', 'WishlistController@destroy')->name('my-account.wishlist.destroy');

Route::get('/my-account/edit-address', 'AccountController@editAddress')->name('my-account.edit-address');
Route::get('/my-account/edit-address/shipping', 'AccountController@editShippingAddress')->name('my-account.edit-address.shipping');
Route::post('/my-account/edit-address/shipping', 'AccountController@updateShippingAddress')->name('my-account.update-address.shipping');

Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
    'namespace' => 'Backend',
    'middleware' => 'role:admin|manager|shop-manager'
], function () {

    Route::get('/', 'DashboardController@index')->name('index');
    Route::resource('/product', 'ProductController', ['except' => ['show']]);
    Route::get('/products/json', 'ProductController@getProductsJson')->name('products.json');
    Route::get('/search-product', 'ProductController@searchProduct')->name('search.product');
    Route::get('/categories/json', 'CategoryController@getCategoriesJson')->name('categories.json');


    Route::get('/order/add-product', 'OrderController@addProduct')->name('order.add.product');
    Route::get('/order/update-product', 'OrderController@updateProduct')->name('order.update-product');
    Route::get('/order/update-product-summary', 'OrderController@updateProductSummary')->name('order.update-product-summary');
    Route::get('/order/update-user-address', 'OrderController@updateUserAddress')->name('order.update-user-address');
    Route::get('/order/{order}/invoice', 'OrderController@generateInvoice')->name('order.invoice');
    Route::resource('order', 'OrderController', ['except' => ['show']]);

    Route::get('/orders/json', 'OrderController@getOrdersJson')->name('orders.json');

    Route::resource('enquiries', 'ProductEnquiryController', ['except' => ['create', 'show']]);
    Route::get('/get-enquiries', 'ProductEnquiryController@getEnquiriesJson')->name('enquiries.json');


    Route::get('/request', 'RequestController@index')->name('request.index');
    Route::delete('/request/{id}', 'RequestController@destroy')->name('request.destroy');
    Route::get('/get-request', 'RequestController@getReviewsJson')->name('request.json');
    Route::get('/message', 'MessageController@index')->name('message.index');
    Route::delete('/message/{id}', 'MessageController@destroy')->name('message.destroy');
    Route::get('/get-message', 'MessageController@getReviewsJson')->name('message.json');


});
Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
    'namespace' => 'Backend',
    'middleware' => 'role:admin|manager'
], function () {


    Route::resource('/categories', 'CategoryController', ['except' => ['show']]);


    Route::post('/product/image/upload', 'ProductController@uploadImage')->name('product.image.upload-image');
    Route::post('/product/image/delete', 'ProductController@deleteImage')->name('product.image.delete-image');
    Route::post('/product/faq/delete', 'ProductController@deleteFaq')->name('product.faq.delete');
    Route::post('/product/specification/delete', 'ProductController@deleteSpecification')->name('product.specification.delete');
    Route::post('/product/download/delete', 'ProductController@deleteDownload')->name('product.download.delete');
    Route::post('/product/download/file/upload', 'ProductController@downloadFileUpload')->name('product.download.file.upload');

    Route::resource('category', 'CategoryController', ['except' => ['create', 'show']]);


    Route::resource('brands', 'BrandController', ['except' => ['show']]);
    Route::get('/get-brands', 'BrandController@getBrandsJson')->name('brands.json');


    Route::resource('testimonials', 'TestimonialController', ['except' => ['show']]);
    Route::get('/get-testimonials', 'TestimonialController@getTestimonialsJson')->name('testimonials.json');


    Route::get('/review', 'ReviewController@index')->name('review.index');
    Route::delete('/review/{id}', 'ReviewController@destroy')->name('review.destroy');
    Route::post('/review/status/{id}', 'ReviewController@updateStatus')->name('review.status');
    Route::get('/get-reviews', 'ReviewController@getReviewsJson')->name('reviews.json');


    Route::post('/mail', 'MailController@sendMail')->name('mail');


});

Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
    'namespace' => 'Backend',
    'middleware' => ['auth', 'role:admin']
], function () {
    Route::get('/profile', 'ProfileController@getProfile')->name('profile');

    Route::post('/profile', 'ProfileController@postProfile')->name('profile.update');
    Route::resource('slideshows', 'SlideshowController', ['except' => ['show']]);
    Route::get('/get-slideshows', 'SlideshowController@getSlideshowsJson')->name('slideshows.json');

    Route::post('/background', 'BackgroundController@save')->name('background.save');
    Route::get('/search-user', 'UserController@searchUser')->name('search.user');

    Route::resource('page', 'PageController', ['except' => ['show']]);
    Route::get('/get-pages', 'PageController@getPagesJson')->name('pages.json');
    Route::resource('/posts', 'PostController', ['except' => ['show']]);
    Route::get('/get-posts', 'PostController@getPostsJson')->name('posts.json');

    Route::get('/menus', 'MenuController@index')->name('menus.show');
    Route::post('harimayco/addmenu', 'MenuController@addmenu')->name('haddmenu');
    Route::get('/settings', 'ConfigurationController@getConfiguration')->name('settings');
    Route::post('/settings', 'ConfigurationController@postConfiguration')->name('settings.update');
    Route::get('/suscriber', 'RequestController@getSuscriber')->name('suscriber');

    Route::delete('/suscriber/{id}', 'RequestController@suscriberdestroy')->name('suscriber.destroy');

    Route::get('/users/admin', 'UserController@getAdminUsersJson')->name('users.admin.json');
    Route::get('/users/manager', 'UserController@getManagerUsersJson')->name('users.manager.json');
    Route::get('/users/client', 'UserController@getClientUsersJson')->name('users.client.json');
    Route::get('/users/shop-manager', 'UserController@getShopManagerUsersJson')->name('users.shop-manager.json');

    Route::resource('users', 'UserController');
    Route::get('/get-users', 'UserController@getUsersJson')->name('users.json');

    Route::resource('team', 'TeamController', ['except' => ['show']]);
    Route::get('/get-team', 'TeamController@getTeamJson')->name('team.json');

    Route::resource('about', 'AboutController', ['except' => ['show']]);

    Route::get('/get-about', 'AboutController@getReviewsJson')->name('about.json');
    Route::get('/get-suscriber', 'RequestController@getSuscriberJson')->name('suscriber.json');

});
Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
    'namespace' => 'Backend',
    'middleware' => 'role:shop-manager'
], function () {


});
//} );

Route::get('storage/{folder}/{filename}', function ($folder, $filename) {
    $path = storage_path('app/public/' . $folder . '/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

// Catch all PageController (place at the very bottom)
Route::get('{slug}', ['uses' => 'PageController@getPage'])->where('slug', '([A-Za-z0-9\-\/]+)');