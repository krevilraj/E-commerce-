<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Requests\CheckoutRequest;
use App\Product;
use App\Repositories\Order\OrderRepository;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Mail;
use App\Mail\Order;
use App\Mail\User;
use App\Mail\OrderSent;


class CheckoutController extends Controller
{

    /**
     * @var OrderRepository
     */
    private $order;

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    public function getCheckout()
    {
        $user = Auth::user();
        $address = getUserAddress($user);
        $countries = Country::pluck('name', 'id')->toArray();
        $states = array('' => 'Select a state') + State::pluck('name', 'id')->toArray();

        return view('checkout.index', compact('address', 'countries', 'states'));
    }

    public function handleCheckout(CheckoutRequest $request)
    {
       

        $cartContents = Cart::content();

        foreach ($cartContents as $cartContent) {
            $inStock = Product::where('id', $cartContent->id)->first();
           if( $inStock->in_stock == 0 ){
               session()->flash( 'enquiry', 'Enquiry Received' );

               return view( 'cart.index' );
           }



        }


        try {

            $order = $this->order->createFrontendOrder($request->all());
           

            

        } catch (\Exception $e) {

            throw new \Exception('Error in saving order: ' . $e->getMessage());
        }
$data = [

                'name'=>$request->first_name. '  '.$request->last_name,
                'products'=>$cartContents,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'city'=>$request->city,
                'address1'=>$request->address1,
                'address2'=>$request->address2,



            ];
          $data2 = [
              'name'=>$request->first_name. '  '.$request->last_name,
              'products'=>$cartContents,
              'subject'=>'Order Received'

            ];
            Mail::to(getConfiguration('order_email'))->send(new Order($data));

            Mail::to($request->email)->send(new OrderSent($data2));

        session()->flash('order', $order);

        return redirect('/checkout/order-received');

    }

    public function handleOrderStatus()
    {
        if (session('order')) {
            $title = 'Order Received';
        } else {
            $title = 'Order';
        }

        return view('checkout.order-status', compact('title'));
    }
}
