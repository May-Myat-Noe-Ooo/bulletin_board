<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postlist;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure user is authenticated
    }

    public function createPost()
    {
        return view('home.createpost');
    }

    public function confirmPost(\Illuminate\Http\Request $request)
    {
        //Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ],[
            'title.required' => 'Title cannot be blank.',
            'title.max' => 'Title cannot exceed 255 characters.',
            'description.required' => 'Description cannot be blank.',
        ]);
        $title = $request->title;
        $des = $request->description;
        return view('home.createconfirmpost', compact('title', 'des'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
    
        // Add the currently logged-in user's ID
        $validatedData['create_user_id'] = auth()->id();
    
        Postlist::create($validatedData);
    
        return redirect()->route('postlist.index')->with('success', 'Post uploaded successfully');
    }

    public function editPost()
    {
        return view('home.editpost');
    }

    public function confirmEditPost(\Illuminate\Http\Request $request, $id)
    {
        $postlist = $request;
        $title = $request->title;
        $des = $request->description;
        $toggleStatus = $request->input('toggle_switch');
        return view('home.editconfirmpost', compact('title', 'des', 'toggleStatus', 'postlist'));
    }
}
