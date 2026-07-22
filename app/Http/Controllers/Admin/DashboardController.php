<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Traits\AuthorizesAdminActions;

class DashboardController extends Controller
{
    use AuthorizesAdminActions;

    public function __construct(
        private readonly DashboardService $dashboardService,
    ) {}

    public function index()
    {
        $data = $this->dashboardService->getDashboardData();

        return view('admin.dashboard', $data);
    }
}
