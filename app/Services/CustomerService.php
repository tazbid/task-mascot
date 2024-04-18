<?php

namespace App\Services;

use App\Models\User;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerService {
    use UserTrait;

    /**
     * @name customerUpdateAjax
     * @role update customers basic information record to database
     * @param Request $request
     * @return  Json response
     *
     */
    public function customerUpdateAjax(Request $request, User $user) {
        try{
            $first_name     = $request->first_name;
            $last_name      = $request->last_name;
            $full_name      = $first_name . " " . $last_name;
            $attributeNames = array(
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'full_name'  => $full_name,
                'email'      => $request->email,
                'address'    => $request->address,
                'dob'        => $request->dob,
                'phone'      => $request->phone,
            );

            if ($request->hasFile('avatar')):
                $user->addMedia($request->avatar)->toMediaCollection($this->userProfileImageCollection);
            endif;

            if ($request->hasFile('id_verification')):
                $user->addMedia($request->id_verification)->toMediaCollection($this->userIdVerificationImageCollection);
            endif;

            $activity = $user->update($attributeNames);
            if ($activity) {
                return response()->json("Success", Response::HTTP_OK);
            } else {
                return response()->json(array('errors' => "Something Went Wrong"), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @name customerUpdatePasswordAjax
     * @role update customers basic information record to database
     * @param Request $request
     * @return  Json response
     *
     */
    public function customerUpdatePasswordAjax(Request $request, User $user) {
        try{
            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(array('errors' => "Old Password is Incorrect"), Response::HTTP_BAD_REQUEST);
            }
            $attributeNames = array(
                'password' => bcrypt($request->password),
            );
            $activity = $user->update($attributeNames);
            if ($activity) {
                return response()->json("Success", Response::HTTP_OK);
            } else {
                return response()->json(array('errors' => "Something Went Wrong"), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @name verifyCode
     * @role Verify Code
     * @param Request $request
     * @return  Json response
     *
     */
    public function verifyCode(Request $request) {
        try {
            $email = Auth::user()->email;
            $user = User::where('verification_code', $request->code)
            ->where('email', '=', $email)
            ->first();

            if ($user && Auth::user()->id == $user->id) {
                $user->verification_status = $this->userActive;
                $user->verification_code = null;
                $user->save();
                return response()->json("Success", Response::HTTP_OK);
            } else {
                return response()->json(array('errors' => "Invalid Code"), Response::HTTP_FORBIDDEN);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
