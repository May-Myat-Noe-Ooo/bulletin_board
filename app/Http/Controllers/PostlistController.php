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
   //dd($request->input('search-keyword'));
    $postlist = $this->postService->getPosts($request);
    $pageSize = $request->input('page-size', 6);
    $route = $request->route()->getName();
    
    return view('home.postlist', compact('postlist', 'pageSize', 'route'));
}

    /**
     * Show the form for editing the specified post.
     */
    public function edit(string $id)
    {
        $postlist = $this->postService->getPostById($id);

        return view('home.editpost', compact('postlist'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->postService->updatePost($request,$id);

        return redirect()->route('postlist.index')->with('success', 'post edited successfully');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(string $id)
{
    $this->postService->deletePostById($id);

    return redirect()->route('postlist.index')->with('success', 'Post deleted successfully');
}
}
