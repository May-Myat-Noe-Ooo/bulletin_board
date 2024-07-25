<?php

namespace App\Http\Controllers;
//use League\Csv\Reader;
//use League\Csv\Statement;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Models\Postlist;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Exports\PostlistsExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PostsController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->middleware('auth'); // Ensure user is authenticated
        $this->postService = $postService;
    }

    public function createPost()
    {
        return view('home.createpost');
    }

    public function confirmPost(\Illuminate\Http\Request $request)
    {
        //Validate the request
        $validatedData =$request->validate(
            [
                'title' => 'required|string|max:255|unique:posts,title',
                'description' => 'required|string',
            ],
            [
                'title.required' => 'Title cannot be blank.',
                'title.unique' => 'This title has already been taken.',
                'title.max' => 'Title cannot exceed 255 characters.',
                'description.required' => 'Description cannot be blank.',
            ],
        );
        $data = $this->postService->confirmPost($validatedData);
        return view('home.createconfirmpost', [
            'title' => $data['title'],
        'des' => $data['description'],]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validatedData =$request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
        $this->postService->storePost($validatedData);
        return redirect()->route('postlist.index')->with('success', 'Post uploaded successfully');
    }

    //public function editPost()
    //{
    //    return view('home.editpost');
    //}

    public function confirmEditPost(\Illuminate\Http\Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
            ],
            [
                'title.required' => 'Title cannot be blank.',
                'title.unique' => 'This title has already been taken.',
                'title.max' => 'Title cannot exceed 255 characters.',
                'description.required' => 'Description cannot be blank.',
            ],
        );
        $data = $this->postService->prepareDataForConfirmation($validatedData, $request);
        $postlist = $request;
        return view('home.editconfirmpost', [
            'title' => $data['title'],
            'des' => $data['description'],
            'toggleStatus' => $data['toggleStatus'],
            'postlist' => $postlist,
        ]);
    }

    public function uploadFile()
    {
        return view('home.uploadFile');
    }

    // Upload CSV file
    public function uploadCsv(Request $request)
    {
        $result = $this->postService->uploadCsv($request);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error'])->withInput();
        }

        if (isset($result['error_html'])) {
            return redirect()->back()->with('error_html', $result['error_html'])->withInput();
        }

        return redirect()->route('postlist.index')->with('success', $result['success']);
    }

    //Download CSV file
public function export(Request $request): StreamedResponse
{
    return $this->postService->export($request);
}

}
