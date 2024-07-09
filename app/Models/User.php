<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id', 'name', 'email', 'password', 'profile', 'type', 'phone', 'address', 'dob', 'create_user_id', 'updated_user_id', 'deleted_user_id', 'creatd_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class, 'create_user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'create_user_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    /* Dashboard Service Query*/
    public static function countByType(string $type): int
    {
        return self::where('type', $type)->count();
    }

    public static function postsCountByUser()
    {
        return self::withCount('posts')->get();
    }

    public static function countUsersPerMonth()
    {
        return self::selectRaw('COUNT(*) as count, MONTH(created_at) as month')->groupBy('month')->get();
    }
    /* User Service Query */
    // Define the query method for fetching filtered users
    public static function getFilteredUsers($name = null, $email = null, $fromDate = null, $toDate = null, $pageSize = 4): LengthAwarePaginator
    {
        return self::whereNull('deleted_at')
            ->when(Auth::user()->type !== 0, function ($query) {
                return $query->where('create_user_id', Auth::id());
            })
            ->when($name, function ($query, $name) {
                return $query->where('name', 'LIKE', "%{$name}%");
            })
            ->when($email, function ($query, $email) {
                return $query->where('email', 'LIKE', "%{$email}%");
            })
            ->when($fromDate, function ($query, $fromDate) {
                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function ($query, $toDate) {
                return $query->whereDate('created_at', '<=', $toDate);
            })
            ->orderBy('id', 'DESC')
            ->paginate($pageSize);
    }
}
