@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li class="active">{{ $page->name }}</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9">

                <div class="blog-posts single-post">

                    <article class="post post-large blog-single-post ml-none">

                        @if(optional($page->getImage())->largePageUrl)
                            <div class="post-image">
                                <div class="img-thumbnail">
                                    <img class="img-responsive" src="{{ optional($page->getImage())->largePageUrl }}" alt="">
                                </div>
                            </div>
                        @endif

                        <div class="post-content">

                            <h2>
                                <a href="javascript:void(0);">{{ $page->title }}</a>
                            </h2>

                            {!! $page->content !!}

                        </div>
                    </article>

                </div>

            </div>

            <div class="col-md-3">
                @include('blog.sidebar')
            </div>
        </div>
    </div>
@endsection