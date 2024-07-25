<?php

namespace App\Http\Controllers;
use App\Services\DashboardService;

class AdminController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->middleware('auth'); // Ensure user is authenticated
        $this->dashboardService = $dashboardService;
    }
    public function dashboard()
    {
        $result = $this->dashboardService->dashboard();
        return view('home.dashboard', [
        'totalUsers' =>$result['totalUsers'],
        'totalAdmins'=>$result['totalAdmins'],
        'totalStaffs'=>$result['totalStaffs'],
        'totalPosts'=>$result['totalPosts'],
        'activePosts'=>$result['activePosts'],
        'inactivePosts'=>$result['inactivePosts'],
        'postsByUser'=>$result['postsByUser'],
        'postsPerMonth'=>$result['postsPerMonth'],
        'usersPerMonth'=>$result['usersPerMonth']
    ]);
    }
}
