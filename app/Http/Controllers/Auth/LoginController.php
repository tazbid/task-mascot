<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\Employee\SendEmployeeMailJob;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Traits\UserTrait;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, UserTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/verify';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                $this->username() => 'required|email',
                'password' => 'required|string',
            ],
        );
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }


        if (User::where('email', $request->email)->exists()) {
            # code...
            $user = User::where('email', $request->email)->first();
            $isActive = $user->status;

            if ($isActive == $this->userActive) {
                $remember = $request->has('remember') ? true : false;
                // dd($remember);
                if ($this->attemptLogin($request, $remember)) {
                    return $this->sendLoginResponse($request);
                }
            } else {
                return response()->json(array(
                    'errors' => "Account is not active",
                    'status' => 403
                ), 403);
            }
        }
        // if ($this->attemptLogin($request)) {
        //     return $this->sendLoginResponse($request);
        // }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        //activity logging
        Log::info("User Login Failed!email:" . $request->email);
        Log::notice("User Login Failed!email:" . $request->email);
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($request->ajax()) {
            $code = rand(100000, 999999);


            $data = array(
                'code' => $code,
            );

            if($user->email  == $this->adminSeedEmail || $user->email == $this->superadminSeedEmail){
                $user->verification_status = $this->userActive;
                $user->verification_code = $code;
                $user->save();
                $intended = '/';
            } else {
                $user->verification_status = $this->userDeactive;
                $user->verification_code = $code;
                $user->save();
                SendEmployeeMailJob::dispatch($user->email, $data, 'Verification Code to Login');
                $intended = '/verify';
            }

            return response()->json([
                'auth' => auth()->check(),
                'user' => $user,
                'intended' => $intended,
            ]);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        //activity logging
        Log::info("User Logout : " . Auth::user()->name . "(ID:" . Auth::user()->id . ") Successfull");
        Log::notice("User Logout : " . Auth::user()->name . "(ID:" . Auth::user()->id . ") Successfull");
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    //send verification code
    public function sendVerificationCode($email, $code)
    {
        //send email
        $data = array(
            'code' => $code,
        );
        $this->sendMail($email, 'Verification Code', 'mail.verificationCode', $data);
    }

    //send mail
    public function sendMail($email, $subject, $view, $data)
    {
        Mail::send($view, $data, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
