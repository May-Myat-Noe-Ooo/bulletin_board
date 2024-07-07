<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    public function getPosts(Request $request): LengthAwarePaginator
    {
        $keyword = $request->input('search-keyword');
        $pageSize = $request->input('page-size', 6);
        $route = $request->route()->getName();

        if (Auth::check()) {
            if (Auth::user()->type == 0) {
                // Admin user
                $postlist = Post::when($route == 'home', function ($query) {
                    return $query->where('status', 1);
                })->when($keyword, function ($query, $keyword) {
                    return $query->where('title', 'LIKE', "%{$keyword}%")
                                 ->orWhere('description', 'LIKE', "%{$keyword}%")
                                 ->orWhere('created_at', 'LIKE', "%{$keyword}%");
                })->orderBy('id', 'DESC')->paginate($pageSize);
            } else {
                // Regular user
                $postlist = Post::when($route == 'postlist.index', function ($query) {
                    return $query->where('create_user_id', Auth::id());
                }, function ($query) {
                    return $query->where('status', 1);
                })->when($keyword, function ($query, $keyword) {
                    return $query->where('title', 'LIKE', "%{$keyword}%")
                                 ->orWhere('description', 'LIKE', "%{$keyword}%")
                                 ->orWhere('created_at', 'LIKE', "%{$keyword}%");
                })->orderBy('id', 'DESC')->paginate($pageSize);
            }
        } else {
            // Unauthenticated users
            $postlist = Post::where('status', 1)
                ->when($keyword, function ($query, $keyword) {
                    return $query->where('title', 'LIKE', "%{$keyword}%")
                                 ->orWhere('description', 'LIKE', "%{$keyword}%")
                                 ->orWhere('created_at', 'LIKE', "%{$keyword}%");
                })->orderBy('id', 'DESC')->paginate($pageSize);
        }

        $postlist->appends(['page-size' => $pageSize]);

        return $postlist;
    }
}
