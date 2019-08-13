@extends('layouts.app')

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li class="active">Blog</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9">

                <div class="blog-posts">

                    @foreach($posts as $post)
                        <article class="post post-large">
                            @if(optional($post->getImage())->largePageUrl)
                                <div class="post-image">
                                    <div class="img-thumbnail">
                                        <img class="img-responsive" src="{{ optional($post->getImage())->largePageUrl }}" alt="">
                                    </div>
                                </div>
                            @endif

                            <div class="post-date">
                                <span class="day">{{ Carbon\Carbon::parse($post->created_at)->format('d') }}</span>
                                <span class="month">{{ Carbon\Carbon::parse($post->created_at)->format('M') }}</span>
                            </div>

                            <div class="post-content">

                                <h2>
                                    <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <p>{{ excerpt($post->content, 16) }}</p>

                                <a href="{{ route('post.show', $post->slug) }}" class="btn btn-xs btn-link">Read
                                    more</a>

                                <div class="post-meta">
                                    <span>
                                        <i class="fa fa-calendar"></i> {{ Carbon\Carbon::parse($post->created_at)->format('M j, Y g:i a') }}
                                    </span>
                                    <span>
                                        <i class="fa fa-user"></i> By
                                        <a href="javascript:void(0);">{{ $post->user->full_name }}</a>
                                    </span>
                                    <span>
                                        <i class="fa fa-tag"></i>
                                        {{$post->tags}}
                                    </span>
                                </div>

                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="toolbar">
                    <div class="sorter">

                        {{ $posts->links() }}

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                @include('blog.sidebar')
            </div>
        </div>
    </div>
@endsection