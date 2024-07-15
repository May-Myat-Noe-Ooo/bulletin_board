<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Mail\PasswordResetMail;

class UsersController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        //$this->middleware('auth')->except(['login']); // Ensure user is authenticated, except for login
        $this->userService = $userService;
    }
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
                'email' => 'required|email|max:255',
                //'spw' => 'required|string|min:8|confirmed',
                'spw' => 'required|min:8',
            //'new_password_confirmation' => 'required|same:new_password',
                'scpw' => 'required|same:spw',
            ],
            [
                'name.required' => 'Name cannot be blank.',
                //'name.unique' => 'Name has already taken.',
                'email.required' => 'Email cannot be blank.',
                'email.email' => 'Email format is invalid.',
                //'email.unique' => 'Email has already taken.',
                'spw.required' => 'Password cannot be blank.',
                'scpw.same' => 'Password and password confirmation do not match.',
                'scpw.required' => 'Password cannot be blank.',
            ],
        );
        // Prepare data for the service
        $data = $request->only('name', 'email', 'spw', 'phone', 'dob', 'address');

        // Call the signup method in UserService
        $result = $this->userService->signup($data);

        if (isset($result['error_html'])) {
            return redirect()->back()->withErrors($result['error_html'])->withInput();
        }

        return redirect()->route('login.index')->with('success', $result['success']);
    }

    public function login(\Illuminate\Http\Request $request)
    {
        // Validate the request
        $request->validate(
            [
                'email' => 'required|email',
                'pw' => 'required',
            ],
            [
                'email.required' => 'Email cannot be blank.',
                'email.email' => 'Email format is invalid.',
                'pw.required' => 'Password cannot be blank.',
            ],
        );

        $credentials = $request->only('email', 'pw');
        $remember = $request->has('remember');
        // Call AuthService login method
        $loginResult = $this->userService->login($credentials, $remember);
        if (isset($loginResult['error'])) {
            return redirect()->back()->with('error', $loginResult['error'])->withInput();
        }


        return redirect()->route('postlist.index');
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
                'pw' => 'required|min:8',
                'cpw' => 'required|same:pw',
                'profile' => 'required|file',
            ],
            [
                'name.required' => 'Name cannot be blank.',
                'email.required' => 'Email cannot be blank.',
                'email.email' => 'Email format is invalid.',
                'pw.required' => 'Password cannot be blank.',
                'cpw.required' => 'Password confirmation cannot be blank.',
                'cpw.same' => 'Password and password confirmation do not match.',
                'profile.required' => 'Profile cannot be blank',
            ],
        );
        // Prepare data for the service
        $data = $request->only('name', 'email', 'pw', 'cpw', 'type', 'phone', 'date', 'address', 'profile');

        // Call the confirmRegister method in UserService
        $result = $this->userService->confirmRegister($data);

        if (isset($result['error_html'])) {
            return redirect()->back()->withErrors($result['error_html'])->withInput();
        }

        return view('home.confirmregister', [
            'name'=> $result['name'], 
            'email'=> $result['email'], 
            'password'=> $result['password'], 
            'cpassword'=> $result['cpassword'],
             'type'=> $result['type'],
              'phone'=> $result['phone'], 
              'dob'=> $result['dob'], 
              'address'=> $result['address'], 
              'imagePath'=> $result['imagePath'], 
              'profile'=> $result['profile']
            ]);
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
        // Prepare data for the service
        $data = $request->only('name', 'email', 'password', 'password_confirmation', 'type', 'phone', 'date', 'address', 'profile_path');
        // Call the storeRegisterUser method in UserService
        $result = $this->userService->storeRegisterUser($data);

        if (isset($result['error_html'])) {
            return redirect()->back()->withErrors($result['error_html'])->withInput();
        }

        return redirect()->route('displayuser')->with('success', $result['success']);
        
    }

    /**
     * Display the specified resource.
     */
    public function displayUser(Request $request)
{
    $userlist = $this->userService->getUsers($request);
    $pageSize = $request->input('page-size', 4); // Default page size is 4

    // Return the view with the user list
    return view('home.userlist', compact('userlist', 'pageSize'));
}

    public function showProfile(string $id)
    {
        $user = $this->userService->getUserById($id);
        return view('home.profile', compact('user'));
    }

    public function editProfile(\Illuminate\Http\Request $request, $id)
    {
        $user = $this->userService->getUserById($id);
        return view('home.editProfile', compact('user'));
    }

    //User/Admin password control section start
    public function changePassword($id)
    {
        $user = $this->userService->getUserById($id);
        return view('home.changepassword', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'cp' => 'required',
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        // Call the updatePassword method in UserService
        $result = $this->userService->updatePassword($request, $id);
        //dd($result['error']);
        if (isset($result['error'])) {
            return back()->withErrors(['cp' => $result['error']])->withInput();
        }

        return redirect()->route('displayuser')->with('success', $result['success']);
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
        // Call the sendResetLink method in UserService
        $result = $this->userService->sendResetLink($request);
        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error'])->withInput();
        }

        return redirect()->route('login.index')->with('success', $result['success']);
    }

    public function showResetForm($token)
    {
        return view('home.resetPassword', ['token' => $token]);
    }

    public function resetPassword(\Illuminate\Http\Request $request)
    {
        $request->validate(
            [
                'token' => 'required',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',
            ],
            [
                'password.required' => 'Password cannot be blank.',
                'password_confirmation.required' => 'Password confirmation cannot be blank.',
                'password.confirmed' => 'Password and password confirmation do not match.',
            ],
        );

        // Call the resetPassword method in UserService
        $result = $this->userService->resetPassword($request);
        if (isset($result['error'])) {
            return back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('login.index')->with('success', $result['success']);
    }
//User/Admin password control section end

    //update profile
    public function updateProfile(Request $request, $id)
    {
        // Call the updateProfile method in UserService
        $result = $this->userService->updateProfile($request, $id);
        return redirect()->route('displayuser')->with('success', $result['success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->deleteUserById($id);

        return redirect()->route('displayuser')->with('success', 'User deleted successfully');
    }
}
