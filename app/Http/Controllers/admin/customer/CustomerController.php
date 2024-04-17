<?php

namespace App\Http\Controllers\admin\customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller {
    use UserTrait;
    /**
     * @name adminProfileView
     * @role Admin Profile View
     * @param Request $request
     * @return  view with compact array
     *
     */
    public function adminProfileView(Request $request) {
        $id   = Auth::user()->id;
        $user = User::where('id', $id)->with('media')->first();

        $data = [
            'user'                     => $user,
            'roles'                    => $user->getRoleNames(),
            'userAvatarCollectionName' => $user->getFirstMedia($this->userProfileImageCollection) ? $this->userProfileImageCollection : null,
            'userIdVerificationCollectionName' => $user->getFirstMedia($this->userIdVerificationImageCollection) ? $this->userIdVerificationImageCollection : null,
        ];

        return view('admin.customer.customer-details', $data);
    }

    /**
     * @name customerUpdateAjax
     * @role update customers basic information record to database
     * @param Request $request
     * @return  Json response
     *
     */

    public function customerUpdateAjax(Request $request) {
        $id   = $request->id;
        $user = User::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|min:3',
                'last_name'  => 'required|min:3',
                'email'      => 'required|email|unique:users,email,' . $user->id . ',id,deleted_at,NULL',
                'address'    => 'nullable|string',
                'dob'        => 'nullable|date',
                'phone'      => 'nullable|string',
                'avatar'     => 'image|mimes:jpeg,png,jpg,gif|max:1024',
                'id_verification' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            ],
            [
                'avatar.max' => 'Image Size Must Be Less Than 1 MB',
                'id_verification.max' => 'Image Size Must Be Less Than 2 MB',
            ]
        );

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
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
        }
    }

    /**
     * @name customerUpdatePasswordAjax
     * @role update customers basic information record to database
     * @param Request $request
     * @return  Json response
     *
     */
    public function customerUpdatePasswordAjax(Request $request) {
        $id        = $request->id;
        $user      = User::findOrFail($id);
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|min:6|string|confirmed',

            ],
        );

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $attributeNames = array(
                'password' => bcrypt($request->password),
            );
            $activity = $user->update($attributeNames);
            if ($activity) {
                return response()->json("Success", Response::HTTP_OK);
            } else {
                return response()->json(array('errors' => "Something Went Wrong"), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * @name downloadAvatar
     * @role Download Avatar
     * @param $id
     * @return download
     *
     */
    public function downloadAvatar(int $id) {
        $user = User::find($id);
        $path = $user->getFirstMedia($this->userProfileImageCollection)->getPath();
        return response()->download($path);
    }

    /**
     * @name downloadVerification
     * @role Download Verification
     * @param $id
     * @return download
     *
     */
    public function downloadVerification(int $id) {
        $user = User::find($id);
        $path = $user->getFirstMedia($this->userIdVerificationImageCollection)->getPath();
        return response()->download($path);
    }

    /**
     * @name verifyCode
     * @role Verify Code
     * @param Request $request
     * @return  Json response
     *
     */
    public function verifyCode(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'required|numeric',
            ],
        );

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
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
        }
    }
}
