<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Mail\PasswordResetMail;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home.login');
    }

    public function signup()
    {
        return view('home.createAccount');
    }

    public function signupSave(Request $request)
    {
        // Validate the request
        $request->validate(
            [
                'name' => 'required|string|unique:users,name|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|string|min:8|confirmed',
            ],
            [
                'name.required' => 'Name cannot be blank.',
                'name.unique' => 'Name has already taken.',
                'email.required' => 'Email cannot be blank.',
                'email.email' => 'Email format is invalid.',
                'email.unique' => 'Email has already taken.',
                'password.required' => 'Password cannot be blank.',
                'password_confirmation.required' => 'Password cannot be blank.',
                'password_confirmation.confirmed' => 'Password and password confirmation do not match.',
            ],
        );

        // Check for a soft-deleted user with the same name or email
        $softDeletedUser = User::onlyTrashed()
            ->where(function ($query) use ($request) {
                $query->where('name', $request->name)->orWhere('email', $request->email);
            })
            ->first();

        if ($softDeletedUser) {
            // Update the existing soft-deleted user
            $softDeletedUser->name = $request->name;
            $softDeletedUser->email = $request->email;
            $softDeletedUser->password = Hash::make($request->password);
            $softDeletedUser->profile = ' ';
            $softDeletedUser->create_user_id = $softDeletedUser->id;
            $softDeletedUser->updated_user_id = $softDeletedUser->id;
            $softDeletedUser->deleted_at = null; // Reset the deleted_at field
            $softDeletedUser->save();

            // Redirect to the login page with a success message
            return redirect()->route('login.index')->with('success', 'Account reactivated successfully. Log in again.');
        } else {
            // Create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'profile' => ' ',
                'create_user_id' => 1,
                'updated_user_id' => 1,
            ]);

            // Update the create_user_id field to be the same as the user's id
            $user->create_user_id = $user->id;
            $user->updated_user_id = $user->id;
            $user->save();

            // Redirect to the login page with a success message
            return redirect()->route('login.index')->with('success', 'Account created successfully. Log in again.');
        }
    }

    public function login(\Illuminate\Http\Request $request)
    {
        // Validate the request
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email cannot be blank.',
                'email.email' => 'Email format is invalid.',
                'password.required' => 'Password cannot be blank.',
            ],
        );

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        if (Auth::attempt($credentials)) {
            // Authentication passed, redirect to post list
            if ($remember) {
                // Set a cookie that lasts for one week
                cookie()->queue('remember_email', $request->email, 10080);
                cookie()->queue('remember_password', $request->password, 10080);
            }
            return redirect()->route('postlist.index');
        }

        // Check if email exists in the database
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'There is no such account. Please sign up and create an account.');
        }

        // Check if the password is incorrect
        return redirect()->back()->with('error', 'Incorrect password. Please try again.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // Clear the cookies
        cookie()->queue(cookie()->forget('remember_email'));
        cookie()->queue(cookie()->forget('remember_password'));
        return redirect()->route('login.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createUser()
    {
        return view('home.createuser');
    }

    public function confirmRegister(\Illuminate\Http\Request $request)
    {
        // Validate the request
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:8|confirmed',
                'profile' => 'required|file',
            ],
            [
                'name.required' => 'Name cannot be blank.',
                'email.required' => 'Email cannot be blank.',
                'email.email' => 'Email format is invalid.',
                'password.required' => 'Password cannot be blank.',
                'password.confirmed' => 'Password and password confirmation do not match.',
                'profile.required' => 'Profile cannot be blank',
            ],
        );

        // Check for a soft-deleted user with the same name or email
        $softDeletedUser = User::onlyTrashed()
            ->where(function ($query) use ($request) {
                $query->where('name', $request->name)->orWhere('email', $request->email);
            })
            ->first();

        // If a soft-deleted user exists, pass the data as usual
        if ($softDeletedUser) {
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $cpassword = $request->password_confirmation;
            $type = $request->type;
            $phone = $request->phone;
            $dob = $request->date;
            $address = $request->address;
            $imageName = time() . '.' . $request->profile->extension();
            $success = $request->profile->move(public_path('img'), $imageName);
            $imagePath = 'img/' . $imageName;
            $profile = 'img/' . $imageName;

            return view('home.confirmregister', compact('name', 'email', 'password', 'cpassword', 'type', 'phone', 'dob', 'address', 'imagePath', 'profile'));
        } else {
            // Check for existing active users with the same name or email
            $activeUserExists = User::where('name', $request->name)
                ->orWhere('email', $request->email)
                ->exists();

            if ($activeUserExists) {
                // If an active user with the same name or email exists, show error messages
                return redirect()
                    ->back()
                    ->withErrors([
                        'name' => 'Name must be unique.',
                        'email' => 'Email must be unique.',
                    ])
                    ->withInput();
            }

            // If no soft-deleted or active user exists with the same name or email, pass the data as usual
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $cpassword = $request->password_confirmation;
            $type = $request->type;
            $phone = $request->phone;
            $dob = $request->date;
            $address = $request->address;
            $imageName = time() . '.' . $request->profile->extension();
            $success = $request->profile->move(public_path('img'), $imageName);
            $imagePath = 'img/' . $imageName;
            $profile = 'img/' . $imageName;

            return view('home.confirmregister', compact('name', 'email', 'password', 'cpassword', 'type', 'phone', 'dob', 'address', 'imagePath', 'profile'));
        }
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function storeRegisterUser(\Illuminate\Http\Request $request)
    {
        //     // Validate the request data
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email|max:255',
        //     'password' => 'required|string|min:8|confirmed',
        //     'profile' => 'required|string|max:255',
        // ]);
        //dd($request->profile_path);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'dob' => $request->date,
            'address' => $request->address,
            'profile' => $request->profile_path,
            'type' => $request->type == 'Admin' ? 0 : 1,
            'create_user_id' => Auth::id(),
            'updated_user_id' => Auth::id(),
        ]);

        // // Update the create_user_id and updated_user_id fields to be the same as the user's id
        // $user->create_user_id = Auth::id();
        // $user->updated_user_id = $user->id;
        // $user->save();

        // Redirect to the user list page with a success message

        return redirect()->route('displayuser')->with('success', 'Register user added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function displayUser(Request $request)
    {
        // Get search parameters
        $name = $request->input('name');
        $email = $request->input('mailaddr');
        $fromDate = $request->input('from-date');
        $toDate = $request->input('to-date');

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
                ->paginate(5);
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
                ->paginate(5);
        }
        // Return the view with the user list
        return view('home.userlist', compact('userlist'));
    }

    public function showProfile(string $id)
    {
        $user = User::findOrFail($id);
        //dd($user->profile);
        return view('home.profile', compact('user'));
    }

    public function editProfile(\Illuminate\Http\Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('home.editProfile', compact('user'));
    }

    //User/Admin password control section start
    public function changePassword($id)
{
    $user = User::find($id);
    return view('home.changepassword', compact('user'));
}

public function updatePassword(Request $request, $id)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6',
        'new_password_confirmation' => 'required|same:new_password',
    ]);

    $user = User::find($id);

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->route('displayuser')->with('success', 'Password updated successfully');
}
    //Forgot Password session
    public function forgotPassword()
    {
        return view('home.forgotPassword');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email does not exist in the system']);
        }

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);
       // dd($user);
        Mail::to($request->email)->send(new PasswordResetMail($user, $token));

        return redirect()->route('login.index')->with('success', 'Email sent with password reset instructions.');
    }

    public function showResetForm($token)
    {
        return view('home.resetPassword', ['token' => $token]);
    }

    public function resetPassword(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|confirmed',
        ],[
            'password.required' => 'Password cannot be blank.',
            'password_confirmation.required' => 'Password confirmation cannot be blank.',
            'password_confirmation.confirmed' => 'Password and password confirmation do not match.',
        ],);

        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$passwordReset) {
            return back()->withErrors(['token' => 'Invalid token']);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email does not exist']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $user->email)->delete();

        return redirect()->route('login.index')->with('success', 'Password has been reset.');
    }

    //User/Admin password control section end

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    //update profile
    public function updateProfile(Request $request, $id)
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

        return redirect()->route('displayuser')->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Update fields before deleting (soft delete)
        $user->deleted_at = Carbon::now();
        $user->deleted_user_id = Auth::id();
        $user->save();

        // Perform the delete operation (soft delete)
        //$postlist->delete();

        return redirect()->route('displayuser')->with('success', 'User deleted successfully');
    }
}
