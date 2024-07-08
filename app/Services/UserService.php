<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use Carbon\Carbon;

class UserService
{
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
}
