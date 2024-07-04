<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // app/Http/Controllers/PostController.php

public function toggleLike(Request $request, Post $post)
{
    $user = Auth::user();
    $like = Like::where('user_id', $user->id)->where('post_id', $post->id)->first();
    $likedByUser = false;

    if ($like) {
        $like->delete();
    } else {
        Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        $likedByUser = true;
    }

    return response()->json([
        'likes_count' => $post->likes()->count(),
        'liked_by_user' => $likedByUser,
        'likers' => $post->likes()->with('user')->orderBy('created_at', 'desc')->get()->map(function($like) {
            return [
                'name' => $like->user->name,
                'profile' => asset($like->user->profile)
            ];
        }),
    ]);
}

public function getPostLikes($postId)
{
    $post = Post::findOrFail($postId);
    $likers = $post->likes()->with('user')->orderBy('created_at', 'desc')->get()->map(function($like) {
        return [
            'name' => $like->user->name,
            'profile' => asset($like->user->profile)
        ];
    });

    return response()->json(['likers' => $likers]);
}

}
