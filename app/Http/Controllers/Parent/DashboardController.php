<?php

namespace App\Http\Controllers\Parent;
use App\Http\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Dashboard', 'View All Stats');
        return view('include.rolebase-views.parentpanel.dashboard.index');
    }
}
