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

    <div class="container page-content">

        <div class="row">
            <div class="col-md-8">
                {!! $page->content !!}
            </div>
            <div class="col-md-4">
                @if(null !== $page->getImage())
                    <img src="{{ $page->getImage()->mediumUrl }}" alt="" class="img-responsive">
                @endif
            </div>
        </div>

    </div>

    <section

            class="parallax section section-text-light section-parallax section-center section-overlay-opacity section-overlay-opacity-scale-8 mt-none mb-50"
            data-plugin-parallax
            data-plugin-options="{'speed': 1.5}" data-image-src="http://nextnepalgroup.com/storage/background/background.jpeg">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="owl-carousel owl-theme nav-bottom rounded-nav"
                         data-plugin-options="{'items': 1, 'loop': true, 'autoplay': true}">

                        @foreach($about as $testimonial)
                            <div>

                                <div class="col-md-12">
                                    <div class="testimonial testimonial-style-2 testimonial-with-quotes mb-none">
                                    <p style="color: #c1bdbd;font-size: 30px;font-family: museo-slab;/* height: 25px; */padding-bottom: 0px;margin-bottom: 0;"><strong>What Our Founder Say </strong></p>
                                        <div class="testimonial-author">
                                            <img src="{{ null === $testimonial->getImage()  ? $testimonial->getDefaultImage('uploads/avatar.jpg')->url : $testimonial->getImage()->smallUrl }}"
                                                 class="img-responsive img-circle" alt="">
                                        </div>
                  

                                        <blockquote>
                                            {!! $testimonial->content !!}
                                        </blockquote>
                                        <div class="testimonial-author">
                                            <p><strong>{{ $testimonial->author }}</strong>
                                                @if($testimonial->title)
                                                    <span>{{ $testimonial->title }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{route('about-message')}}" class="btn btn-primary btn-sm" style="margin-top: 40px;">View
                                    All</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container page-content">
        <div class="row mt-xlg">
            <div class="col-md-12">
                <h2><strong>Who</strong> We Are</h2>
                <p>{{ getConfiguration('who_we_are') }}</p>
                <hr class="tall">
            </div>
            <div class="col-md-12">
                <div class="featured-boxes featured-boxes-style-6">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="featured-box featured-box-primary featured-box-effect-6 mt-md">
                                <div class="box-content">
                                    <i class="icon-featured fa fa-user"></i>
                                    <h4>Our Mission</h4>
                                    <p>{{ getConfiguration('our_mission') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="featured-box featured-box-secondary featured-box-effect-6 mt-md">
                                <div class="box-content">
                                    <i class="icon-featured fa fa-book"></i>
                                    <h4>Our Vision</h4>
                                    <p>{{ getConfiguration('our_vision') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="featured-box featured-box-tertiary featured-box-effect-6 mt-md">
                                <div class="box-content">
                                    <i class="icon-featured fa fa-trophy"></i>
                                    <h4>Our Help</h4>
                                    <p>{{ getConfiguration('our_help') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="featured-box featured-box-quaternary featured-box-effect-6 mt-md">
                                <div class="box-content">
                                    <i class="icon-featured fa fa-cogs"></i>
                                    <h4>Our Supports</h4>
                                    <p>{{ getConfiguration('our_support') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="call-to-action call-to-action-default with-button-arrow call-to-action-in-footer pb-lg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><strong>Our</strong> Team</h2>
                </div>
                @foreach($teamMembers as $teamMember)
                    <div class="col-md-3 col-sm-6 col-xs-12 mb-xlg">
                        <span class="thumb-info thumb-info-hide-wrapper-bg">
                            <span class="thumb-info-wrapper">
                                <a href="javascript:void(0);">
                                    <img src="{{ null === $teamMember->getImage()  ? $teamMember->getDefaultImage('uploads/avatar.jpg')->url : $teamMember->getImage()->mediumUrl }}"
                                         class="img-responsive" alt="">
                                    <span class="thumb-info-title">
                                        <span class="thumb-info-inner">{{ $teamMember->name }}</span>
                                        <span class="thumb-info-type">{{ $teamMember->designation }}</span>
                                    </span>
                                </a>
                            </span>
                            <span class="thumb-info-caption">
                                <span class="thumb-info-caption-text">
                                    {{ $teamMember->content }}
                                </span>
                                <span class="thumb-info-social-icons">
                                    <a href="{{ $teamMember->facebook_link or '#' }}" target="_blank">
                                        <i class="fa fa-facebook"></i>
                                        <span>Facebook</span>
                                    </a>
                                    <a href="{{ $teamMember->twitter_link or '#' }}" target="_blank">
                                        <i class="fa fa-twitter"></i>
                                        <span>Twitter</span>
                                    </a>
                                    <a href="{{ $teamMember->googleplus_link or '#' }}" target="_blank">
                                        <i class="fa fa-google-plus"></i>
                                        <span>Google Plus</span>
                                    </a>
                                    <a href="{{ $teamMember->linkedin_link or '#' }}" target="_blank">
                                        <i class="fa fa-linkedin"></i>
                                        <span>Linkedin</span>
                                    </a>
                                </span>
                            </span>
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection