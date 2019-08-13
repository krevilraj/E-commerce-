@extends('layouts.app')
@section('content')
    <section class="page-header mb-lg">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li class="active">Brands</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                @if(count($brands) <= 0)
                    <div class="alert alert-danger">
                        No brands found.
                    </div>
                @else

                    <ul class="products-grid columns4">
                        @foreach($brands as $brand)
                            <li>
                                <div class="product">
                                    <figure class="product-image-area">
                                        <a href="{{ $brand->link }}" title="{{ $brand->name }}"
                                           class="product-image" target="_blank">
                                            <img src="{{ $brand->getImage()->url }}" alt="{{ $brand->name }}">
                                        </a>
                                    </figure>
                                    <div class="product-details-area">
                                        <h2 class="product-name">
                                            <a href="{{ $brand->link }}" title="{{ $brand->name }}" target="_blank">
                                                {{ $brand->name }}
                                            </a>
                                        </h2>

                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                @endif
            </div>

            <div class="col-md-3">
                @include('blog.sidebar')
            </div>
        </div>
    </div>
@endsection