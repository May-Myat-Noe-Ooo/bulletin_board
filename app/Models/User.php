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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            ->when(Auth::check() && Auth::user()->type != 0, function ($query) {
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

    public static function findUserByIdOrFail(string $id): self
    {
        $user = self::findOrFail($id);

        return $user;
    }

    public function softDeleteUser(): void
    {
        $this->deleted_at = Carbon::now();
        $this->deleted_user_id = Auth::id();
        $this->save();
    }

    public static function emailExists(string $email): bool
    {
        return self::where('email', $email)->exists();
    }
    
    public static function findSoftDeletedUser(array $data)
    {
        return self::onlyTrashed()
            ->where(function ($query) use ($data) {
                $query->where('name', $data['name'])->orWhere('email', $data['email']);
            })
            ->first();
    }

    public static function activeUserExists(array $data): bool
    {
        return self::where('name', $data['name'])
            ->orWhere('email', $data['email'])
            ->exists();
    }

    public static function createUser(array $data): self
    {
        $user = self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['spw']),
            'profile' => 'img/defaultprofile.png',
            'create_user_id' => 1,
            'updated_user_id' => 1,
        ]);

        // Update the create_user_id and updated_user_id fields
        $user->create_user_id = $user->id;
        $user->updated_user_id = $user->id;
        $user->save();

        return $user;
    }

    public function updateRestoredUser(array $data): void
    {
        $this->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['spw']),
            'phone' => $data['phone'] ?? null,
            'dob' => $data['dob'] ?? null,
            'address' => $data['address'] ?? null,
            'profile' => 'img/defaultprofile.png',
            'type' => '1',
            'create_user_id' => $this->id,
            'updated_user_id' => $this->id,
        ]);
    }

    public static function createUserInRegister(array $data): self
    {
        $user = self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
               'dob' => $data['date'],
               'address' => $data['address'],
               'profile' => $data['profile_path'],
               'type' => $data['type'] == 'Admin' ? 0 : 1,
               'create_user_id' => Auth::id(),
               'updated_user_id' => Auth::id(),
        ]);

        return $user;
    }

    public function updateRestoredUserInRegister(array $data): void
    {
        $this->update([
            'name' => $data['name'],
               'email' => $data['email'],
               'password' => Hash::make($data['password']),
               'phone' => $data['phone'],
               'dob' => $data['date'],
               'address' => $data['address'],
               'profile' => $data['profile_path'],
               'type' => $data['type'] == 'Admin' ? 0 : 1,
               'create_user_id' => Auth::id(),
               'updated_user_id' => Auth::id(),
        ]);
    }

    public static function findByEmail(string $email): ?self
    {
        return self::where('email', $email)->first();
    }

    /**
     * Reset the user's password.
     *
     * @param string $passwordf
     * @return void
     */
    public function resetPassword(string $password): void
    {
        $this->password = Hash::make($password);
        $this->save();
    }

}
