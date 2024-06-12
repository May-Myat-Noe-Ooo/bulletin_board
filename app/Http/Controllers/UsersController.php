<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home.login');
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
