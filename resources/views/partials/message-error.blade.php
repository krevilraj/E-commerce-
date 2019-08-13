@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><i class="fa fa-warning"></i>Oh snap!</strong>
        {!! session('error') !!}
    </div>
@endif