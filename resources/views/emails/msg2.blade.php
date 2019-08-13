
@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('img/logo.png') }}" alt="" width="150px">
        @endcomponent
    @endslot

@isset($content['type'])
@if($content['type']=='contact')
 Dear {{\App\Contact::where('id',$content['id'])->first()->name}},  This is reply from Your Previous message ::

<table class="table" >
    <tbody>
    <tr>
<td>
    Name 
</td>
<td>
            {{\App\Contact::where('id',$content['id'])->first()->name}}
        </td>
    </tr>
<tr>
    Subject
        <td>
            {{\App\Contact::where('id',$content['id'])->first()->subject}}
        </td>
    </tr>
    <tr>
        <td>
            Phone 
        </td>
        <td>
            {{\App\Contact::where('id',$content['id'])->first()->phone}}
        </td>
    </tr>
 <tr>
        <td>
          Email
        </td>
        <td>
            {{\App\Contact::where('id',$content['id'])->first()->email}}
        </td>
    </tr>
    <tr>
        <td>
            {{\App\Contact::where('id',$content['id'])->first()->message}}
        </td>
        <td>
           	
        </td>
    </tr>
   

    </tbody>


</table>

@endif
@if($content['type']=='request')
 Dear {{\App\RequestProduct::where('id',$content['id'])->first()->name}},  This is reply from Your Previous Request of Product::<br>

<table class="table" >
    <tbody>
    <tr>
<td>
    Name
</td>
        <td>
{{\App\RequestProduct::where('id',$content['id'])->first()->suvject}}        </td>
    </tr>
    <tr>
        <td>
            Phone 
        </td>
        <td>
         {{\App\RequestProduct::where('id',$content['id'])->first()->phone}}
        </td>
    </tr>
 <tr>
        <td>
          Email
        </td>
        <td>
{{\App\RequestProduct::where('id',$content['id'])->first()->email}}        </td>
    </tr>
    <tr>
        <td>
            Description &nbsp;
        </td>
        <td>
{{\App\RequestProduct::where('id',$content['id'])->first()->message}}        </td>
    </tr>
    <tr>
        <td>
            Link
        </td>
        <td>
{{\App\RequestProduct::where('id',$content['id'])->first()->link}}        </td>
    </tr>
    <tr>
        <td>
            Application 
        </td>
        <td>
           	&nbsp;
{{\App\RequestProduct::where('id',$content['id'])->first()->application}}        </td>
    </tr>

    </tbody>


</table>

@endif
<hr>
The Reply From admin is here <br>
@endisset

# {{$content['message']}}

@component('mail::button', ['url' =>URL::to('/'),'color' => 'red'])
          {{getConfiguration('company_name')}}
            @endcomponent

 ** Thanks For Using {{getConfiguration('company_name')}}. **

<hr>
You Can Reply From Here
 @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent


