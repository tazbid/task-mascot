<?php

namespace App\Services;

use App\Models\User;
use App\Traits\UserTrait;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardService {
    use UserTrait;

    /**
     * @name usersViewDatatableAjax
     * @role send datatable json for showing users
     * @return  Datatable json
     *
     */
    public function usersViewDatatableAjax() {
        try {
            $users = User::role($this->userRole)->limit(10)->get();

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
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @name checkEmail
     * @role Check email availability
     * @param Request
     * @return  Json response
     *
     */
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
