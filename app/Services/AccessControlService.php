<?php

namespace App\Services;

use App\Models\User;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class AccessControlService
{
    use UserTrait;
    /**
     * @name usersViewDatatableAjax
     * @role send datatable json for showing users
     * @return  Datatable json
     *
     */
    public function usersViewDatatableAjax() {
        try{
            $users = User::with('roles')->get();

            return Datatables::of($users)
                ->addIndexColumn()
                ->editColumn('status', function ($user) {
                    if ($user->status == $this->userActive) {
                        $markup = '<span class="badge badge-info">Active</span> ';
                    } else {
                        $markup = '<span class="badge badge-warning">Deactive</span>';
                    }

                    return $markup;
                })
                ->editColumn('created_at', function ($user) {
                    return date_format($user->created_at, 'D, F j, Y g:i a');
                })
                ->addColumn('roles', function ($user) {
                    $markup = '<div onclick="manageRole(' . $user->id . ')">';
                    $roles  = $user->getRoleNames();

                    foreach ($roles as $role) {
                        $markup .= ' <span class = "badge badge-primary">' . $role . '</span> ';
                    }
                    $markup .= '</div>';
                    return $markup;
                })
                ->addColumn('action', function ($user) {
                    $markup = '';

                    if ($user->id != 1 && $user->id != 2) {
                        if ($user->status == $this->userActive) {
                            $markup .= '<button class="btn btn-sm btn-secondary" onclick="deactiveUser(' . $user->id . ')"
                        data-toggle="tooltip" data-placement="top" title="Deactive User"><i
                        class="fa fa-ban" aria-hidden="true"></i></button>';
                        } else {

                            $markup = '<button class="btn btn-sm btn-success" onclick="activeUser(' . $user->id . ')"
                            data-toggle="tooltip" data-placement="top" title="Activate User"><i
                            class="far fa-check-circle" aria-hidden="true"></i></button>';
                        }

                        $markup .= ' <button class="btn btn-sm btn-info" onclick="manageRole(' . $user->id . ')"
                        data-toggle="tooltip" data-placement="top" title="Manage Roles"><i
                        class="fa fa-key" aria-hidden="true"></i></button>';

                        $markup .= ' <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"
                        onclick="deleteUser(' . $user->id . ')"><i
                        class="fa fa-trash-o" aria-hidden="true"></i></button>';
                    }

                    return $markup;
                })
                ->rawColumns(['action', 'status', 'roles'])
                ->make(true);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
