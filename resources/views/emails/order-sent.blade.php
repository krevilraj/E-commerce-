@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('img/logo.png') }}" alt="" width="150px">
        @endcomponent
    @endslot


# Thank You For Your Purchase
** Hi &nbsp;{{$content['name']}}, We are getting Your Order Ready to be Shipped.We will Notify You When it has been Sent .**
@component('mail::button', ['url' => URL::to('/').'/dashboard/my-account/orders' ,'color' => 'red'])
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
  <th>      Price</th>
            <th>      Quantity </th>
  <th>      Total</th>

</tr>
</thead>
        <tbody>
<?php $var=0 ;?>
@foreach($content['products'] as $cart)
   <?php $var =((int)$cart->price *(int)$cart->qty+ $var ) ; ?>
    <tr>
        <td>
   <h4> {{ucfirst(trans($cart->name))}}</h4>
        </td>
         <h4>   Rs.  {{$cart->price }}</h4>

        <td>
           <h4> {{$cart->qty}}</h4>
        </td>
        <td>
         <h4> Rs.  {{$cart->price * $cart->qty}}</h4>
        </td>

    </tr>
    @endforeach
    <tr>
        <td>

        </td>
        <td>
  <h4>Tax</h4>
        </td>
        <td>
           @if( getConfiguration('enable_tax'))
           <h4>Rs. {{(int) getConfiguration('tax_percentage') * (int) $var}}</h4>
               @else 
             <h4> -</h4>
            @endif
        </td>
    </tr>
<tr>
    <td>

    </td>
    <td>
    <h4> Total</h4>
    </td>
    <td>
        @if( getConfiguration('enable_tax'))
        {{((int) getConfiguration('tax_percentage') * (int) $var)+$var}}
        @else
        <h4> Rs.  {{$var}}</h4>
        @endif
    </td>
</tr>
</tbody>
</table>
@endcomponent

    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent