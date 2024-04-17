

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bit Mascot</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- toastr -->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/toastr/toastr.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin-assets/dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>

    <script src="{{asset('js/basicFunctions.js')}}"></script>
    <script src="{{asset('js/ajaxSetup.js')}}"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{url('/')}}"><b>Bit Mascot</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form id="loginForm">
                    @csrf
                    <div>
                        @if (session('status'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        {{-- <div class="alert success">
                            <span class="closebtn">&times;</span>
                            {{ session('status') }}
                    </div> --}}
                    @endif
                    </div>
                    <div id="login-errors">

                    </div>
                    <div class="input-group mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-12">
                            {{-- <button type="submit" class="btn btn-primary btn-block">Sign In</button> --}}
                            <button type="submit" class="btn btn-primary btn-block" id="btn-login"
                                data-loading-text='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                                data-normal-text="Login">
                                <span class="ui-button-text">Login</span>
                            </button>
                            <p>Don't have an account? <a href="/register">Sign up</a>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            {{-- <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div> --}}
            <!-- /.social-auth-links -->

            {{-- <p class="mb-1">
                <a href="forgot-password.html">I forgot my password</a>
            </p> --}}
            {{-- <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p> --}}
        </div>
        <!-- /.login-card-body -->
    </div>
    </div>
    <!-- /.login-box -->


    <!-- Bootstrap 4 -->
    <script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('admin-assets/dist/js/adminlte.min.js')}}"></script>

    <script src="{{asset('admin-assets/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin-assets/plugins/jquery-validation/additional-methods.min.js')}}"></script>

    <script src="{{asset('admin-assets/plugins/toastr/toastr.min.js')}}"></script>


    <script>
        $(document).ready(() => {


            /**
             * @name form onsubmit
             * @description override the default form submission and submit the form manually.
             *              also validate with .validate() method from jquery validation
             * @parameter formid
             * @return
             */
            $('#loginForm').submit(function (e) {
                e.preventDefault();

                var formData = new FormData($('#loginForm')[0]);
                $.ajax({
                    url: "{{ url('login') }}",
                    method: "POST",
                    data: formData,
                    enctype: 'multipart/form-data',
                    processData: false,
                    cache: false,
                    contentType: false,
                    timeout: 600000,
                    beforeSend: function () {
                        btnLoadStart("btn-login");
                    },
                    complete: function () {
                        btnLoadEnd("btn-login");
                    },
                    success: function (result) {
                        if (result.auth) {
                            toastr.success(
                                "Login Successful!",
                                'Success!', {
                                    timeOut: 2000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-top-center",
                                });

                            redirect(result.intended, 100);
                        }

                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.Verify Network.';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });

                            btnLoadEnd("btn-login");
                        } else if (jqXHR.status == 404) {
                            console.log(jqXHR);
                            msg = 'Requested page not found. [404]';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (jqXHR.status == 403) {
                            msg = 'Account not activated. Please contact with admin. [403]';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (jqXHR.status == 413) {
                            msg = 'Request entity too large. [413]';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (jqXHR.status == 419) {
                            msg = 'CSRF error or Unknown Status [419]';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                            toastr.warning(
                                msg,
                                'Error!', {
                                    timeOut: 5000,
                                    closeButton: true,
                                    progressBar: true,
                                    positionClass: "toast-bottom-right",
                                });
                            btnLoadEnd("btn-login");
                        } else {
                            var errorMarkup = '';

                            $.each(jqXHR.responseJSON.errors, function (key, val) {


                                errorMarkup +=
                                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                errorMarkup +=  val;
                                errorMarkup +=
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                                errorMarkup +=
                                    '<span aria-hidden="true">&times;</span></button>';

                                errorMarkup += '</div>';

                            });

                            $("#login-errors").append(errorMarkup);
                            //errorStyleInit();

                            btnLoadEnd("btn-login");
                            //$("#sign-up-btn").click();
                        }

                    }
                });



            });

        });

    </script>

</body>




</html>
