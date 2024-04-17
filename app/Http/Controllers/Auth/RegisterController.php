<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Traits\UserTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, UserTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:11', 'min:11', 'unique:users,phone'],
            'dob' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'id_verification' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'full_name' => $data['first_name'] . ' ' . $data['last_name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'dob' => $data['dob'],
            'status' => 1, // 1 means 'active' and 0 means 'inactive
            'verification_status' => 1, // 0 means 'not verified' and 1 means 'verified'
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (isset($data['id_verification'])):

            //upload image
            // $slug = Str::slug($request->name);
            // $file = $request->file('avatar');
            // $name = $file->getClientOriginalName();
            // $EXT  = $file->getClientOriginalExtension();
            // $imageFileName =  $slug ."-". uniqid("avatar");
            // $imageFileName = $imageFileName . "." . $EXT;
            // $attachment_path = $this->userAvatarPath . '/' . $imageFileName;
            // $file->move($this->userAvatarPath, $imageFileName);

            // //delete exisiting
            // if (File::exists($user->avatar_path)) {
            //     File::delete($user->avatar_path);
            // }

            // //update array
            // $attributeNames['avatar_path'] = $attachment_path;
            $user->addMedia($data['id_verification'])->toMediaCollection($this->userIdVerificationImageCollection);

        endif;

        $user->assignRole('user');

        return $user;
    }
}
