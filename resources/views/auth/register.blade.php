@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div id="register-errors">

                        </div>

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" onchange="checkEmail()" >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date of birth') }}</label>

                            <div class="col-md-6">
                                <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" required autocomplete="dob" autofocus>

                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_verification" class="col-md-4 col-form-label text-md-right">{{ __('ID Verification') }}</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control @error('id_verification') is-invalid @enderror" id="id_verification" name="id_verification" required autocomplete="id_verification" autofocus accept="image/*">

                                @error('id_verification')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function checkEmail() {
        //csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var email = $('#email').val();
        $.ajax({
            url: '/check-email',
            type: 'POST',
            data: {
                email: email
            },
            success: function(response) {
                //make email field valid
                $('#email').removeClass('is-invalid');
                $('#email').addClass('is-valid');

                //remove email error message
                $('#email').next().remove();
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
                } else if (jqXHR.status == 403) {
                    //make email field invalid
                    $('#email').removeClass('is-valid');
                    $('#email').addClass('is-invalid');

                    //email error message
                    $('#email').next().remove();
                    $('#email').after('<span class="invalid-feedback" role="alert"><strong>Email already exists</strong></span>');
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

                    $("#register-errors").append(errorMarkup);
                    //errorStyleInit();

                    btnLoadEnd("btn-login");
                    //$("#sign-up-btn").click();
                }

            }
        });
    }

    // //make id_verification binary
    // $('#id_verification').on('change', function() {
    //     console.log('here');
    //     var file = this.files[0];
    //     var reader = new FileReader();
    //     reader.onload = function(e) {
    //         var data = e.target.result;
    //         var binary = '';
    //         var bytes = new Uint8Array(data);
    //         var length = bytes.byteLength;
    //         for (var i = 0; i < length; i++) {
    //             binary += String.fromCharCode(bytes[i]);
    //         }
    //         $('#id_verification').val(binary);
    //     };
    //     reader.readAsArrayBuffer(file);
    // });
</script>
