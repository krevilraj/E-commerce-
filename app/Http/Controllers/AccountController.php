<?php

namespace App\Http\Controllers;

use App\Address;
use App\Country;
use App\Helpers\Image\ImageService;
use App\Helpers\Image\LocalImageFile;
use App\Helpers\PaginationHelper;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserAccountRequest;
use App\Mail\EnquiryOrdered;
use App\Media;
use App\Order;
use App\OrderStatus;
use App\Product;
use App\ProductEnquiry;
use App\Repositories\Order\OrderRepository;
use App\State;
use App\Wishlist;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Mail;
use App\User;
class AccountController extends Controller {
	use PaginationHelper;

	/**
	 * @var OrderRepository
	 */
	private $order;

	public function __construct( OrderRepository $order ) {
		$this->order = $order;
	}

	public function index() {
		$shippingAddress = Address::where( 'user_id', auth()->id() )->where( 'type', 'SHIPPING' )->first();

		return view( 'my-account.index', compact('shippingAddress') );
	}

	public function getOrders() {
		$user   = auth()->id();
		$orders = $this->paginateHelper( $this->order->getUserOrders( $user ), 10 );

		return view( 'my-account.orders', compact( 'orders' ) );
	}

	public function cancelOrder( $id ) {
		$order = $this->order->getById( $id );

		$order->update( [ 'order_status_id' => 5 ] );
//
        $pid=DB::table('order_product')->where('order_id',$id)->get();
    foreach($pid as $pid){
        $product=Product::where('id',$pid->product_id)->first();

        $product->stock_qty=(int)( $product->stock_qty) + (int)($pid->qty);
       $product->update();
     }
        return redirect()->back()->with( 'success', 'Order successfully cancelled!' );
	}

	public function viewOrder( $id ) {
		$order = $this->order->getById( $id );

		return view( 'my-account.view-order' )->with( 'order', $order );
	}

	public function getProductEnquiries() {
		$user             = auth()->id();
		$productEnquiries = ProductEnquiry::where( 'user_id', '=', $user )->orderBy( 'id', 'DESC' )->get();


		return view( 'my-account.enquiries' )
			->with( [ 'productEnquiries' => $this->paginateHelper( $productEnquiries, 10 ) ] );

	}
    public function deleteProductEnquiryOrder( Request $request )
    {
        $enquiryId = $request->input( 'enquiry_id' );
        $enq=ProductEnquiry::where('id',$enquiryId)->first();

        $product=Product::where('id',$enq->product_id)->first();

        $product->stock_qty=(int)( $enq->quantity) + (int)($product->stock_qty);
        $product->update();
$enq=ProductEnquiry::where('id',$enquiryId)->first();
 $enq->delete();

return redirect()->back();

    }

        public function postProductEnquiryOrder( Request $request ) {
		$enquiryId = $request->input( 'enquiry_id' );
		$productId = $request->input( 'product_id' );

		// Update product enquiry
		$enquiry          = ProductEnquiry::findOrFail( $enquiryId );
		$enquiry->ordered = true;
		$enquiry->save();

		$address     = Address::where( 'user_id', '=', auth()->id() )->first();
		$orderStatus = OrderStatus::whereIsDefault( 1 )->first();

		// Create new order
		$order = Order::create( [
			'billing_address_id'  => $address->id,
			'shipping_address_id' => $address->id,
			'user_id'             => auth()->id(),
			'order_status_id'     => $orderStatus->id,
			'order_note'          => $enquiry->enquiry_note,
			'order_date'          => Carbon::now()->toDateTimeString(),
		] );
        $pid=DB::table('product_enquiries')->where('id',$enquiryId)->first();

        $product=Product::where('id',$pid->product_id)->first();

    
		$order->products()->attach( $productId,

			[
				'qty'      => $pid->quantity,
				'price'    => $enquiry->product->getPrice(),
				'discount' => $enquiry->discount
			]
		);
        $pid=$enquiry->product_id;
        $product_name=Product::findOrFail($pid);
        $user=User::findOrFail($enquiry->user_id);

        $data = [

            'name'=>$user->first_name,
            'qty'=>$enquiry->quantity,
            'products'=>$product_name->name,
            'email'=>$address->email,
            'phone'=>$address->phone,
            'city'=>$address->city,
            'address1'=>$address->address1,
            'address2'=>$address->address2,



        ];
        $data2 = [
            'name'=>$user->first_name,
            'msg'=>'You Have Sucessfully Placed An Order',
            'link'=>URL::to('/').'/my-account/orders',
            'button-name'=>'Check Order',

        ];

        Mail::to(getConfiguration('order_email'))->send(new EnquiryOrdered($data));

        Mail::to($request->email)->send(new \App\Mail\User($data2));


		return redirect( 'my-account/orders' )->with( 'success', 'Your order has been received.' );

	}

	public function getWishlist( Wishlist $wishlist ) {
		dd( $wishlist->all() );
	}

	public function editAddress() {
		$shippingAddress = Address::where( 'user_id', auth()->id() )->where( 'type', 'SHIPPING' )->first();

		return view( 'my-account.edit-address', compact( 'shippingAddress' ) );
	}

	public function editShippingAddress() {
		$address   = Address::where( 'user_id', auth()->id() )->where( 'type', 'SHIPPING' )->first();
		$countries = array( '' => 'Select a state' ) + Country::pluck( 'name', 'id' )->toArray();
		$states    = array( '' => 'Select a state' ) + State::pluck( 'name', 'id' )->toArray();

		return view( 'my-account.edit-shipping-address', compact( 'address', 'countries', 'states' ) );
	}

	public function updateShippingAddress( AddressRequest $request ) {
		$request['state_id'] = $request->input( 'state' );

		Address::updateOrCreate( [ 'user_id' => auth()->id() ], $request->all() );

		return redirect()->back()->with( 'success', 'Address successfully updated!' );
	}

	public function editAccount() {
		$user = Auth::user();

		return view( 'my-account.edit-account', compact( 'user' ) );
	}

	/**
	 * @param UserAccountRequest $request
	 * @param $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function updateAccount( UserAccountRequest $request, $id ) {
		if ( $id != auth()->id() ) {
			return redirect()->back()->with( 'error', 'Something went wrong!!' );
		}

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

		return redirect()->back()->with( 'success', 'Account successfully updated!' );
	}

	public function deleteImage( $path ) {
		if ( null === $path ) {
			return false;
		}

		$localImageFile = new LocalImageFile( $path );
		$localImageFile->destroy();

		return true;
	}

	public function editPassword() {
		return view( 'my-account.edit-password' );
	}

	/**
	 * @param ChangePasswordRequest $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function updatePassword( ChangePasswordRequest $request ) {
		$user = Auth::user();

		if ( Hash::check( $request->input( 'current_password' ), $user->password ) ) {
			$user->update( [ 'password' => bcrypt( $request->input( 'password' ) ) ] );

			return redirect()->back()->with( 'success', 'Password successfully changed!' );
		} else {
			return redirect()->back()->withErrors( [ 'current_password' => 'Your current password is wrong!' ] );
		}
	}
}
