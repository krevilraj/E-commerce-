@extends('backend.layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-default">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle"
                             src="{{ null !== $user->getImage() ? optional($user->getImage())->smallUrl : url('/uploads/avatar.jpg') }}"
                             alt="User profile picture">

                        <h3 class="profile-username text-center">{{ $user->full_name }}</h3>

                        @role('admin')
                        <p class="text-muted text-center">
                            {{ $user->roles->first()->display_name }}
                        </p>
                        @endrole
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Posts</b>
                                <a href="javascript:void(0);" class="pull-right">
                                    {{ $user->posts()->count() }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            <form action="{{ route('dashboard.profile.update') }}" method="post"
                                  class="form-horizontal" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('backend.profile.form')
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->

@stop

@push('scripts')

@endpush