<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Models\Post;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    /* Get post according to query and role for Userlist display UI */
    public function getUsers(Request $request): LengthAwarePaginator
{
    // Get search parameters
    $name = $request->input('name');
    $email = $request->input('mailaddr');
    $fromDate = $request->input('from-date');
    $toDate = $request->input('to-date');
    $pageSize = $request->input('page-size', 4); // Default page size is 4

    // Check if the page size has changed and reset the page parameter to 1
    if ($request->input('page-size-changed')) {
        $request->merge(['page' => 1]);
    }

    // Fetch the filtered users using the model method
    $userlist = User::getFilteredUsers($name, $email, $fromDate, $toDate, $pageSize);

    // Pass additional data to the view
    $userlist->appends([
        'page-size' => $pageSize,
        'name' => $name,
        'mailaddr' => $email,
        'from-date' => $fromDate,
        'to-date' => $toDate,
    ]); // Ensure page size is appended to pagination links

    return $userlist;
}
    /* Delete user according to specific id */
    public function deleteUserById(string $id): void
    {
        $user = User::findUserByIdOrFail($id);

        // Soft delete the user
        $user->softDeleteUser();

        // Hard delete all posts related to the user
        Post::deletePostsByUserId($user->id);
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
                cookie()->queue('remember_password', $credentials['pw'], 10080);
            }
            return ['success'];
        }

        // Check if email exists in the database
        $user = User::emailExists($credentials['email']);
        if (!$user) {
            return ['error' => 'There is no such account. Please sign up and create an account.'];
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
        $softDeletedUser = User::findSoftDeletedUser($data);

        if ($softDeletedUser) {
            // Restore the soft deleted user
            $softDeletedUser->restore();

            // Update the restored user with new data
            $softDeletedUser->updateRestoredUser($data);
            return [
                'success' => 'Account reactivated successfully. Log in again.',
            ];
        } else {
            // Check for existing active users with the same name or email
            $activeUserExists = User::activeUserExists($data);

            if ($activeUserExists) {
                return [
                    'error_html' => [
                        'name' => 'Name must be unique.',
                        'email' => 'Email must be unique.',
                    ],
                ];
            }

            // Create a new user
            User::createUser($data);

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
        $softDeletedUser = User::findSoftDeletedUser($data);

        if ($softDeletedUser) {
            $imageName = time() . '.' . $data['profile']->extension();
            $data['profile']->move(public_path('img'), $imageName);
            $profilePath = 'img/' . $imageName;

            return [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['pw'],
                'cpassword' => $data['cpw'],
                'type' => $data['type'],
                'phone' => $data['phone'],
                'dob' => $data['date'],
                'address' => $data['address'],
                'imagePath' => $profilePath,
                'profile' => $profilePath,
            ];
        } else {
            // Check for existing active users with the same name or email
            $activeUserExists = User::activeUserExists($data);

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
                'password' => $data['pw'],
                'cpassword' => $data['cpw'],
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
        $softDeletedUser = User::findSoftDeletedUser($data);
        // If a soft-deleted user exists, pass the data as usual
        if ($softDeletedUser) {
            // Restore the soft deleted post
            $softDeletedUser->restore();

            // Update the restored post with new description if needed
            $softDeletedUser->updateRestoredUserInRegister($data);
            return [
                'success' => 'Register user added successfully',
            ];
        } else {
            // Check for existing active users with the same name or email
            $activeUserExists = User::activeUserExists($data);

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
            User::createUserInRegister($data);

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
        $user = User::findUserByIdOrFail($id);

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
        $user = User::findUserByIdOrFail($id);

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
        
        $user = User::findUserByIdOrFail($id);
        
        if (!Hash::check($request->cp, $user->password)) {
            return ['error' => 'Current password is incorrect'];
        }
        
        $user->resetPassword($request->new_password);

        return ['success' => 'Password updated successfully.'];
    }
    /*Send Reset Link */
    public function sendResetLink(Request $request): array
    {
        // Check if email exists in the database
        $user = User::findByEmail($request->email);

        if (!$user) {
            return ['error' => 'Email does not exist in the system'];
        }

        $token = PasswordReset::createPasswordResetToken($request->email);
        Mail::to($request->email)->send(new PasswordResetMail($user, $token));

        return [
            'success' => 'Email sent with password reset instructions.',
        ];
    }
    /* Reset Password */
    public function resetPassword(\Illuminate\Http\Request $request): array
    {
        // Query to find the password reset entry by token
        $passwordReset = PasswordReset::findByToken($request->token);

        if (!$passwordReset) {
            return ['error' => ['token' => 'Invalid token']];
        }

        // Query to find the user by email
        $user = User::findByEmail($passwordReset->email);
        if (!$user) {
            return ['error' => ['email' => 'Email does not exist']];
        }

        // Reset the user's password
        $user->resetPassword($request->password);

        // Delete the password reset entry by email
        PasswordReset::deleteByEmail($user->email);

        return [
            'success' => 'Password has been reset.',
        ];
    }
}
