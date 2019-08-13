@extends('layouts.app')
@push('styles')

@endpush
@section('content')
    @inject('productInstance', 'App\Http\Controllers\CompareController')
    <section class="page-header mb-lg">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li class="active">Compare</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            @if(count($compareList))
                @foreach($compareList as $compare)
                    @php $product = $productInstance::getProductInstance($compare->id) @endphp
                    <div class="col-md-4">
                        <div class="compare-item well">
                            <div class="thumbnail">
                                <img src="{{ $product->getImageAttribute()->mediumUrl }}"
                                     alt="{{ $product->name }}">
                            </div>
                            <h4>{{ $product->name }}</h4>

                            <div class="product-price-box">
                                <h4 class="price">Price:</h4>
                              @if ( auth()->guest() )
                                @if(!$product->disable_price)
                                    @if(null !== $product->getSalePriceAttribute())
                                        <span class="old-price">RS{{ $product->getRegularPriceAttribute() }}</span>
                                        <span class="product-price">RS{{ $product->getSalePriceAttribute() }}</span>
                                    @else
                                        <span class="product-price">RS{{ $product->getRegularPriceAttribute() }}</span>
                                    @endif
                                @else
                                    -
                                @endif
                     @else
                  @if(null !== $product->getSalePriceAttribute())
                                        <span class="old-price">RS{{ $product->getRegularPriceAttribute() }}</span>
                                        <span class="product-price">RS{{ $product->getSalePriceAttribute() }}</span>
                                    @else
                                        <span class="product-price">RS{{ $product->getRegularPriceAttribute() }}</span>
                                    @endif
           @endif


                            </div>

                            <h4>Availability: In stock</h4>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-12">
                    <div class="alert alert-success alert-message display-block mb-none">
                        <div>
                            <span>No items found in compare list.
                                <a href="{{ route('shop') }}"
                                   class="btn btn-xs btn-primary pull-right">Back to shop</a>
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')

@endpush