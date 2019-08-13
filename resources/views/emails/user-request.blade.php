@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('img/logo.png') }}" alt="" width="150px">
        @endcomponent
    @endslot

<h2>Thank You For Contacting Us.Your Request Has Reached To Us.We Well Contact You Very Soon .If It Is Urgent Please Contact Us At {{getConfiguration('site_primary_phone')}} Or Email at {{getConfiguration('site_primary_email')}}. </h2>
@component('mail::button', ['url' => url('/'),'color' => 'red'])
Shop Now
@endcomponent
<hr>
 <h2> Request Details</h2>
<table class="table" >
    <tbody>
    <tr>
<td>
    Name
</td>
        <td>
            {{$content['subject']}}
        </td>
    </tr>
    <tr>
        <td>
            Phone 
        </td>
        <td>
            {{$content['phone']}}
        </td>
    </tr>
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
            Description
        </td>
        <td>
            {{$content['message']}}
        </td>
    </tr>
    <tr>
        <td>
            Link
        </td>
        <td>
            {{$content['link']}}
        </td>
    </tr>
    <tr>
        <td>
            Application 
        </td>
        <td>
           	&nbsp;
 {{$content['application']}}
        </td>
    </tr>

    </tbody>


</table>
<hr>
You Can Reply From Here
@slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent



