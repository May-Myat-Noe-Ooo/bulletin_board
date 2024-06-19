<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postlist;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class PostlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('search-keyword');
        
        if (Auth::user()->type == 0) {
            // Admin user: can search all posts
            $postlist = Postlist::whereNull('deleted_at')
            ->when($keyword, function ($query, $keyword) {
                return $query->where('title', 'LIKE', "%{$keyword}%")
                             ->orWhere('description', 'LIKE', "%{$keyword}%")
                             ->orWhere('created_at', 'LIKE', "%{$keyword}%");
            })->orderBy('created_at', 'DESC')->paginate(5);
        } else {
            // Regular user: can only search their own posts
            $postlist = Postlist::where('create_user_id', Auth::id())
            ->whereNull('deleted_at')
            ->when($keyword, function ($query, $keyword) {
                    return $query->where('title', 'LIKE', "%{$keyword}%")
                                 ->orWhere('description', 'LIKE', "%{$keyword}%")
                                 ->orWhere('created_at', 'LIKE', "%{$keyword}%");
                })->orderBy('created_at', 'DESC')->paginate(5);
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
    $postlist = Postlist::findOrFail($id);

    // Update fields before deleting (soft delete)
    $postlist->deleted_at = Carbon::now();
    $postlist->deleted_user_id = Auth::id();
    $postlist->save();

    // Perform the delete operation (soft delete)
    // $postlist->delete();

    return redirect()->route('postlist.index')->with('success', 'Post deleted successfully');
}
}
