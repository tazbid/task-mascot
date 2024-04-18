<?php

namespace App\Http\Controllers\admin\customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CustomerService;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller {
    use UserTrait;

    protected $customerService;

    public function __construct(CustomerService $customerService) {
        $this->customerService = $customerService;
    }

    /**
     * @name adminProfileView
     * @role Admin Profile View
     * @return  view with compact array
     *
     */
    public function adminProfileView() {
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
        $id        = $request->id;
        $user      = User::findOrFail($id);

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
            return $this->customerService->customerUpdateAjax($request, $user);
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
            return $this->customerService->customerUpdatePasswordAjax($request, $user);
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
            return $this->customerService->verifyCode($request);
        }
    }
}
