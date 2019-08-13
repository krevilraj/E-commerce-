@if(!empty($comments['replies']))
    <ul class="comments reply">
        @foreach($comments['replies'] as $reply)
            <li>
                <div class="comment">
                    <div class="img-thumbnail">
                        <img class="avatar" alt=""
                             src="{{ null !== $reply->user->getImage() ? $reply->user->getImage()->smallUrl : url('/uploads/avatar.jpg') }}">
                    </div>
                    <div class="comment-block">
                        <div class="comment-arrow"></div>
                        <span class="comment-by">
                            <strong>{{ $reply->user->full_name }}</strong>
                            <span class="pull-right">
                                <span>
                                    <a href="#post-leave-comment" class="reply" data-comment="{{ $reply->id }}"><i class="fa fa-reply"></i> Reply</a>
                                </span>
                            </span>
                        </span>
                        <p>{{ $reply->comment }}</p>
                        <span class="date pull-right">{{ Carbon\Carbon::parse($reply->created_at)->format('F j, Y g:i a') }}</span>
                    </div>
                </div>
                @include('blog.comments', ['comments' => $reply])
            </li>
        @endforeach
    </ul>
@endif