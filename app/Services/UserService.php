<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    /* Get post according to query and role for Postlist display UI */
    public function getUsers(Request $request): LengthAwarePaginator
    {
        // Get search parameters
        $name = $request->input('name');
        $email = $request->input('mailaddr');
        $fromDate = $request->input('from-date');
        $toDate = $request->input('to-date');
        $pageSize = $request->input('page-size', 4); // Default page size is 5
        //// Fetch the filtered users using the model method
        //$userlist = User::getFilteredUsers($name, $email, $fromDate, $toDate, $pageSize);
        // Get the authenticated user's type
        //$userType = Auth::user()->type;
        if (Auth::user()->type == 0) {
            // Base query for users, excluding soft-deleted users
            $userlist = User::whereNull('deleted_at')
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
        } else {
            $userlist = User::where('create_user_id', Auth::id())
                ->whereNull('deleted_at')
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
        // Pass additional data to the view
    $userlist->appends(['page-size' => $pageSize]); // Ensure page size is appended to pagination links

        return $userlist;
    }
    /* Delete user according to specific id */
    public function deleteUserById(string $id): void
    {
        $user = User::findOrFail($id);

        // Update fields before deleting (soft delete)
        $user->deleted_at = Carbon::now();
        $user->deleted_user_id = Auth::id();
        $user->save();

        // Hard delete all posts related to the user
        Post::where('create_user_id', $user->id)->forceDelete();
    }
    /**
     * Handle user login.
     *
     * @param array $credentials
     * @param bool $remember
     * @return array
     */
    public function login(array $credentials, bool $remember): array
    {
        if (Auth::attempt($credentials)) {
            // Authentication passed, redirect to post list
            if ($remember) {
                // Set a cookie that lasts for one week
                cookie()->queue('remember_email', $credentials['email'], 10080);
                cookie()->queue('remember_password', $credentials['password'], 10080);
            }
            return ['success'];
        }

        // Check if email exists in the database
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return ['error'=> 'There is no such account. Please sign up and create an account.'];
        }

        // Check if the password is incorrect
        return ['error' => 'Incorrect password. Please try again.'];
    }
    /**
     * Handle user signup and reactivation.
     *
     * @param array $data
     * @return array
     */
    public function signup(array $data): array
    {
        // Check for a soft-deleted user with the same name or email
        $softDeletedUser = User::onlyTrashed()
            ->where(function ($query) use ($data) {
                $query->where('name', $data['name'])->orWhere('email', $data['email']);
            })
            ->first();

        if ($softDeletedUser) {
            // Restore the soft deleted user
            $softDeletedUser->restore();

            // Update the restored user with new data
            $softDeletedUser->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'] ?? null,
                'dob' => $data['dob'] ?? null,
                'address' => $data['address'] ?? null,
                'profile' => 'img/defaultprofile.png',
                'type' => '1',
                'create_user_id' => $softDeletedUser->id,
                'updated_user_id' => $softDeletedUser->id,
            ]);

            return [
                'success' => 'Account reactivated successfully. Log in again.',
            ];
        } else {
            // Check for existing active users with the same name or email
            $activeUserExists = User::where('name', $data['name'])
                ->orWhere('email', $data['email'])
                ->exists();

            if ($activeUserExists) {
                return [
                    'error_html' => [
                        'name' => 'Name must be unique.',
                        'email' => 'Email must be unique.',
                    ],
                ];
            }

            // Create a new user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'profile' => 'img/defaultprofile.png',
                'create_user_id' => 1,
                'updated_user_id' => 1,
            ]);

            // Update the create_user_id and updated_user_id fields
            $user->create_user_id = $user->id;
            $user->updated_user_id = $user->id;
            $user->save();

            return [
                'success' => 'Account created successfully. Log in again.',
            ];
        }
    }
    /**
     * Handle user confirm registration.
     *
     * @param array $data
     * @return array
     */
    public function confirmRegister(array $data): array
    {
        // Check for a soft-deleted user with the same name or email
        $softDeletedUser = User::onlyTrashed()
            ->where(function ($query) use ($data) {
                $query->where('name', $data['name'])->orWhere('email', $data['email']);
            })
            ->first();

        if ($softDeletedUser) {
            $imageName = time() . '.' . $data['profile']->extension();
            $data['profile']->move(public_path('img'), $imageName);
            $profilePath = 'img/' . $imageName;

            return [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'cpassword' => $data['password_confirmation'],
                    'type' => $data['type'],
                    'phone' => $data['phone'],
                    'dob' => $data['date'],
                    'address' => $data['address'],
                    'imagePath' => $profilePath,
                    'profile' => $profilePath,
                ];
        } else {
            // Check for existing active users with the same name or email
            $activeUserExists = User::where('name', $data['name'])
                ->orWhere('email', $data['email'])
                ->exists();

            if ($activeUserExists) {
                return [
                    'error_html' => [
                        'name' => 'Name must be unique.',
                        'email' => 'Email must be unique.',
                    ],
                ];
            }

            // If no soft-deleted or active user exists with the same name or email, pass the data as usual
            $imageName = time() . '.' . $data['profile']->extension();
            $data['profile']->move(public_path('img'), $imageName);
            $profilePath = 'img/' . $imageName;

            return [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'cpassword' => $data['password_confirmation'],
                    'type' => $data['type'],
                    'phone' => $data['phone'],
                    'dob' => $data['date'],
                    'address' => $data['address'],
                    'imagePath' => $profilePath,
                    'profile' => $profilePath,
                ];
        }
    }
    /**
     * Handle user confirm registration.
     *
     * @param array $data
     * @return array
     */
    public function storeRegisterUser(array $data): array
    {
        // Check for a soft-deleted user with the same name or email
        $softDeletedUser = User::onlyTrashed()
            ->where(function ($query) use ($data) {
                $query->where('name', $data['name'])->orWhere('email', $data['email']);
            })
            ->first();
        // If a soft-deleted user exists, pass the data as usual
        if ($softDeletedUser) {
           // Restore the soft deleted post
           $softDeletedUser->restore();

           // Update the restored post with new description if needed
           $softDeletedUser->update([
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
           return [
            'success' => 'Register user added successfully',
        ];
        } else {
            // Check for existing active users with the same name or email
            $activeUserExists = User::where('name', $data['name'])
                ->orWhere('email', $data['email'])
                ->exists();

            if ($activeUserExists) {
                return [
                    'error_html' => [
                        'name' => 'Name must be unique.',
                        'email' => 'Email must be unique.',
                    ],
                ];
            }

            /// If no soft-deleted or active user exists with the same name or email, pass the data as usual
            // Create a new user
            $user = User::create([
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

            // // Update the create_user_id and updated_user_id fields to be the same as the user's id
            // $user->create_user_id = Auth::id();
            // $user->updated_user_id = $user->id;
            // $user->save();

            // Redirect to the user list page with a success message
            return [
                'success' => 'Register user added successfully',
            ];
        }
    }
    /* Get each User according to the id for display profile for specific user */
    public function getUserById(string $id): User
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException("User not found");
        }

        return $user;
    }
    /**
     * Update user profile.
     *
     * @param Request $request
     * @param string $id
     * @return array
     */
    public function updateProfile(Request $request, string $id): array
    {
        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->type = $request->input('type');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->dob = $request->input('date');
        $user->address = $request->input('address');

        // Handle profile image upload
        if ($request->hasFile('profile')) {
            $imageName = time() . '.' . $request->profile->extension();
            $request->profile->move(public_path('img'), $imageName);
            $user->profile = 'img/' . $imageName;
        }
        $user->updated_user_id = Auth::id();

        $user->save();

        return ['success' => 'Profile updated successfully.'];
    }
    /* Password Section */
    /*Update Password normal*/
    public function updatePassword(Request $request, string $id): array
    {
        $user = User::find($id);

        if (!Hash::check($request->current_password, $user->password)) {
            return ['error' => 'Current password is incorrect'];
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return ['success' => 'Password updated successfully.'];
    }
    /*Send Reset Link */
    public function sendResetLink(Request $request): array
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return ['error' => 'Email does not exist in the system'];
        }

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);
        // dd($user);
        Mail::to($request->email)->send(new PasswordResetMail($user, $token));

        return [
            'success' => 'Email sent with password reset instructions.',
        ];
    }
    /* Reset Password */
    public function resetPassword(\Illuminate\Http\Request $request): array
    {
        $passwordReset = DB::table('password_resets')
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return ['error'=>['token' => 'Invalid token']];
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return ['error'=>['email' => 'Email does not exist']];
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')
            ->where('email', $user->email)
            ->delete();

            return [
                'success' => 'Password has been reset.',
            ];

    }

}
