<?php

namespace App\Http\Controllers;

use App\Services\LikeService;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->middleware('auth'); // Ensure user is authenticated
        $this->likeService = $likeService;
    }
 /**
     * Toggle the like status for a given post.
     *
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
public function toggleLike(Request $request, Post $post)
{
    $result = $this->likeService->toggleLike($post);

    return response()->json($result);
}
/**
     * Get the likers of a given post.
     *
     * @param int $postId
     * @return \Illuminate\Http\JsonResponse
     */
public function getPostLikes($postId)
{
    $result = $this->likeService->getPostLikes($postId);

    return response()->json($result);
}

}
