@if (Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><i class="fa fa-thumbs-o-up"></i> Success!</strong>
        {!! session('success') !!}
    </div>
@endif