<?php

    namespace App\Http\Controllers\Backend;

    use App\Country;
    use App\OrderStatus;
    use App\Product;
    use App\Repositories\Order\OrderRepository;
    use App\State;
    //use PDF;
    use Exception;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;
    use Mail;

    class OrderController extends Controller {
        /**
         * @var OrderRepository
         */
        private $order;

        public function __construct( OrderRepository $order ) {
            $this->order = $order;
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            $ordersCount = $this->order->getAll()->count();
if($ordersCount==0){
    
                return view( 'backend.orders.index2', compact( 'ordersCount' ) );

}
else

            return view( 'backend.orders.index', compact( 'ordersCount' ) );
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create() {
            $orderStatuses = array( '' => 'Select Order Status' ) + OrderStatus::pluck( 'name', 'id' )->toArray();
            //$countries = array( '' => 'Select a country' ) + Country::pluck( 'name', 'id' )->toArray();
            $countries = Country::pluck( 'name', 'id' )->toArray();
            $states    = array( '' => 'Select a state' ) + State::pluck( 'name', 'id' )->toArray();

            return view( 'backend.orders.create', compact( 'orderStatuses', 'countries', 'states' ) );
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\Response
         * @throws Exception
         */
        public function store( Request $request ) {
            $request->validate( [
                'order_status' => 'required',
                'first_name'   => 'required|max:255',
                'last_name'    => 'required|max:255',
                'state'        => 'required',
                'products'     => 'required|array',
            ] );

            try {

                $this->order->create( $request->all() );
 


            } catch ( Exception $e ) {

                throw new Exception( 'Error in saving order: ' . $e->getMessage() );
            }

            return response()->json( [
                'success' => true,
                'message' => 'Order successfully created!'
            ] );
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show( $id ) {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function edit( $id ) {
            $order    = $this->order->getById( $id );
            $products = $this->getOrderedProducts( $id );

            $userDetails = DB::table( 'orders' )
                             ->leftJoin( 'users', 'orders.user_id', '=', 'users.id' )
                             ->leftJoin( 'addresses', 'orders.billing_address_id', '=', 'addresses.id' )
                             ->where( 'orders.id', '=', $order->id )
                             ->select( 'users.id as user_id', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'addresses.*' )
                             ->first();


            $orderStatuses = array( '' => 'Select Order Status' ) + OrderStatus::pluck( 'name', 'id' )->toArray();
            $countries     = Country::pluck( 'name', 'id' )->toArray();
            $states        = array( '' => 'Select a state' ) + State::pluck( 'name', 'id' )->toArray();

            return view( 'backend.orders.edit', compact( 'order', 'products', 'userDetails', 'orderStatuses', 'countries', 'states' ) );
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         * @throws Exception
         */
        public function update( Request $request, $id ) {
  $request->validate( [
                'order_status' => 'required',
                'first_name'   => 'required|max:255',
                'last_name'    => 'required|max:255',
                'state'        => 'required',
                'products'     => 'required|array',
            ] );


 $status=$request->order_status;
                switch ($status)
                {
                       case '5':
                $value="Canceled";
                    break;
                    case '4':
                        $value="Received";
                        break;
                        
                    break;  case '3':
                    $value="Delivered";
                    break; 
                    case '2':
                    $value="Approved";
                    break;
                    case '1':
                        $value="Pending";
                        break;
 default :"";
               
                    
}
$data2 = [
    'name'=>$request['first_name'].$request['last_name'],
                    'value'=>$value,
                    'id'=>$id,

                ];
$data = [

                'id'=>$id,
             'value'=>$value



                ];



          


            try {


                Mail::to(getConfiguration('order_email'))->send(new  \App\Mail\OrderUpdated($data));


                Mail::to($request->email)->send(new \App\Mail\UserOrderUpdate($data2));

                
                 $this->order->update( $id, $request->all() );






            } catch ( Exception $e ) {

                throw new Exception( 'Error in updating order: ' . $e->getMessage() );
            }

            return response()->json( [
                'success' => true,
                'message' => 'Order successfully updated!'
            ] );

           
        }


        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy( $id ) {
            try {

                $this->order->delete( $id );

            } catch ( Exception $e ) {

                throw new Exception( 'Error in deleting order: ' . $e->getMessage() );
            }

            return redirect()->back()->with( 'success', 'Order successfully deleted!' );
        }

        public function addProduct( Request $request ) {
            $productsId = explode( ',', $request->input( 'products' ) );

            $products = Product::whereIn( 'products.id', $productsId )->get();

            return view( 'backend.orders.products', compact( 'products' ) );

        }

        public function updateProduct( Request $request ) {

            $product = Product::findOrFail( $request->input( 'product' ) );

            $quantity = $request->input( 'quantity' );
            $discount = $request->input( 'discount' );

            $price       = $product->getPrice();
            $actualPrice = (float) $price * $quantity;

            if ( $discount != 0 ) {
                $priceTotal = $actualPrice - ( $actualPrice * ( $discount / 100 ) );
            } else {
                $priceTotal = $actualPrice;
            }

            $product->price       = $price;
            $product->price_total = $priceTotal;
            $product->quantity    = $quantity;
            $product->discount    = $discount;

            return view( 'backend.orders.update-product', compact( 'product' ) );
        }

        public function updateProductSummary( Request $request ) {

            $priceTotal     = (float) 0.00;

            if ( $request->has( 'products' ) ) {
                foreach ( $request->input( 'products' ) as $product ) {
                    $actualPrice = $product['price'] * $product['quantity'];;

                    $discountAmount = $actualPrice * ( $product['discount'] / 100 );
                    $priceTotal     += $actualPrice - $discountAmount;
                }

            }

            if ($request->has('order')) {
                $order = $this->order->getById( $request->input('order') );
                $tax = 0;

                if ($order->enable_tax)
                    $tax = ($priceTotal * $order->tax_percentage) / 100;

                $priceTotal += $tax;

                return view( 'backend.orders.order-summary', compact( 'order', 'priceTotal' ) );
            }

            return view( 'backend.orders.order-summary', compact( 'priceTotal' ) );
        }

        public function updateUserAddress( Request $request ) {
            $address   = DB::table( 'addresses' )
                           ->where( 'user_id', '=', $request->input( 'user' ) )
                           ->whereNotNull( 'user_id' )
                           ->first();
            $countries = Country::pluck( 'name', 'id' )->toArray();
            $states    = array( '' => 'Select a state' ) + State::pluck( 'name', 'id' )->toArray();

            return view( 'backend.orders.update-address', compact( 'address', 'countries', 'states' ) );
        }

        /**
         * @param $id
         *
         * @return array
         */
        public function getOrderedProducts( $id ) {
            $order = $this->order->getById( $id );

            foreach ( $products = $order->products as $product ) {
                $quantity = $product->pivot->qty;
                $discount = $product->pivot->discount;

                $price       = $product->getPrice();
                $actualPrice = $price * $quantity;

                $productPriceTotal = $actualPrice - ( $actualPrice * ( $discount / 100 ) );

                $product->price           = $price;
                $product->quantity        = $quantity;
                $product->discount        = $discount;
                $product->discount_amount = $actualPrice * ( $discount / 100 );
                $product->tax_amount      = $product->pivot->tax_amount;
                $product->price_total     = $productPriceTotal;
            }

            return $products;
        }

        /**
         * Generate Invoice
         *
         * @param $id
         *
         * @return \Illuminate\Http\Response
         */
        public function generateInvoice( $id ) {
            $order = $this->order->getById( $id );

            $userDetails = DB::table( 'orders' )
                             ->leftJoin( 'users', 'orders.user_id', '=', 'users.id' )
                             ->leftJoin( 'addresses', 'orders.shipping_address_id', '=', 'addresses.id' )
                             ->where( 'orders.id', '=', $order->id )
                             ->select( 'users.id as user_id', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'addresses.*' )
                             ->first();

            $state = State::where('id', '=', $userDetails->state_id)->select('name')->first();

            return view( 'backend.orders.invoice', compact( 'order', 'userDetails', 'state' ) );
        }

        /**
         * @param Request $request
         *
         * @return mixed
         */
        public function getOrdersJson( Request $request ) {
            $orders = $this->order->getAll();

            if ( null === $orders ) {
                return datatables( $orders )->toJson();
            }

            $ordersArray = [];

            foreach ( $orders as $orderKey => $orderValue ) {
                $ordersArray[ $orderKey ]['id']           = $orderValue->id;
                $ordersArray[ $orderKey ]['order_note']   = $orderValue->order_note;
                $ordersArray[ $orderKey ]['order_status'] = $orderValue->orderStatus->name;
                $ordersArray[ $orderKey ]['order_date']   = $orderValue->order_date;

                $ordersArray[ $orderKey ]['userOrder'] = [
                    'order_id'        => $orderValue->id,
                    'user_id'         => $orderValue->user_id,
                    'user_first_name' => isset( $orderValue->user->first_name ) ? $orderValue->user->first_name : '',
                    'user_last_name'  => isset( $orderValue->user->last_name ) ? $orderValue->user->last_name : '',
                    'user_email'      => isset( $orderValue->user->email ) ? $orderValue->user->email : '',
                ];

                $ordersArray[ $orderKey ]['address'] = [
                    'address_first_name' => isset( $orderValue->shipping_address->first_name ) ? $orderValue->shipping_address->first_name : null,
                    'address_last_name'  => isset( $orderValue->shipping_address->last_name ) ? $orderValue->shipping_address->last_name : null,
                    'address_address1'   => isset( $orderValue->shipping_address->address1 ) ? $orderValue->shipping_address->address1 : null,
                    'address_address2'   => isset( $orderValue->shipping_address->address2 ) ? $orderValue->shipping_address->address2 : null,
                    'address_postcode'   => isset( $orderValue->shipping_address->postcode ) ? $orderValue->shipping_address->postcode : null,
                    'address_city'       => isset( $orderValue->shipping_address->city ) ? $orderValue->shipping_address->city : null,
                    'address_state'      => isset( $orderValue->shipping_address->state_id->name ) ? $orderValue->shipping_address->state_id->name : null,
                    'address_country_id' => isset( $orderValue->shipping_address->country_id ) ? $orderValue->shipping_address->country_id : null,
                    'address_email'      => isset( $orderValue->shipping_address->email ) ? $orderValue->shipping_address->email : null,
                    'address_phone'      => isset( $orderValue->shipping_address->phone ) ? $orderValue->shipping_address->phone : null,
                ];

                $priceTotal = 0;

                foreach ( $orderValue->products as $productKey => $productValue ) {
                    $ordersArray[ $orderKey ]['products'][ $productKey ] = [
                        'product_name' => $productValue->name,
                        'product_id'   => $productValue->pivot->product_id,
                        'order_id'     => $productValue->pivot->order_id,
                        'qty'          => $productValue->pivot->qty,
                        'price'        => $productValue->pivot->price,
                        'discount'     => $productValue->pivot->discount,
                        'tax_amount'   => $productValue->pivot->tax_amount,
                    ];

                    $priceTotal += $productValue->pivot->qty * $productValue->pivot->price;
                    $dis=0;
                $dis=$priceTotal *($productValue->pivot->discount) / 100;
                $priceTotal -= $dis;
                }
                

                $tax = 0;
                if ($orderValue->enable_tax) {
                    $tax = ($priceTotal * $orderValue->tax_percentage) / 100;
                }

                $priceTotal += $tax;

                $ordersArray[ $orderKey ]['price_total'] = number_format($priceTotal, 2);



            }

            return datatables( $ordersArray )->toJson();

        }
    }
