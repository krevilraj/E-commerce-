@extends('backend.layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="{{ route('dashboard.users.index') }}">Users</a></li>
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

                        <p class="text-muted text-center">
                            {{ optional($user->roles->first())->display_name }}
                        </p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Orders</b>
                                <a href="javascript:void(0);" class="pull-right">
                                    {{--{{ optional($user->orders())->count() }}--}}
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
                        <li class="active"><a href="#settings" data-toggle="tab">Info</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            <ul class="list-group">
                                <li class="list-group-item"><strong>First Name: </strong>{{ $user->first_name }}</li>
                                <li class="list-group-item"><strong>Last Name: </strong>{{ $user->last_name }}</li>
                                <li class="list-group-item"><strong>Email: </strong>{{ $user->email }}</li>
                                <li class="list-group-item"><strong>Phone: </strong>{{ $user->phone }}</li>
                            </ul>
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

@endsection