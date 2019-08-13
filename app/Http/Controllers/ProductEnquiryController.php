<?php

namespace App\Http\Controllers;

use App\Address;
use App\Country;
use App\Http\Requests\CheckoutRequest;
use App\Mail\EnquiryMail;
use App\Mail\User;
use App\Product;
use App\Repositories\Product\ProductRepository;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\ProductEnquiry;
use App\State;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Mail;

class ProductEnquiryController extends Controller {
	/**
	 * @var ProductRepository
	 */
	private $product;

	public function __construct( ProductRepository $product ) {
		$this->product = $product;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getEnquiry() {
		$user      = Auth::user();
		$address   = getUserAddress( $user );
		$countries = Country::pluck( 'name', 'id' )->toArray();
		$states    = array( '' => 'Select a state' ) + State::pluck( 'name', 'id' )->toArray();

		return view( 'enquiry.index', compact( 'address', 'countries', 'states', 'product' ) );
	}

	public function postEnquiryList( Request $request ) {
if ( auth()->guest() ) {
			return response()->json( [
           'timer'=>15000,

				'status'  => 'error',
				'message' => 'Please login to add this product in your Cart!!',

			], 401 );
		}
		$productId = $request->input( 'product' );
		$product   = $this->product->getById( $productId );

		$cartList = Cart::instance( 'enquiry' )->add(
			[
				'id'    => $product->id,
				'name'  => $product->name,
				'qty'   => 1,
				'price' => $product->getPrice()
			]
		);

		if ( ! $request->ajax() ) {
			return redirect()->back()->with( 'success', 'Product added to enquiry list!!' );
		}

		return response()->json( [
			'status'  => 'success',
			'message' => 'Product added to enquiry list!!'
		], 200 );
	}

	public function updateEnquiry( Request $request ) {
		foreach ( $request->input( 'enquiryContents' ) as $enquiryContent ) {
			$rowId    = $enquiryContent['rowId'];
			$quantity = $enquiryContent['quantity'];

			// Update the quantity
			Cart::instance( 'enquiry' )->update( $rowId, $quantity );
		}

		return response()->json( [
			'status'  => 'success',
			'message' => 'Enquiry list updated!!'
		], 200 );
	}

	public function deleteEnquiry( Request $request ) {
		Cart::instance( 'enquiry' )->remove( $request->input( 'rowId' ) );

		if ( ! request()->ajax() ) {
			return redirect()->back()->with( 'success', 'Product removed from enquiry list!!' );
		}

		return response()->json( [
			'status'  => 'success',
			'message' => 'Product removed from enquiry list!!'
		], 200 );
	}

	public function handleEnquiry( CheckoutRequest $request ) {
        $enquiryList = Cart::instance( 'enquiry' )->content();

        foreach ( $enquiryList as $enquiry ) {

            $inStock = Product::where('id', $enquiry->id)->first();
            if($inStock->in_stock == 0 ){
            session()->flash( 'enquiry', 'Enquiry Received' );
                return redirect()->back();
            }



        }
            try {
			$addressData = [
				'type'       => 'SHIPPING',
				'user_id'    => auth()->id(),
				'first_name' => $request->input( 'first_name' ),
				'last_name'  => $request->input( 'last_name' ),
				'email'      => $request->input( 'email' ),
				'phone'      => $request->input( 'phone' ),
				'address1'   => $request->input( 'address1' ),
				'address2'   => $request->input( 'address2' ),
				'country_id' => $request->has( 'country' ) ? $request->input( 'country' ) : 1,
				'state_id'   => $request->input( 'state' ),
				'city'       => $request->input( 'city' ),
				'postcode'   => $request->input( 'postcode' ),
			];

			// Update or create address
			Address::updateOrCreate( [ 'user_id' => auth()->id() ], $addressData );

			// Create new enquiry
			$enquiryList = Cart::instance( 'enquiry' )->content();

			foreach ( $enquiryList as $enquiry ) {

				ProductEnquiry::create( [
					'user_id'      => auth()->id(),
					'product_id'   => $enquiry->id,
					'quantity'   => $enquiry->qty,
					'enquiry_note' => $request->input( 'enquiry_note' )
				] );
  $inStock = Product::where('id',  $enquiry->id)->first();
                $inStock->stock_qty=(int)( $inStock->stock_qty) - (int)($enquiry->qty);
                $inStock->update();
			}
                $data = [

                    'name'=>$request->first_name. '  '.$request->last_name,
                    'products'=>$enquiryList,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'city'=>$request->city,
                    'address1'=>$request->address1,
                    'address2'=>$request->address2,



                ];
                $data2 = [
                    'name'=>$request->first_name. '  '.$request->last_name,
                    'msg'=>'You Have Sucessfully Placed An Enquiry',
                    'link'=>URL::to('/').'/my-account/enquiries',
                    'button-name'=>'Check Enquiry',

                ];

                Mail::to(getConfiguration('order_email'))->send(new EnquiryMail($data));

                Mail::to($request->email)->send(new User($data2));

		} catch ( Exception $e ) {

			throw new Exception( 'Error in saving enquiry: ' . $e->getMessage() );
		}

		Cart::instance( 'enquiry' )->destroy();

		session()->flash( 'enquiry', 'Enquiry Received' );

		return redirect( '/enquiry/enquiry-received' );

	}

	public function handleEnquiryStatus() {
		return view( 'enquiry.enquiry-status', compact( 'title' ) );
	}
}
