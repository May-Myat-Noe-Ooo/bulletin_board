<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    /**
     * Toggle the like status for a given post by the authenticated user.
     *
     * @param Post $post
     * @return array
     */
    public function toggleLike(Post $post): array
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

        return [
            'likes_count' => $post->likes()->count(),
            'liked_by_user' => $likedByUser,
            'likers' => $this->formatLikers($post),
        ];
    }

    /**
     * Get the likers of a given post.
     *
     * @param int $postId
     * @return array
     */
    public function getPostLikes(int $postId): array
    {
        $post = Post::findOrFail($postId);
        return [
            'likers' => $this->formatLikers($post),
        ];
    }

    /**
     * Format likers for the given post.
     *
     * @param Post $post
     * @return array
     */
    private function formatLikers(Post $post): array
    {
        return $post->likes()->with('user')->orderBy('created_at', 'desc')->get()->map(function ($like) {
            return [
                'name' => $like->user->name,
                'profile' => asset($like->user->profile)
            ];
        })->toArray();
    }
}
