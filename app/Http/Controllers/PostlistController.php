<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\Models\Postlist;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class PostlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $postlist = $this->postService->getPosts($request);
        $pageSize = $request->input('page-size', 6);
        $route = $request->route()->getName();

        return view('home.postlist', compact('postlist', 'pageSize', 'route'));
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
        $postlist = Post::findOrFail($id);

        return view('home.editpost', compact('postlist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $postlist = Post::findOrFail($id);
        $postlist->status=$request->input('toggle_switch');
        $postlist->updated_user_id=Auth::id();
        $postlist->update($request->all());

        return redirect()->route('postlist.index')->with('success', 'post edited successfully');
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
    $postlist = Post::findOrFail($id);

    // Update fields before deleting (soft delete)
    //$postlist->deleted_at = Carbon::now();
    $postlist->deleted_user_id = Auth::id();
    $postlist->save();

    // Perform the delete operation (soft delete)
    $postlist->delete();

    return redirect()->route('postlist.index')->with('success', 'Post deleted successfully');
}
}
