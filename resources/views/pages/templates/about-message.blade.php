@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>

            </ul>
        </div>
    </section>

    <div class="container page-content">

        <div class="row">
            @foreach($about as $testimonial)
                <div class="col-md-6">
                    <div class="testimonial testimonial-style-4 mb-xlg">
                        <blockquote>
                            {!! $testimonial->content !!}
                        </blockquote>
                        <div class="testimonial-arrow-down"></div>
                        <div class="testimonial-author">
                            <div class="testimonial-author-thumbnail">
                                <img src="{{ null === $testimonial->getImage()  ? $testimonial->getDefaultImage('uploads/avatar.jpg')->url : $testimonial->getImage()->smallUrl }}"
                                     class="img-responsive img-circle" alt="">
                            </div>
                            <p>
                                <strong>{{ $testimonial->title }}</strong>
                                @if($testimonial->author)
                                    <span>{{ $testimonial->author }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@endsection