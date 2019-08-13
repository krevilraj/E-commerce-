@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('img/logo.png') }}" alt="" width="150px">
        @endcomponent
    @endslot




    # {{$content['msg']}}

       

        @component('mail::button', ['url' =>URL::to('/'),'color' => 'red'])
           {{getConfiguration('company_name')}}
        @endcomponent
    @endcomponent
    ** Thanks For Using {{getConfiguration('company_name')}}. **


    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent

