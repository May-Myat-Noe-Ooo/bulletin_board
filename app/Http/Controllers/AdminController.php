<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetching statistics
        $totalUsers = User::where('type', '1')->count();
        $totalAdmins = User::where('type', '0')->count();
        $totalStaffs = User::count();
        $totalPosts = Post::count();
        $activePosts = Post::where('status', 1)->count();
        $inactivePosts = Post::where('status', 0)->count();

        // Data for pie chart: percentage of posts by each user
        $postsByUser = User::withCount('posts')->get()->map(function ($user) {
            return [
                'user' => $user->name,
                'posts_count' => $user->posts_count,
            ];
        });

        // Data for bar chart: number of posts and users per month
        $postsPerMonth = Post::select(DB::raw('COUNT(*) as count'), DB::raw('MONTH(created_at) as month'))
            ->groupBy('month')
            ->get();
        $usersPerMonth = User::select(DB::raw('COUNT(*) as count'), DB::raw('MONTH(created_at) as month'))
            ->groupBy('month')
            ->get();

        return view('home.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalStaffs',
            'totalPosts',
            'activePosts',
            'inactivePosts',
            'postsByUser',
            'postsPerMonth',
            'usersPerMonth'
        ));
    }
}
