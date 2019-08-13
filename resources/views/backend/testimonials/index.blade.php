@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>All Testimonials
            <small>({{ $testimonialsCount }})</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Testimonials</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                @include('backend.partials.message-success')
                @include('backend.partials.message-error')
                {!!    Form::open(['method' => 'post', 'route' => 'dashboard.background.save', 'files' => true])   !!}
                {{csrf_field()}}

                <div class="form-group @if ($errors->has('image')) has-error @endif">
                    {!! Form::label('image',' Change Background_image', ['class' => 'control-label']) !!}
                    {!! Form::file('image', ['class'=> 'form-control',]) !!}

                    {!! Form::submit('Upload', ['class'=>'btn btn-danger pull-left','style'=>'margin-top:10px']) !!}

                    @if ($errors->has('featured_image'))
                        <span class="help-block">
                        {{ $errors->first('featured_image') }}
                    </span>
                    @endif
                    {!! Form::close() !!}

                    <a href="{{ route('dashboard.testimonials.create') }}" class="btn btn-sm btn-danger pull-right" style="margin-top: 10px">Add New</a>
                </div>


                <div class="box" style="margin-top: 50px">
                    <div class="box-header">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="sorting-false text-center"><i class="fa fa-image"></i></th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th class="sorting-false text-center"><i class="fa fa-image"></i></th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.datatable').DataTable({
aaSorting: [[0, 'desc']],
                columnDefs: [
                    {"width": "2%", "targets": 0},
                    {"width": "5%", "targets": 1},
                    {"width": "28%", "targets": 2}
                ],
                processing: true,
                serverSide: true,
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            var testimonialEditUrl = "{{ route('dashboard.testimonials.edit', ':id') }}";

                            testimonialEditUrl = testimonialEditUrl.replace(':id', data);
                            return '<a href="' + testimonialEditUrl + '">#' + data + '</a>';
                        }
                    },
                    {
                        data: 'featured_image',
                        orderable: false,
                        render: function (data, type, row) {
                            return '<img src="' + data + '" width="50">';
                        }
                    },
                    {
                        data: 'title',
                        render: function (data, type, row) {
                            return '<a href="{{ url('/dashboard/testimonials') }}' + '/' + row.id + '/edit' + '">' + data + '</a>';
                        }
                    },
                    {data: 'author', name: 'author'},
              {
                        data: 'status',
                        name: 'status',
                        render: function (data, type, row) {
                            return data === '0' ? ' <span class="label label-danger"> Disabled</span>' : ' <span class="label label-success"> Enabled</span>';
                        }
                    },
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempEditUrl = "{{ route('dashboard.testimonials.edit', ':id') }}";
                            var tempDeleteUrl = "{{ route('dashboard.testimonials.destroy', ':id') }}";

                            tempEditUrl = tempEditUrl.replace(':id', data);
                            tempDeleteUrl = tempDeleteUrl.replace(':id', data);

                            var actions = '';
                            actions += "<a href='" + tempEditUrl + "' class='btn btn-xs btn-info mr-5'>Edit</a>";
                            actions += "<form action='" + tempDeleteUrl + "' method='post'>";
                            actions += "<input type='hidden' name='_token' value='{{ csrf_token() }}'>";
                            actions += "<input type='hidden' name='_method' value='DELETE'>";
                            actions += "<button type='submit' class='btn btn-xs btn-danger'>Delete</button>";
                            actions += "</form>";

                            return actions;
                        }
                    }
                ],
                ajax: '{{ route('dashboard.testimonials.json') }}'
            });
        });
    </script>
@endpush