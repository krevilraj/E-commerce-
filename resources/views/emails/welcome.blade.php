@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('img/logo.png') }}" alt="" width="150px">
        @endcomponent
    @endslot
# Welcome {{ $content['name'] }},
Your Account Has Been Approved.You Can Use All the Services Provided By {{getConfiguration('site_title') ? getConfiguration('site_title') : env('APP_NAME') }}.
Thanks for signing up. **We really appreciate** it.

@component('mail::button', ['url' => url('/my-account'),'color' => 'red'])
Shop Now
@endcomponent

@slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
