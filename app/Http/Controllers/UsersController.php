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
         $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Name cannot be blank.',
            'email.required' => 'Email cannot be blank.',
            'email.email' => 'Email format is invalid.',
            'password.required' => 'Password cannot be blank.',
            'password.confirmed' => 'Password and password confirmation do not match.',
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect to the login page with a success message
        return redirect()->route('login.index')->with('success', 'Account created successfully. Please login.');
    }

    public function login(\Illuminate\Http\Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email cannot be blank.',
            'email.email' => 'Email format is invalid.',
            'password.required' => 'Password cannot be blank.',
        ]);

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
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $cpassword = $request->confirmpassword;
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
        //dd ('$request->profile');
        User::create($request->all());

        return redirect()->route('displayuser')->with('success', 'Register user added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function displayUser()
    {
        $userlist = User::Paginate(5);
        // $postlist = Postlist::orderBy('created_at', 'DESC')->get();
        return view('home.userlist', compact('userlist'));
    }

    public function showProfile()
    {
        return view('home.profile');
    }

    public function editProfile(\Illuminate\Http\Request $request)
    {
        $name = $request->name;
        return view('home.editProfile', compact('name'));
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

    public function uploadFile()
    {
        return view('home.uploadFile');
    }

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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
