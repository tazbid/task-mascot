@extends('admin.layouts.master')
@section('breadcrumb')
<ol class="breadcrumb float-sm-left">
    <li class="breadcrumb-item"><a href="{{ url('admin', []) }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="javascript:void(0)">Access-Control</a></li>
    <li class="breadcrumb-item active">Users</li>
</ol>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="d-inline-block">User List</h3>
        <div class="float-right">
            {{-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">Test</button> --}}
            {{-- <a onclick="event.preventDefault(); document.getElementById('download-form').submit();"
                href="javascript:void(0);" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i>
                Export</a> --}}
            <form id="download-form" action="{{ url('admin/access-control/users/download') }}" method="POST"
                style="display: none;">
                @csrf
            </form>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table id="user-access-table" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date of birth</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date of birth</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<script>
    $(document).ready(() => {

        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: 'Choose Roles'
        });
        $('#user-access-table').dataTable({
            "orderCellsTop": true,
            "fixedHeader": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('/admin/users') }}",
                "type": "POST",
                // "data": data

            },
            columns: [{
                    "data": 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'dob',
                    name: 'dob'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    /**
     *@name deleteUser
     *@description send request for deleteing a user
     *@parameter id
     *@return  alert
     */
    function deleteUser(id) {
        swal({
                title: "Are you sure to Delete this User?",
                // text: "You will not be able to recover this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger btn-lg",
                cancelButtonClass: "btn-secondary btn-lg",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{ url('admin/access-control/user/delete') }}",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function (result) {
                            if (typeof result.errors !== 'undefined') {
                                swal("Error!", "Please Try Again later!",
                                    "warning");
                            } else {

                                swal(result, "Operation Successful", "success");
                                //reload(1000);
                                refreshDatatable("user-access-table");
                            }

                        },
                        error: function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.Verify Network.';
                                swal("Error!", msg, "warning");
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                                swal("Error!", msg, "warning");
                            } else if (jqXHR.status == 413) {
                                msg = 'Request entity too large. [413]';
                                swal("Error!", msg, "warning");
                            } else if (jqXHR.status == 419) {
                                msg = 'CSRF error or Unknown Status [419]';
                                swal("Error!", msg, "warning");
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                                swal("Error!", msg, "warning");
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                                swal("Error!", msg, "warning");
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                                swal("Error!", msg, "warning");
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                                swal("Error!", msg, "warning");
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                                swal("Error!", msg, "warning");
                            }

                        }
                    });


                } else {
                    swal("Cancelled", "Your canceled this operation", "warning");
                }
            });
    }

</script>
@endsection
