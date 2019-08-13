@extends('layouts.app')

@push('styles')
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('content')
    <section class="page-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('blog') }}">Blog</a></li>
                <li class="active">{{ $post->title }}</li>
            </ul>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="blog-posts single-post">

                    <article class="post post-large blog-single-post">

                        @if(optional($post->getImage())->largePageUrl)
                            <div class="post-image">
                                <div class="img-thumbnail">
                                    <img class="img-responsive" src="{{ optional($post->getImage())->largePageUrl }}"
                                         alt="">
                                </div>
                            </div>
                        @endif

                        <div class="post-date">
                            <span class="day">{{ Carbon\Carbon::parse($post->created_at)->format('d') }}</span>
                            <span class="month">{{ Carbon\Carbon::parse($post->created_at)->format('M') }}</span>
                        </div>

                        <div class="post-content">

                            <h2>
                                <a href="javascript:void(0);">{{ $post->title }}</a>
                            </h2>

                            <div class="post-meta">
                                <span>
                                    <i class="fa fa-user"></i> By
                                    <a href="javascript:void(0);">{{ $post->user->full_name }}</a>
                                </span>
                                <span>
                                    <i class="fa fa-tag"></i>
                                    <a href="javascript:void(0);">{{$post->tags}}</a>
                                </span>
                                <span>
                                    <i class="fa fa-comments"></i>
                                    <a href="javascript:void(0);">{{ $post->comments->count() }} Comments</a>
                                </span>
                            </div>

                            {!! $post->content !!}

                            <div class="post-block post-share">
                                <h3 class="h4 heading-primary"><i class="fa fa-share"></i>Share this post</h3>

                                <!-- AddThis Button BEGIN -->
                                <div class="addthis_toolbox addthis_default_style ">
                                    <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                                    <a class="addthis_button_tweet"></a>
                                    <a class="addthis_button_pinterest_pinit"></a>
                                    <a class="addthis_counter addthis_pill_style"></a>
                                </div>
                                <script type="text/javascript"
                                        src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50faf75173aadc53"></script>
                                <!-- AddThis Button END -->

                            </div>

                            <div class="post-block post-author clearfix">
                                <h3 class="heading-primary"><i class="fa fa-user"></i>Author</h3>
                                <div class="img-thumbnail">
                                    <a href="#">
                                        <img src="{{ null !== $post->user->getImage() ? $post->user->getImage()->smallUrl : url('/uploads/avatar.jpg') }}"
                                             alt="">
                                    </a>
                                </div>
                                <p><strong class="name">{{$post->user->full_name}}</strong></p>

                            </div>

                            <div class="post-block post-comments clearfix">
                                <h3 class="heading-primary"><i class="fa fa-comments"></i>Comments
                                    ({{ $post->comments->count() }})</h3>

                                @if($post->allComments()->count() > 0)
                                    <ul class="comments">
                                        @foreach($post->allComments() as $comment)
                                            <li>
                                                <div class="comment">
                                                    <div class="img-thumbnail">
                                                        <img class="avatar" alt=""
                                                             src="{{ null !== $comment->user->getImage() ? $comment->user->getImage()->smallUrl : url('/uploads/avatar.jpg') }}">
                                                    </div>
                                                    <div class="comment-block">
                                                        <div class="comment-arrow"></div>
                                                        <span class="comment-by">
                                                    <strong>{{ $comment->user->full_name }}</strong>
                                                    <span class="pull-right">
                                                        <span> <a href="#post-leave-comment" class="reply"
                                                                  data-comment="{{ $comment->id }}"><i
                                                                        class="fa fa-reply"></i> Reply</a></span>
                                                    </span>
                                                </span>
                                                        <p>{{ $comment->comment }}</p>
                                                        <span class="date pull-right">{{ Carbon\Carbon::parse($comment->created_at)->format('F j, Y g:i a') }}</span>
                                                    </div>
                                                </div>

                                                @include('blog.comments', ['comments' => $comment])
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="m-none">Be the first one to comment.</p>
                                @endif

                            </div>

                            <div id="post-leave-comment" class="post-block post-leave-comment">
                                <h3 class="heading-primary">Leave a comment</h3>

                                <div class="alert alert-danger alert-message"></div>

                                <form action="{{ route('comment.store', $post->id) }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="reply_id" value="0">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Comment *</label>
                                                <textarea name="comment" id="comment" class="form-control"
                                                          maxlength="5000" rows="10"
                                                          title="" required>{{ old('comment') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="submit" value="Post Comment"
                                                   class="btn btn-primary btn-comment pull-right"
                                                   data-loading-text="Loading...">
                                        </div>
                                    </div>
                                </form>
                            </div>

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

@push('scripts')
    <!-- Sweetalert2 -->
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        function sweetAlert(type, title, message) {
            swal({
                title: title,
                html: message,
                type: type,
                confirmButtonColor: '#57BC90',
                timer: 3000
            }).catch(swal.noop);
        }

        $('a.reply').on('click', function (e) {
            e.preventDefault();
            var that = $(this);

            var comment = that.attr('data-comment');

            $('html, body').animate({
                scrollTop: $(that.attr('href')).offset().top
            }, 500);

            $('#post-leave-comment').find('input[name=reply_id]').val(comment)

        });

        // Post comment
        $(document).on("click", ".btn-comment", function (e) {
            e.preventDefault();
            var $this = $(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var data = {
                'reply_id': $('input[name=reply_id]').val(),
                'comment': $('textarea[name=comment]').val()
            };

            $.ajax({
                type: "POST",
                url: "{{ route('comment.store', $post->id)  }}",
                data: data,
                beforeSend: function () {
                    $this.button('loading');
                },
                success: function (data) {
                    if (data.status) {
                        sweetAlert('success', 'Success', data.message);
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var err;
                    if (xhr.status === 401) {
                        err = eval("(" + xhr.responseText + ")");
                        sweetAlert('error', 'Oops...', 'Please login to comment!!');
                        return false;
                    }

                    var errorsHolder = '';
                    errorsHolder += '<ul>';

                    err = eval("(" + xhr.responseText + ")");
                    $.each(err.errors, function (key, value) {
                        errorsHolder += '<li>' + value + '</li>';
                    });

                    errorsHolder += '</ul>';

                    console.log(errorsHolder);

                    $('.alert-message.alert-danger').fadeIn().html(errorsHolder);
                },
                complete: function () {
                    $this.button('reset');
                    $this.closest('form').trigger("reset");
                }
            });

        });
    </script>
@endpush