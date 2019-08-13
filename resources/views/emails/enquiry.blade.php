
@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('img/logo.png') }}" alt="" width="150px">
        @endcomponent
    @endslot


            <h2>{{$content['name']}} has requested an Enquiry of  Following Items</h2>

            Click the following link to Check The Enquiry
            @component('mail::button', ['url' => URL::to('/').'/dashboard/enquiries' ,'color' => 'red'])
                Check Order
            @endcomponent

            <table class="table" >
                <thead>
                <tr>
                    <th>
                        Product
                    </th>
                    <th>      Quantity </th>


                </tr>
                <tbody>
                @foreach($content['products'] as $cart)

                    <tr>
                        <td>
                            {{$cart->name}}
                        </td>
                        <td>
                            {{$cart->qty}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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



   
