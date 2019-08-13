<?php

namespace App\Http\Controllers\Backend;

use App\Order;
use App\Product;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {
	public function index() {
		$ordersCount   = Order::count();
		$productsCount = Product::count();
		$usersCount    = User::count();
		$reviewsCount  = Review::count();

		$latestOrders   = Order::latest()->take( 5 )->get();
		$recentProducts = Product::latest()->take( 5 )->get();
		$lessQtyProducts = Product::where('stock_qty', '<', 5)->take( 5 )->get();

		return view( 'backend.index', compact( 'ordersCount', 'productsCount', 'usersCount', 'reviewsCount', 'latestOrders', 'recentProducts', 'lessQtyProducts' ) );
	}
}
