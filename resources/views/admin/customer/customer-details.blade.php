@extends('admin.layouts.master')
@section('breadcrumb')
<ol class="breadcrumb float-sm-left">
    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard', []) }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ url('admin/customers', []) }}">Customers</a></li>
    <li class="breadcrumb-item active">{{$user->name}}</li>
</ol>
@endsection
@section('content')

<div class="container-fluid" id="content-div">
    <div class="row">
        <div class="col-md-3">
            <div id="main-info-div">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            {{-- @dd($user->getFirstMedia($userAvatarCollectionName)->getUrl()) --}}
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{$userAvatarCollectionName !== null ? asset($user->getFirstMedia($userAvatarCollectionName)->getUrl()) : asset('upload/img/avatar/default-avatar.png')}}"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{$user->full_name}}</h3>
                        <p class="text-muted text-center">{{$user->email}}</p>

                        <p class="text-muted text-center">
                            @foreach ($roles as $role)
                            <span class="badge badge-primary">{{$role}}</span>
                            @endforeach
                        </p>
                        <p class="text-muted text-center">
                            @if ($user->status == 1)
                            <span class="badge badge-success">Active</span>
                            @else
                            <span class="badge badge-secondary">Deactive</span>
                            @endif
                        </p>

                        @if ($userAvatarCollectionName !== null)
                        <div class="text-center">
                            <a href="{{ url('/download/avatar', ['id' => $user->id]) }}"
                                class="btn btn-primary btn-sm" download>
                                <i class="fas fa-download"></i> Download Avatar
                            </a>
                        </div>
                        @endif

                        @if ($userIdVerificationCollectionName !== null)
                        <div class="text-center" style="margin-top: 5px;">
                            <a href="{{ url('/download/verification', ['id' => $user->id]) }}"
                                class="btn btn-primary btn-sm" download>
                                <i class="fas fa-download"></i> Download ID Verification
                            </a>
                        </div>
                        @endif

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>


            <!-- About Me Box -->
            <div class="card card-primary" id="billing-info-div">
                {{-- <div class="card-header">
                    <h3 class="card-title">About</h3>
                </div> --}}
                <!-- /.card-header -->
                {{-- <div class="card-body">
                    @if ($user->details)
                    <strong><i class="fas fa-signature"></i> First Name</strong>

                    <p class="text-muted">{{$user->details->first_name ? $user->details->first_name : "Not Set"}}</p>
                    <hr>

                    <strong><i class="fas fa-signature"></i> Last name</strong>


                    <p class="text-muted">{{$user->details->last_name ? $user->details->last_name : "Not Set"}}</p>

                    <hr>

                    <strong><i class="fas fa-phone"></i> Phone</strong>

                    <p class="text-muted">{{$user->details->phone ? $user->details->phone : "Not Set"}}</p>

                    <hr>

                    <strong><i class="fas fa-book mr-1"></i> Company</strong>

                    <p class="text-muted">{{$user->details->company ? $user->details->company : "Not Set"}}</p>

                    <hr>

                    <strong><i class="fas fa-globe"></i> Country</strong>

                    <p class="text-muted">{{$user->details->country ? $user->details->country : "Not Set"}}</p>
                    <hr>

                    <strong><i class="fas fa-city"></i> City</strong>

                    <p class="text-muted">{{$user->details->city ? $user->details->city : "Not Set"}}</p>
                    <hr>

                    <strong><i class="fas fa-address-card"></i> Address</strong>

                    <p class="text-muted">{{$user->details->address_one ? $user->details->address_one : "Not Set"}}</p>
                    @else

                    <strong><i class="fas fa-signature"></i> First Name</strong>

                    <p class="text-muted">Not Set</p>
                    <hr>

                    <strong><i class="fas fa-signature"></i> Last name</strong>


                    <p class="text-muted">Not Set</p>

                    <hr>

                    <strong><i class="fas fa-phone"></i> Phone</strong>

                    <p class="text-muted">Not Set</p>

                    <hr>

                    <strong><i class="fas fa-book mr-1"></i> Company</strong>

                    <p class="text-muted">Not Set</p>

                    <hr>

                    <strong><i class="fas fa-globe"></i> Country</strong>

                    <p class="text-muted">Not Set</p>
                    <hr>

                    <strong><i class="fas fa-city"></i> City</strong>

                    <p class="text-muted">Not Set</p>
                    <hr>

                    <strong><i class="fas fa-address-card"></i> Address</strong>

                    <p class="text-muted">Not Set</p>
                    @endif
                    <hr>
                </div> --}}
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        {{-- <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a>
                        </li> --}}
                        {{-- <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Subscription</a>
                        </li> --}}
                        {{-- <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Subscription
                                History</a></li> --}}

                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="settings">
                            <h4 class="">Basic Informations</h4>
                            <hr>
                            <form id="userBasicInfoForm" class="form-horizontal">
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">First Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="first_name" placeholder="Name"
                                            value="{{$user->first_name}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Last Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="last_name" placeholder="Name"
                                            value="{{$user->last_name}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" placeholder="Email"
                                            value="{{$user->email}}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="address" placeholder="Address"
                                            value="{{$user->address}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputDob" class="col-sm-2 col-form-label">Date of birth</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" name="dob"
                                            value="{{$user->dob}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="phone" minlength="11" maxlength="11"
                                            value="{{$user->phone}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="avatar" class="col-sm-2 col-form-label">Avatar</label>
                                    <div class="col-sm-10">
                                        <input type="file" onchange="imageValidateAndPreview (this,'previewForAvatar')"
                                            class="form-control" name="avatar" placeholder="" accept="image/*">
                                        <br>
                                        <img id="previewForAvatar" width="85" height="85" style="display:none" src="" alt="">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="id_verification" class="col-sm-2 col-form-label">ID Verification</label>
                                    <div class="col-sm-10">
                                        <input type="file" onchange="imageValidateAndPreview (this,'previewForId')"
                                            class="form-control" name="id_verification" placeholder="" accept="image/*">
                                        <br>
                                        <img id="previewForId" width="85" height="85" style="display:none" src="" alt="">

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button id="btn-user-bill" type="submit" class="btn btn-success"
                                            data-loading-text="<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Saving..."
                                            data-normal-text="Save changes">
                                            <span class="ui-button-text">Save changes</span>
                                        </button>

                                    </div>
                                </div>
                            </form>
                            <hr>
                            <h4 class="">Reset Password</h4>
                            <hr>
                            <form id="userResetPasswordForm" class="form-horizontal">
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="Password" required minlength="6">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password_confirmation"
                                            placeholder="Conform Password" minlength="6" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button id="btn-user-pass" type="submit" class="btn btn-danger"
                                            data-loading-text="<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Saving..."
                                            data-normal-text="Reset Password">
                                            <span class="ui-button-text">Reset Password</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                        </div>
                        <!-- /.tab-pane -->

                        <!-- /.tab-pane -->


                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>

<script>
    $(document).ready(function () {
        initUserBasicForm();
        initUserResetPassForm();
    });

    function initUserBasicForm() {
        /**
         * @name form onsubmit
         * @description override the default form submission and submit the form manually.
         *              also validate with .validate() method from jquery validation
         * @parameter formid
         * @return
         */
        $('#userBasicInfoForm').submit(function (e) {
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
                    url: "{{ url('customer/update') }}",
                    method: "POST",
                    data: formData,
                    enctype: 'multipart/form-data',
                    processData: false,
                    cache: false,
                    contentType: false,
                    timeout: 600000,
                    beforeSend: function () {
                        btnLoadStart("btn-user-basic");
                    },
                    complete: function () {
                        btnLoadEnd("btn-user-basic");
                    },
                    success: function (result) {
                        if (typeof result.errors !== 'undefined') {
                            // the variable is defined

                            //add jquery validation error
                            var validator = $(form).validate();
                            var objErrors = {};
                            $.each(result.errors, function (key, val) {
                                objErrors[key] = val;
                            });
                            validator.showErrors(objErrors);
                            validator.focusInvalid();

                            //console.log(result.errors);
                            //toastr error
                            // $.each(result.errors, function (key, val) {
                            //     toastr.error(
                            //         val,
                            //         'Error!', {
                            //             timeOut: 8000,
                            //             closeButton: true,
                            //             progressBar: true,
                            //             positionClass: "toast-bottom-right",
                            //         });


                            // });

                            btnLoadEnd("btn-user-basic");
                        } else if (typeof result.dbErrors !== 'undefined') {
                            swal("Error!",
                                "Database Error!Please Try Again later!",
                                "warning");
                            btnLoadEnd("btn-user-basic");
                        } else {
                            //$(form).trigger('reset');
                            $(form).find('.is-valid').removeClass("is-valid");
                            btnLoadEnd("btn-user-basic");
                            toastr.success(
                                'Data updated Successfully.',
                                'Success!', {
                                    timeOut: 8000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });

                            loadElement("main-info-div");

                            // reload(1000);
                            //redirect(result, 100);

                        }

                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.Verify Network.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-basic");
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-basic");
                        } else if (jqXHR.status == 413) {
                            msg = 'Request entity too large. [413]';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-basic");
                        } else if (jqXHR.status == 419) {
                            msg = 'CSRF error or Unknown Status [419]';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-basic");
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-basic");
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-basic");
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-basic");
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-basic");
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR
                                .responseText;
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-basic");
                        }

                    }
                });

                //console.log("validation success");
            }
        });
    }

    function initUserResetPassForm() {
        /**
         * @name form onsubmit
         * @description override the default form submission and submit the form manually.
         *              also validate with .validate() method from jquery validation
         * @parameter formid
         * @return
         */
        $('#userResetPasswordForm').submit(function (e) {
            e.preventDefault();
        }).validate({
            rules: {
                password: {
                    minlength: 6
                },
                password_confirmation: {
                    minlength: 6,
                    equalTo: "#password"
                }
            },
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
                    url: "{{ url('customer/update/password') }}",
                    method: "POST",
                    data: formData,
                    enctype: 'multipart/form-data',
                    processData: false,
                    cache: false,
                    contentType: false,
                    timeout: 600000,
                    beforeSend: function () {
                        btnLoadStart("btn-user-pass");
                    },
                    complete: function () {
                        btnLoadEnd("btn-user-pass");
                    },
                    success: function (result) {
                        if (typeof result.errors !== 'undefined') {
                            // the variable is defined

                            //add jquery validation error
                            var validator = $(form).validate();
                            var objErrors = {};
                            $.each(result.errors, function (key, val) {
                                objErrors[key] = val;
                            });
                            validator.showErrors(objErrors);
                            validator.focusInvalid();

                            //console.log(result.errors);
                            //toastr error
                            // $.each(result.errors, function (key, val) {
                            //     toastr.error(
                            //         val,
                            //         'Error!', {
                            //             timeOut: 8000,
                            //             closeButton: true,
                            //             progressBar: true,
                            //             positionClass: "toast-bottom-right",
                            //         });


                            // });

                            btnLoadEnd("btn-user-pass");
                        } else if (typeof result.dbErrors !== 'undefined') {
                            swal("Error!",
                                "Database Error!Please Try Again later!",
                                "warning");
                            btnLoadEnd("btn-user-pass");
                        } else {
                            $(form).trigger('reset');
                            $(form).find('.is-valid').removeClass("is-valid");
                            btnLoadEnd("btn-user-pass");
                            toastr.success(
                                'Data updated Successfully.',
                                'Success!', {
                                    timeOut: 8000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });

                            // loadElement("main-info-div");

                            // reload(1000);
                            //redirect(result, 100);

                        }

                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.Verify Network.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-pass");
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-pass");
                        } else if (jqXHR.status == 413) {
                            msg = 'Request entity too large. [413]';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-pass");
                        } else if (jqXHR.status == 419) {
                            msg = 'CSRF error or Unknown Status [419]';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-pass");
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-pass");
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-pass");
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-pass");
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-pass");
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR
                                .responseText;
                            swal("Error!", msg, "warning");
                            btnLoadEnd("btn-user-pass");
                        }

                    }
                });

                //console.log("validation success");
            }
        });
    }

    /**
    *@name imageValidateAndPreview
    *@description validate image input & populate img tag
    *@parameter input instance event, preview element id,jquery validation
    *@return
    */
    function imageValidateAndPreview(data, preview_id, jquery_validation = false) {

    var id = $(data).attr('id');
    if (data.files && data.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {

            $('#' + preview_id).attr('src', e.target.result);
            $("#" + preview_id).show();
        };
        reader.readAsDataURL(data.files[0]);
    }

    var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
    if ($.inArray($(data).val().split('.').pop().toLowerCase(),
        fileExtension) == -1) {
        // alert("Only '.jpeg','.jpg', '.png', '.gif' formats are allowed.");
        //alertify.warning("Only '.jpeg','.jpg', '.png', '.gif' formats are allowed.");
        toastr.error(
            "Only jpeg , jpg , png , gif formats are allowed.",
            'Error!', {
            timeOut: 8000,
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-right",
        });

        $("#" + id).val('');
        $('#' + preview_id).attr('src', '');
        $('#' + preview_id).hide();
    }

    //jquery validation
    if (jquery_validation === true) {
        $("#" + id).valid();
    }


    }

    /**
     *@name deleteLog
     *@description send request for deleteing the log
     *@parameter id
     *@return  alert
     */
    function deleteLog(id) {
        swal({
                title: "Are you sure to Move This Log To Trash?",
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
                        url: "{{ url('admin/user-log/delete') }}",
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
                                //refreshDatatable("user-log-table");
                                redirect("{{url('admin/user-logs')}}", 1000);
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
