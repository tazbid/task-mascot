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
        <h3 class="d-inline-block">User Access Control</h3>
        <div class="float-right">
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
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Created At</th>
                                <th scope="col" style="width: 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Full Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Created At</th>
                                <th scope="col" style="width: 15%">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

{{-- assign role modal --}}
<div class="modal fade" id="modal-role">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Assign Role to <span id="user-name-head"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form id="userRoleAssignForm">
                        <input type="hidden" id="user-id" name="id" value="">
                        <label>Choose Roles for <span id="user-name"></span></label>
                        <select class="select2bs4 form-control" multiple="multiple" name="roles[]" required
                            data-placeholder="Choose Roles" style="width: 100%;">
                            @foreach ($roles as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>


                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn-user-role" type="submit" class="btn btn-primary"
                    data-loading-text="<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Saving..."
                    data-normal-text="Save changes">
                    <span class="ui-button-text">Save changes</span>
                </button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
                "url": "{{ url('/admin/access-control/users') }}",
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

                // {
                //     data: 'last_login_ip',
                //     name: 'last_login_ip'
                // },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'roles',
                    name: 'roles'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
            ]
        });

        /**
         * @name form onsubmit
         * @description override the default form submission and submit the form manually.
         *              also validate with .validate() method from jquery validation
         * @parameter formid
         * @return
         */
        $('#userRoleAssignForm').submit(function (e) {
            e.preventDefault();
        }).validate({
            highlight: function (element) {
                jQuery(element).closest('.form-control').addClass('is-invalid');
            },
            unhighlight: function (element) {
                jQuery(element).closest('.form-control').removeClass('is-invalid');
                jQuery(element).closest('.form-control').addClass('is-valid');
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group-prepend').length) {
                    $(element).siblings(".invalid-feedback").append(error);
                    //error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {


                var formData = new FormData(form);
                $.ajax({
                    url: "{{ url('admin/access-control/user/setrole') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        btnLoadStart("btn-user-role");
                    },
                    complete: function () {
                        btnLoadEnd("btn-user-role");
                    },
                    success: function (result) {
                        if (typeof result.errors !== 'undefined') {
                            // the variable is defined

                            //add jquery validation error
                            // var validator = $(form).validate();
                            // var objErrors = {};
                            // $.each(result.errors, function (key, val) {
                            //     objErrors[key] = val;
                            // });
                            // validator.showErrors(objErrors);
                            // validator.focusInvalid();

                            //console.log(result.errors);
                            //toastr error
                            $.each(result.errors, function (key, val) {
                                toastr.error(
                                    val,
                                    'Error!', {
                                        timeOut: 8000,
                                        closeButton: true,
                                        progressBar: true,
                                        positionClass: "toast-bottom-right",
                                    });


                            });

                            btnLoadEnd("btn-user-role");
                        } else if (typeof result.dbErrors !== 'undefined') {
                            swal("Error!",
                                "Database Error!Please Try Again later!",
                                "warning");
                            btnLoadEnd("btn-user-role");
                        } else {
                            $(form).trigger('reset');
                            btnLoadEnd("btn-user-role");
                            toastr.success(
                                'Role Assigned Successfully.',
                                'Success!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            $("#modal-role").modal('hide');
                            refreshDatatable("user-access-table");



                        }

                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.Verify Network.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-role");
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-role");
                        } else if (jqXHR.status == 413) {
                            msg = 'Request entity too large. [413]';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-role");
                        } else if (jqXHR.status == 419) {
                            msg = 'CSRF error or Unknown Status [419]';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-role");
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-role");
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-role");
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-role");
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-role");
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR
                                .responseText;
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-role");
                        }

                    }
                });

                //console.log("validation success");
            }
        });


    });
    /**
     *@name manageRole
     *@description prepare role management modal
     *@parameter id
     *@return
     */
    function manageRole(id) {
        //console.log(id);
        $.ajax({
            url: "{{ url('admin/access-control/user') }}",
            method: "POST",
            data: {
                id: id
            },
            success: function (result) {
                if (typeof result.errors !== 'undefined') {
                    swal("Error!", "Please Try Again later!",
                        "warning");
                } else {
                    // console.log(result);
                    $('.select2bs4').select2({
                        theme: 'bootstrap4'
                    }).val(result.roles).trigger("change");
                    $("#user-name-head").text(result.name);
                    $("#user-name").text(result.name);
                    $("#user-id").val(result.id);

                    $("#modal-role").modal('show');


                    //refreshDatatable("user-access-table");
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

        // $('.select2bs4').select2({
        //     theme: 'bootstrap4'
        // }).val(PRESELECTED_FRUITS).trigger("change");
    }
    /**
     *@name deactiveUser
     *@description send request for deactivating a user
     *@parameter id
     *@return  alert
     */
    function deactiveUser(id) {
        swal({
                title: "Are you sure to Deactivate This User?",
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
                        url: "{{ url('admin/access-control/user/deactivate') }}",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function (result) {
                            if (typeof result.errors !== 'undefined') {
                                swal("Error!", "Please Try Again later!", "warning");
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

    /**
     *@name activeUser
     *@description send request for activating a user
     *@parameter id
     *@return  alert
     */
    function activeUser(id) {
        swal({
                title: "Are you sure to Activate This User?",
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
                        url: "{{ url('admin/access-control/user/activate') }}",
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
