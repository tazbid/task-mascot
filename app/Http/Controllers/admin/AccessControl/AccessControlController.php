<?php

namespace App\Http\Controllers\admin\AccessControl;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AccessControlService;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class AccessControlController extends Controller {
    use UserTrait;

    protected $accessControlService;

    /**
     * @name __construct
     * @role constructor
     * @return  void
     *
     */
    public function __construct(AccessControlService $accessControlService) {
        $this->accessControlService = $accessControlService;
    }

    /**
     * @name rolesView
     * @role explains the roles to user
     * @param
     * @return  view
     *
     */

    public function rolesView() {
        return view('admin.accessControl.roles');
    }

    /**
     * @name usersView
     * @role explains the roles to user
     * @param
     * @return  view with compact array
     *
     */

    public function usersView() {
        $roles = Role::all();

        $data = [
            'roles' => $roles,
        ];
        return view('admin.accessControl.user-access-control', $data);
    }

    /**
     * @name usersDetailsAjax
     * @role fetch user response from database
     * @param Request user id
     * @return  Json response
     *
     */
    public function usersDetailsAjax(Request $request) {
        $id    = $request->id;
        $user  = User::findOrFail($id);
        $name  = $user->name;
        $roles = $user->roles->pluck('name');

        $data = [
            'id'    => $user->id,
            'name'  => $name,
            'roles' => $roles,
        ];

        return response()->json($data);
    }

    /**
     * @name usersViewDatatableAjax
     * @role send datatable json for showing users
     * @return  Datatable json
     *
     */
    public function usersViewDatatableAjax() {
        return $this->accessControlService->usersViewDatatableAjax();
    }

    /**
     * @name usersSyncRoleAjax
     * @role sync user roles to database
     * @param Request $request
     * @return  Json response
     *
     */
    public function usersSyncRoleAjax(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'id'      => 'required|exists:users,id',
                'roles.*' => 'required|exists:roles,name',

            ],
            [
                'roles.*.exists' => 'Invalid Role!',
            ]
        );

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {

            $user     = User::findOrFail($request->id);
            $activity = $user->syncRoles($request->roles);
            if ($activity) {
                return response()->json("Success", Response::HTTP_OK);
            } else {
                return response()->json(array('errors' => "Something Went Wrong"), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * @name userActivateAjax
     * @role activate a user status record from database
     * @param Request $request
     * @return  Json response
     *
     */
    public function userActivateAjax(Request $request) {
        $id       = $request->id;
        $user     = User::findOrFail($id);
        $activity = $user->update(['status' => $this->userActive, 'verification_status' => $this->userActive]);
        if ($activity) {
            return response()->json("Success", Response::HTTP_OK);
        } else {
            return response()->json(array('errors' => "Something Went Wrong"), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @name usersDeactivateAjax
     * @role deactivate a user status record from database
     * @param Request $request
     * @return  Json response
     *
     */
    public function userDeactivateAjax(Request $request) {
        $id       = $request->id;
        $user     = User::findOrFail($id);
        $activity = $user->update(['status' => $this->userDeactive, 'verification_status' => $this->userDeactive]);
        if ($activity) {
            return response()->json("Success", Response::HTTP_OK);
        } else {
            return response()->json(array('errors' => "Something Went Wrong"), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @name usersDeleteAjax
     * @role delete a user record from database
     * @param Request $request
     * @return  Json response
     *
     */
    public function userDeleteAjax(Request $request) {
        $id   = $request->id;
        $user = User::findOrFail($id);

        $deleteResponse = $user->delete();

        if ($deleteResponse) {
            return response()->json("Success", Response::HTTP_OK);
        } else {
            return response()->json(array('errors' => "Something Went Wrong"), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
