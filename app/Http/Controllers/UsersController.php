<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'name.required' => 'Name cannot be blank.',
                'email.required' => 'Email cannot be blank.',
                'email.email' => 'Email format is invalid.',
                'password.required' => 'Password cannot be blank.',
                'password.confirmed' => 'Password and password confirmation do not match.',
            ],
        );

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
        return redirect()->route('login.index')->with('success', 'Account created successfully.Log in Again.');
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
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email|max:255',
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
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $cpassword = $request->password_confirmation;
        $type = $request->type;
        //dd($type);
        $phone = $request->phone;
        $dob = $request->date;
        $address = $request->address;
        $imageName = time() . '.' . $request->profile->extension();
        $success = $request->profile->move(public_path('img'), $imageName);
        $imagePath = 'img/' . $imageName;
        $profile = 'img/' . $imageName;
        return view('home.confirmregister', compact('name', 'email', 'password', 'cpassword', 'type', 'phone', 'dob', 'address', 'imagePath', 'profile'));
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
        $userType = Auth::user()->type;

        // Base query for users
        $query = User::query();

        // Apply filters
        if ($name) {
            $query->where('name', 'LIKE', "%{$name}%");
        }
        if ($email) {
            $query->where('email', 'LIKE', "%{$email}%");
        }
        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }

        // Apply user type filter
        if ($userType != 0) {
            $query->where('create_user_id', Auth::id());
        }

        // Order by user ID in descending order
        $query->orderBy('id', 'DESC');

        // Paginate the results
        $userlist = $query->paginate(5);

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
    public function changePassword(\Illuminate\Http\Request $request)
    {
        return view('home.changepassword');
    }

    public function forgotPassword(\Illuminate\Http\Request $request)
    {
        return view('home.forgotPassword');
    }

    public function resetPassword(\Illuminate\Http\Request $request)
    {
        return view('home.resetPassword');
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
        $user->type = $request->input('type') == 'Admin' ? 0 : 1;
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
        //
    }
}
