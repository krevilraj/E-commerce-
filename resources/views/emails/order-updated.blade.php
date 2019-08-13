@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('img/logo.png') }}" alt="" width="150px">
        @endcomponent
    @endslot


    ** The  Order #{{$content['id']}} has been {{$content['value']}},Please check the following link for details **
    @component('mail::button', ['url' => URL::to('/').'/dashboard/order' ,'color' => 'red'])
                Check Order
            @endcomponent
<div style="display: inline-block"> Or <a href="{{URL::to('/')}}">Visit Our Store</a></div>

 @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent

