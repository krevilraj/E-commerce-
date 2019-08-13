@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('img/logo.png') }}" alt="" width="150px">
        @endcomponent
    @endslot


    # Thank You For Your Purchase
    ** Hi &nbsp;{{$content['name']}}, We are getting Your Order Ready to be Shipped.We will Notify You When it has been Sent**
    @component('mail::button', ['url' => URL::to('/').'/dashboard/order' ,'color' => 'red'])
        View Your Order
    @endcomponent
    <div style="display: inline-block"> Or <a href="{{URL::to('/')}}">Visit Our Store</a></div>

    @component('mail::subcopy')

        # Order Summary
        <table class="table" border="0">
            <thead>
            <tr>
                <th>
                    Product
                </th>
                <th>      Quantity </th>
                <th>      Price </th>

            </tr>
            </thead>
            <tbody>
<?php $var=0 ; ?>
            @foreach($content['products'] as $cart)
 
                <?php $var =((int)$cart->price + $var ) ; ?>
                <tr>
                    <td>
                        {{ucfirst(trans($cart->name))}}
                    </td>
                    <td>
                        {{$cart->qty}}
                    </td>
                    <td>
                        **Rs.** <h4>   {{$cart->price}}</h4>
                    </td>

                </tr>
            @endforeach
            <tr>
                <td>

                </td>
                <td>
                    Tax
                </td>
                <td>
                    @if( getConfiguration('enable_tax'))
                        {{(int) getConfiguration('tax_percentage') * (int) $var}}
                    @else
                        ---
                    @endif
                </td>
            </tr>
            <tr>
                <td>

                </td>
                <td>
                    <h4>Total</h4>
                </td>
                <td>
                    @if( getConfiguration('enable_tax'))
                        {{((int) getConfiguration('tax_percentage') * (int) $var)+$var}}
                    @else
                        <h3>   {{$var}}</h3>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    @endcomponent

    
<h2>Delivery Details</h2>
<table class="table" >
    <tbody>
    <tr>
<td>
    Email
</td>
        <td>
            {{$content['email']}}
        </td>
    </tr>
    <tr>
        <td>
            Phone No
        </td>
        <td>
            {{$content['phone']}}
        </td>
    </tr>
 <tr>
        <td>
           City
        </td>
        <td>
            {{$content['city']}}
        </td>
    </tr>
    <tr>
        <td>
            Address1
        </td>
        <td>
            {{$content['address1']}}
        </td>
    </tr>
    <tr>
        <td>
            Address2
        </td>
        <td>
            {{$content['address2']}}
        </td>
    </tr>

    </tbody>


</table>
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent