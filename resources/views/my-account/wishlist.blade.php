@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('my-account') }}">My Account</a></li>
                <li class="active">Wishlist</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3 my-account">
                <h1 class="h2 heading-primary font-weight-normal">My Wishlist</h1>

                @include('partials.message-success')

                @if(count($wishlists) <= 0)
                    <div class="alert alert-danger">
                        <p>No products in wishlist.</p>
                    </div>
                @else

                    <table class="table table-bordered table-order-list table-content-align-center mb-none">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($wishlists as $wishlist)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('product.show', $wishlist->product->slug) }}">
                                        {{ $wishlist->product->name }}
                                    </a>
                                </td>
                                <td>{{ humanizeDate($wishlist->created_at) }}</td>
                                <td class="actions">
                                    @unless($wishlist->product->disable_price)
                                        <form action="{{ route('cart.store' )}}"
                                              method="post">
                                            <input type="hidden" name="product" value="{{ $wishlist->product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            {{ csrf_field() }}
                                            <input type="submit" value="Add To Cart"
                                                   class="btn btn-sm btn-primary p-6-12">
                                        </form>
                                    @endunless
                                    <form action="{{ route('my-account.wishlist.destroy',$wishlist->product->id )}}"
                                          method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">

                                        <input type="submit" value="Delete" class="btn btn-sm btn-primary p-6-12">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="pull-right">
                        {{--{{ $wishlists->setPath('wishlist')->render() }}--}}
                    </div>
                @endif

            </div>

            @include('my-account.sidebar')
        </div>
    </div>
@endsection
