<?php

use App\Category;
use App\Configuration;
use App\Helpers\Image\LocalImageFile;
use App\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

function getProductSlug( $id ) {
	$product = Product::findOrFail( $id );

	return isset( $product->slug ) ? $product->slug : Str::slug( $product->name );
}

function getProductImage( $id, $size = null ) {
	$product = DB::table( 'products' )
	             ->leftJoin( 'product_images', 'products.id', '=', 'product_images.product_id' )
	             ->where( 'product_images.is_main_image', '=', 1 )
	             ->where( 'products.id', '=', $id )
	             ->select( 'product_images.path' )
	             ->first();

	if ( null === $product || empty( $product ) ) {
		$defaultPath = "/img/default-product.jpg";
		$localImage  = new LocalImageFile( $defaultPath );
	} else {
		$localImage = new LocalImageFile( $product->path );
	}

	switch ( $size ) {
		case "small":
			$imageUrl = $localImage->smallUrl;
			break;
		case "medium":
			$imageUrl = $localImage->mediumUrl;
			break;
		case "large":
			$imageUrl = $localImage->largeUrl;
			break;
		case "full":
			$imageUrl = $localImage->url;
			break;
		default:
			$imageUrl = $localImage->mediumUrl;
	}

	return $imageUrl;
}

function getUserAddress( $user ) {
	return $user->addresses->first->toArray();
}

function isValidTimestamp( $timestamp ) {
	if ( preg_match( "/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $timestamp, $matches ) ) {
		if ( checkdate( $matches[2], $matches[3], $matches[1] ) ) {
			return true;
		}
	}

	return false;
}

function humanizeDate( Carbon $date ) {
	return $date->diffForHumans();
}

function excerpt( $content, $length = 30 ) {
	return strip_tags( Str::words( $content, $length ) );
}

function getOrderStatusClass( $status ) {
	switch ( $status ) {
		case 'Pending':
			$statusClass = "warning";
			break;
		case 'Delivered':
			$statusClass = "success";
			break;
		case 'Received':
			$statusClass = "info";
			break;
		case 'Canceled':
			$statusClass = "danger";
			break;
		default:
			$statusClass = "info";
	}

	return $statusClass;
}

function categorySeperator( $string = '', $size ) {
	for ( $i = 2; $i < $size; $i ++ ) {
		$string .= $string;
	}

	return $string;
}

function getConfiguration( $key ) {
	$config = Configuration::where( 'configuration_key', '=', $key )->first();
	if ( $config != null ) {
		return $config->configuration_value;
	}

	return null;
}

function getProductsByCategory( $category ) {
	switch ( $category ) {
		case 'Latest':
			$products = Product::orderby( 'id', 'DESC' )->take( 10 )->get();
			break;
		case 'Featured':
			$products = Product::where( 'is_featured', 1 )->orderby( 'id', 'DESC' )->take( 10 )->get();
			break;
		default:
			$category = Category::where( 'name', 'like', '%' . $category . '%' )->firstOrFail();
			$products = $category->products->take(10);
	}

	return $products;
}