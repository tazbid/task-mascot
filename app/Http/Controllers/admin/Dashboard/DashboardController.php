<?php

namespace App\Http\Controllers\admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\DashboardService;
use App\Traits\UserTrait;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    use UserTrait;

    protected $dashboardService;

    /**
     * @name __construct
     * @role constructor
     * @return  void
     *
     */
    public function __construct(DashboardService $dashboardService) {
        $this->dashboardService = $dashboardService;
    }

    /**
     * @name index
     * @role Dashboard view of controller
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
     * @return  view with compact array
     *
     */
    public function showUsersPage() {
        return view('admin.dashboard.users');
    }

    /**
     * @name usersViewDatatableAjax
     * @role send datatable json for showing users
     * @return  Datatable json
     *
     */
    public function usersViewDatatableAjax() {
        return $this->dashboardService->usersViewDatatableAjax();
    }

    /**
     * @name checkEmail
     * @role Check email availability
     * @param Request
     * @return  Json response
     *
     */
    public function checkEmail(Request $request) {
        return $this->dashboardService->checkEmail($request);
    }
}
