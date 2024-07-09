<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class Post extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'title', 'description', 'status', 'create_user_id', 'updated_user_id', 'deleted_user_id', 'created_at', 'updated_at', 'deleted_at'];
    public function user()
    {
        return $this->belongsTo(User::class, 'create_user_id');
    }
    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
    /* Like Service Query*/
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likesCount(): int
    {
        return $this->likes()->count();
    }

    public function likers()
    {
        return $this->likes()->with('user')->orderBy('created_at', 'desc')->get();
    }

    /* Dashboard Service Query*/
    public static function countByStatus(int $status): int
    {
        return self::where('status', $status)->count();
    }

    public static function countPostsPerMonth()
    {
        return self::selectRaw('COUNT(*) as count, MONTH(created_at) as month')->groupBy('month')->get();
    }

    /* Post Service Query*/
    public static function getFilteredPosts($keyword = null, $pageSize = 6, $route = null): LengthAwarePaginator
    {
        return self::when($route == 'home', function ($query) {
                return $query->where('status', 1);
            })->when($route == 'postlist.index' && Auth::check() && Auth::user()->type != 0, function ($query) {
                return $query->where('create_user_id', Auth::id());
            })->when($keyword, function ($query, $keyword) {
                return $query->where(function($query) use ($keyword) {
                    $query->where('title', 'LIKE', "%{$keyword}%")
                          ->orWhere('description', 'LIKE', "%{$keyword}%")
                          ->orWhere('created_at', 'LIKE', "%{$keyword}%");
                });
            })->orderBy('id', 'DESC')->paginate($pageSize);
    }

    public static function findByIdOrFail(string $id): self
    {
        $post = self::find($id);

        if (!$post) {
            throw new ModelNotFoundException("Post not found");
        }

        return $post;
    }

    public static function createNewPost(array $data): self
    {
        return self::create($data);
    }

    public static function titleExists(string $title): bool
    {
        return self::where('title', $title)->exists();
    }

    public static function getFilteredPostsForExport($keyword = null, $route = null)
    {
        return self::when($route == 'home', function ($query) {
                return $query->where('status', 1);
            })->when($route == 'postlist.index' && Auth::check() && Auth::user()->type != 0, function ($query) {
                return $query->where('create_user_id', Auth::id());
            })->when($keyword, function ($query, $keyword) {
                return $query->where(function($query) use ($keyword) {
                    $query->where('title', 'LIKE', "%{$keyword}%")
                          ->orWhere('description', 'LIKE', "%{$keyword}%")
                          ->orWhere('created_at', 'LIKE', "%{$keyword}%");
                });
            })->get();;
    }

}
