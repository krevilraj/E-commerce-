@extends('backend.layouts.app')
@section('content')
<style>
    .alert-message {
        display: none;
    }
</style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>All Pages
            <small>({{ count($request) }})</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Message</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
 <div class="alert alert-success alert-message"></div>
                @include('backend.partials.message-success')
                @include('backend.partials.message-error')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All Message
                        </h3>
                        <button  class="pull-right btn btn-danger" href="#" data-toggle="modal" data-target="#requestModal" style="text-decoration:none" >Reply</button>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Phone</th>

                                <th>Message</th>

                                <th>Date</th>
                                <th class="sorting-false">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Phone</th>

                                <th>Message</th>

                                <th>Date</th>
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
    <div id="requestModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-body">

                    <div class="box box-default">
                        <div class="box-header">
                            <i class="fa fa-envelope"></i>

                            <h3 class="box-title">Quick Email</h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"
                                        data-toggle="tooltip"
                                        title="Remove">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <!-- /. tools -->
                        </div>
                        <div class="box-body">
                            <form>
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="Email to:">
                             <input type="hidden" name="id" id="id">

                                </div>
                                <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="form-control" placeholder="Subject">


                                </div>
                                <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                    <textarea class="form-control" name="message" id="message" rows="5" placeholder="Message">{{ old('message') }}</textarea>


                                </div>

                                <div class="box-footer clearfix">
                                    <button type="button" class="pull-right btn btn-danger btn-request" id="sendEmail">Send
                                        <i class="fa fa-arrow-circle-right"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).on("click", ".aaa", function () {
        var value= $(this).data('email');
        var value1= $(this).data('val');
        var value2= $(this).data('id');

        $(".modal-body #email").val(value);
        $(".modal-body #subject").val(value1);
        $(".modal-body #id").val(value2);

        // As pointed out in comments,
        // it is superfluous to have to manually call the modal.
        // $('#addBookDialog').modal('show');
    });
</script>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.datatable').DataTable({
 aaSorting: [[0, 'desc']],
                columnDefs: [
                    {"width": "10%", "targets": 3}
                ],
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {
                        data: 'name',name:'name'

                    },
                    {
                        data: 'email' ,
                    render: function (data, type, row) {
                        return '<a href="#" class="aaa"  data-toggle="modal" data-target="#requestModal" data-val='+ row.subject +' data-id='+ row.id+'   data-email='+ data +'>' + data + '</a>';
                    }
                    },
                    {data: 'subject', name: 'subject'},
                    {data: 'phone', name: 'phone'},

                    {data: 'message', name: 'message'},

                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'id',
                        orderable: false,
                        render: function (data, type, row) {
                            var tempDeleteUrl = "{{ route('dashboard.message.destroy', ':id') }}";

                            tempDeleteUrl = tempDeleteUrl.replace(':id', data);

                            var actions = '';
                            actions += "<form action='" + tempDeleteUrl + "' method='post'>";
                            actions += "<input type='hidden' name='_token' value='{{ csrf_token() }}'>";
                            actions += "<input type='hidden' name='_method' value='DELETE'>";
                            actions += "<button type='submit' class='btn btn-xs btn-danger'>Delete</button>";
                            actions += "</form>";

                            return actions;
                        }
                    }
                ],
                ajax: '{{ route('dashboard.message.json') }}'
            });
        });

//

        $(document).on("click", ".btn-review-delete", function (e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to delete?')) {
                return false;
            }

            var $this = $(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: $this.attr('href'),
                data: {_method: 'DELETE'},
                success: function (data) {
                    if (data.success) {
                        $this.prop('disabled', true);
                        $('.callout.callout-danger').fadeOut();
                        $('.callout.callout-success').fadeIn().html(data.message);
                    }
                },
                complete: function () {
                    window.setTimeout(function () {
                        location.reload()
                    }, 1000);
                }
            });
        });
    </script>
<script>
    $(document).on("click", ".btn-request", function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{route('dashboard.mail')}}",
            data: { email: $('#email').val(),subject: $('#subject').val(),message: $('#message').val(),id: $('#id').val(),type: 'contact'},

            beforeSend: function () {
      

                $this.button('loading');
            },
            success: function (data) {
           $('#requestModal').modal('hide');
    $('.alert-message.alert-danger').fadeOut();

                        var message = '<div><span><strong><i class="fa fa-thumbs-o-up"></i>Success! Message Sent</strong> ';
                        

                        $('.alert-message.alert-success').html(message).fadeIn().delay(3000).fadeOut('slow');


            },
            error: function (xhr, ajaxOptions, thrownError) {
                var errorsHolder = '';
                errorsHolder += '<ul>';

                var err = eval("(" + xhr.responseText + ")");
                $.each(err.errors, function (key, value) {
                    errorsHolder += '<li>' + value + '</li>';
                });;



                errorsHolder += '</ul>';

                $this.closest('form').find('.alert-account.alert-danger').fadeIn().html('Please fill all the Form');
//                $this.closest('form').find('.alert-account.alert-danger').fadeIn().html(errorsHolder);

            },
            complete: function () {
                $this.button('reset');
            }
        });

    });

</script>

<script>
    $(document).on("click", ".btn-reply", function (e) {
        e.preventDefault();
        $('#requestModal').modal();
    });
</script>
@endpush