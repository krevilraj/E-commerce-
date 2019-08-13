@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('img/logo.png') }}" alt="" width="150px">
        @endcomponent
    @endslot

<h2>{{$content['name']}} has requested an Product</h2>
@component('mail::button', ['url' => url('/dashboard/request'),'color' => 'red'])
View My Dashboard
@endcomponent

<table class="table" border="1">
    <tbody>
    <tr>
<td>
    Name of Product
</td>
        <td>
            {{$content['subject']}}
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
            Application of Product
        </td>
        <td>
            {{$content['application']}}
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



