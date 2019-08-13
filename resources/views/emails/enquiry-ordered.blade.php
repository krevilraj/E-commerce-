


    <h2>{{$content['name']}} has requested an order of  Following Items</h2>

    Click the following link to Check The Order
    @component('mail::button', ['url' => URL::to('/').'dashboard/order' ,'color' => 'red'])
        Check Order
    @endcomponent

    <table class="table" border="1">
        <thead>
        <tr>
            <th>
                Product
            </th>
            <th>      Quantity </th>


        </tr>
        <tbody>

            <tr>
                <td>
                    {{$content['product']}}
                </td>
                <td>
                    {{$content['quantity']}}
                </td>
            </tr>

        </tbody>
    </table>
    <h2>Delivery Details</h2>
    <table class="table" border="1">
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
    {{ config('app.name') }}

