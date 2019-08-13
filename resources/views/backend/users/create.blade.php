@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Create New User</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('dashboard.users.index') }}">Users</a></li>
            <li class="active">Create</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

            @include('backend.partials.message-success')
            @include('backend.partials.message-error')

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add New</h3>
                    </div>
                    <!-- /.box-header -->
                    {{--form start--}}
                    {!! Form::open(['route'=>'dashboard.users.store', 'files' => true, 'class' => 'form-horizontal']) !!}
                    @include('backend.users.form2', ['submitButtonText' => 'Submit'])
                    {!! Form::close() !!}
                    {{--form close--}}
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection