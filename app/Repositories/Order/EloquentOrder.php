<?php

namespace App\Repositories\Order;

use App\Address;
use App\Order;
use App\OrderStatus;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use App\Product;
use Mail;


class EloquentOrder implements OrderRepository {

    /**
     * @var Order
     */
    private $model;

    public function __construct( Order $model ) {
        $this->model = $model;
    }

    public function getAll() {
        return $this->model->all()->sortByDesc("id");
    }

    public function getById( $id ) {
        return $this->model->findOrFail( $id );
    }

    public function create( array $attributes ) {
        if ( isset( $attributes['customer'] ) && $this->checkUserAddress( [ 'user_id' => $attributes['customer'] ] ) ) {
            $address = $this->UpdateUserAddress( [
                'user_id'    => $attributes['customer'],
                'type'       => 'SHIPPING',
                'first_name' => $attributes['first_name'],
                'last_name'  => $attributes['last_name'],
                'email'      => $attributes['email'],
                'phone'      => $attributes['phone'],
                'address1'   => $attributes['address1'],
                'address2'   => $attributes['address2'],
                'country_id' => isset( $attributes['country'] ) ? $attributes['country'] : 1,
                'state_id'   => $attributes['state'],
                'city'       => $attributes['city'],
                'postcode'   => $attributes['postcode'],
            ] );

            $attributes['user_id']             = $address->user_id;
            $attributes['billing_address_id']  = $address->id;
            $attributes['shipping_address_id'] = $address->id;
        } else {
            $address = $this->createUserAddress( [
                'type'       => 'SHIPPING',
                'first_name' => $attributes['first_name'],
                'last_name'  => $attributes['last_name'],
                'email'      => $attributes['email'],
                'phone'      => $attributes['phone'],
                'address1'   => $attributes['address1'],
                'address2'   => $attributes['address2'],
                'postcode'   => $attributes['postcode'],
                'city'       => $attributes['city'],
                'state_id'   => $attributes['state'],
                'country_id' => $attributes['country'],
            ] );

            $attributes['billing_address_id']  = $address->id;
            $attributes['shipping_address_id'] = $address->id;
        }

        $order = $this->model->create( [
            'billing_address_id'  => $attributes['billing_address_id'],
            'shipping_address_id' => $attributes['shipping_address_id'],
            'user_id'             => isset( $attributes['user_id'] ) ? $attributes['user_id'] : null,
            'enable_tax'      	  => $attributes['tax_percentage'] > 0 ? 1 : 0,
            'tax_percentage'      => $attributes['tax_percentage'],
            'order_status_id'     => $attributes['order_status'],
            'order_note'          => $attributes['order_note'],
            'order_date'          => $attributes['order_date'],
        ] );

        foreach ( $attributes['products'] as $orderProduct ) {
            DB::table( 'order_product' )->insert(
                [
                    'product_id' => $orderProduct['id'],
                    'order_id'   => $order->id,
                    'qty'        => $orderProduct['qty'],
                    'price'      => $orderProduct['price'],
                    'discount'   => $orderProduct['discount'],

                ]
            );
        }
        Cart::destroy();

        return $order;

    }

    public function update( $id, array $attributes ) {
        // Update address
        $addressDetails = [
            'type'       => 'SHIPPING',
            'first_name' => $attributes['first_name'],
            'last_name'  => $attributes['last_name'],
            'email'      => $attributes['email'],
            'phone'      => $attributes['phone'],
            'address1'   => $attributes['address1'],
            'address2'   => $attributes['address2'],
            'country_id' => isset( $attributes['country'] ) ? $attributes['country'] : 1,
            'state_id'   => $attributes['state'],
            'city'       => $attributes['city'],
            'postcode'   => $attributes['postcode'],
        ];

        if ( isset( $attributes['customer'] ) && $this->checkUserAddress( [ 'user_id' => $attributes['customer'] ] ) ) {
            $addressDetails['user_id'] = $attributes['customer'];
            $address                   = $this->UpdateUserAddress( $addressDetails );
        } elseif ( isset( $attributes['address_id'] ) && $this->checkUserAddress( [ 'address_id' => $attributes['address_id'] ] ) ) {
            $address = Address::findOrFail( $attributes['address_id'] );
            $address->update( $addressDetails );
        } else {
            $address = $this->createUserAddress( $addressDetails );
        }


        $attributes['user_id']             = $address->user_id;
        $attributes['billing_address_id']  = $address->id;
        $attributes['shipping_address_id'] = $address->id;

        // Update order
        $order = $this->getById( $id );

        $order->update( [
            'billing_address_id'  => $attributes['billing_address_id'],
            'shipping_address_id' => $attributes['shipping_address_id'],
            'user_id'             => isset( $attributes['user_id'] ) ? $attributes['user_id'] : null,
            'enable_tax'      	  => $attributes['tax_percentage'] > 0 ? 1 : 0,
            'tax_percentage'      => $attributes['tax_percentage'],
            'order_status_id'     => $attributes['order_status'],
            'order_note'          => $attributes['order_note'],
            'order_date'          => $attributes['order_date'],
        ] );
        if ($attributes['order_status'] == 2) {
            foreach ( $attributes['products'] as $orderProduct ) {
                $pid=$orderProduct['id'];
                $qty=$orderProduct['qty'];


                $product = Product::where('id', $pid)->first();

                $product->stock_qty =(int)($product->stock_qty) - (int)($qty);
                $product->update();

            }
        }
        if ($attributes['order_status'] == 5) {
            foreach ( $attributes['products'] as $orderProduct ) {
                $pid=$orderProduct['id'];
                $qty=$orderProduct['qty'];


                $product = Product::where('id', $pid)->first();

                $product->stock_qty =(int)($product->stock_qty) + (int)($qty);
                $product->update();

            }
        }


        $orderedProducts = [];

        foreach ( $attributes['products'] as $orderProduct ) {





            $orderedProducts[ $orderProduct['id'] ] = [
                'qty'      => $orderProduct['qty'],
                'price'    => $orderProduct['price'],
                'discount' => $orderProduct['discount']
            ];
        }

        $order->products()->sync( $orderedProducts );


        return $order;
    }

    public function delete( $id ) {
        $this->getById( $id )->delete();

        return true;
    }

    protected function checkUserAddress( array $id ) {
        if ( ! isset( $id['address_id'] ) ) {
            return DB::table( 'addresses' )->where( 'user_id', '=', $id['user_id'] )->exists();
        }

        return DB::table( 'addresses' )->where( 'id', '=', $id['address_id'] )->exists();
    }

    protected function createUserAddress( array $attributes ) {
        return Address::create( $attributes );
    }

    protected function updateUserAddress( array $attributes ) {
        $address = Address::where( 'user_id', $attributes['user_id'] )->firstOrFail();
        $address->update( $attributes );

        return $address;
    }

    public function getOrdersJson( array $attributes ) {
        $orders = $this->getAll();

        return datatables( $orders )->toJson();
    }

    public function createFrontendOrder( array $attributes ) {
        // dd((int) getConfiguration('tax_percentage'));
        // Update address
        $addressData = [
            'type'       => 'SHIPPING',
            'user_id'    => auth()->id(),
            'first_name' => $attributes['first_name'],
            'last_name'  => $attributes['last_name'],
            'email'      => $attributes['email'],
            'phone'      => $attributes['phone'],
            'address1'   => $attributes['address1'],
            'address2'   => $attributes['address2'],
            'country_id' => isset( $attributes['country'] ) ? $attributes['country'] : 1,
            'state_id'   => $attributes['state'],
            'city'       => $attributes['city'],
            'postcode'   => $attributes['postcode'],
        ];

        $address = Address::updateOrCreate( [ 'user_id' => auth()->id() ], $addressData );

        $attributes['billing_address_id']  = $address->id;
        $attributes['shipping_address_id'] = $address->id;

        $orderStatus = OrderStatus::whereIsDefault( 1 )->get()->first();

        // Create new order
        $order = $this->model->create( [
            'billing_address_id'  => $attributes['billing_address_id'],
            'shipping_address_id' => $attributes['shipping_address_id'],
            'user_id'             => auth()->id(),
            'enable_tax'          => getConfiguration('enable_tax'),
            'tax_percentage'      => (int) getConfiguration('tax_percentage'),
            'order_status_id'     => $orderStatus->id,
            'order_note'          => $attributes['order_note'],
            'order_date'          => Carbon::now()->toDateTimeString(),
        ] );

        // Attach products
        $cartContents = Cart::content();
        if ( $cartContents ) {


            foreach ($cartContents as $cartContent) {
              
                $order->products()->attach($cartContent->id,
                    [
                        'qty' => $cartContent->qty,
                        'price' => $cartContent->price,
                        'discount' => 0.00,

                        'tax_amount' => 0.00

                    ]
                );

            }
        }
        // Destory cart
        Cart::destroy();

        return $order;
    }

    public function updateFrontendOrder( $id, array $attributes ) {

    }

    /**
     * List user orders
     *
     * @param $id
     */
    public function getUserOrders( $id ) {
        $orders = Order::where('user_id', '=', $id)->orderBy('id','DESC')->get();
        return $orders;
    }
}