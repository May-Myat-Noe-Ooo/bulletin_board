<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postlist;
use Illuminate\Support\Facades\Auth;
class PostlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $postlist = PostList::Paginate(5);
        // // $postlist = Postlist::orderBy('created_at', 'DESC')->get();
        // return view('home.postlist', compact('postlist'));
        if (Auth::user()->type == 0) {
            // Admin user
            $postlist = Postlist::orderBy('created_at', 'DESC')->paginate(5);
        } else {
            // Regular user
            $postlist = Postlist::where('create_user_id', Auth::id())->orderBy('created_at', 'DESC')->paginate(5);
        }

        return view('home.postlist', compact('postlist'));
    }

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $postlist = Postlist::findOrFail($id);

        return view('home.editpost', compact('postlist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $postlist = Postlist::findOrFail($id);

        $postlist->update($request->all());

        return redirect()->route('postlist.index')->with('success', 'post updated successfully');
    }
    //public function update(Request $request, string $id)
    //{
    //    //
    //}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
