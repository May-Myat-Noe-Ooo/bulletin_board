<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use DB;

class DashboardService
{
  public function dashboard(): array
  {
      // Fetching statistics
      $totalUsers = User::countByType('1');
      $totalAdmins = User::countByType('0');
      $totalStaffs = User::count();
      $totalPosts = Post::count();
      $activePosts = Post::countByStatus(1);
      $inactivePosts = Post::countByStatus(0);

      // Data for pie chart: percentage of posts by each user
      $postsByUser = User::postsCountByUser()->map(function ($user) {
          return [
              'user' => $user->name,
              'posts_count' => $user->posts_count,
          ];
      });

      // Data for bar chart: number of posts and users per month
      $postsPerMonth = Post::countPostsPerMonth();
      $usersPerMonth = User::countUsersPerMonth();

      return ['totalUsers' =>$totalUsers,
      'totalAdmins'=>$totalAdmins,
      'totalStaffs'=>$totalStaffs,
      'totalPosts'=>$totalPosts,
      'activePosts'=>$activePosts,
      'inactivePosts'=>$inactivePosts,
      'postsByUser'=>$postsByUser,
      'postsPerMonth'=>$postsPerMonth,
      'usersPerMonth'=>$usersPerMonth];
  }
}
