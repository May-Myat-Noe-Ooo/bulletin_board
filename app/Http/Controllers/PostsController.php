<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postlist;

class PostsController extends Controller
{
    public function createPost()
    {
        return view('home.createpost');
    }

    public function confirmPost(\Illuminate\Http\Request $request)
    {
        $title = $request->title;
        $des = $request->description;
        return view('home.createconfirmpost', compact('title', 'des'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        Postlist::create($request->all());

        return redirect()->route('postlist.index')->with('success', 'Post uploads successfully');
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
