<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\UserTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller {
    use UserTrait;
    /**
     * @name index
     * @role Dashboard view of controller
     * @param
     * @return  view with compact array
     *
     */

    public function index() {

        $users          = User::role($this->userRole)->count();

        $data = [
            'users' => $users,
        ];

        return view('admin.dashboard.index', $data);
    }

    /**
     * @name showUsersPage
     * @role Show Users Page
     * @param
     * @return  view with compact array
     *
     */
    public function showUsersPage() {
        return view('admin.dashboard.users');
    }

    /**
     * @name usersViewDatatableAjax
     * @role send datatable json for showing users
     * @param Request
     * @return  Datatable json
     *
     */
    public function usersViewDatatableAjax() {
        $users = User::role($this->userRole)->limit(10)->get();
        //dd($users);

        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('status', function ($user) {
                if ($user->status == $this->userActive) {
                    $markup = '<span class="badge badge-info">Active</span> ';
                } else {
                    $markup = '<span class="badge badge-warning">Deactive</span>';
                }

                return $markup;
            })
            ->addColumn('dob', function ($user) {
                return Carbon::parse($user->dob)->format('D, d M Y');
            })
            ->addColumn('action', function ($user) {
                $download = ' <a href="' . url('download/verification/' . $user->id) . '" class="btn btn-sm btn-primary" title="Download ID Verification"><i class="fa fa-download"></i></a>';

                return $download;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function checkEmail(Request $request) {
        $email = $request->email;
        if (User::where('email', $email)->exists()) {
            return response()->json(array(
                'message' => "Email already exists",
                'status' => Response::HTTP_FORBIDDEN
            ), Response::HTTP_FORBIDDEN);
        } else {
            return response()->json(array(
                'message' => "Email is available",
                'status' => Response::HTTP_OK
            ), Response::HTTP_OK);
        }
    }
}
