<?php

namespace App\Http\Controllers;
use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Http\Request;
use App\Models\Postlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $validatedData['updated_user_id'] = auth()->id();
    
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

    public function uploadFile()
    {
        return view('home.uploadFile');
    }
   
// Upload CSV file
public function uploadCsv(Request $request)
{
    // Validate the file input
    $validator = Validator::make($request->all(), [
        'csvfile' => 'required|file|mimes:csv',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->with('error', $validator->errors()->first())->withInput();
    }

    // Retrieve the uploaded file
    $file = $request->file('csvfile');

    try {
        // Parse the CSV file using league/csv
        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0); // Set the header offset

        // Get the header and check its length
        $header = $csv->getHeader();

        // Check if the header has exactly 3 columns
        if (count($header) !== 3) {
            return redirect()->back()->with('error', 'CSV must have exactly 3 columns.')->withInput();
        }

        // Get the records
        $records = Statement::create()->process($csv);

        // Validate each row
        foreach ($records as $record) {
            if (count($record) !== 3) {
                return redirect()->back()->with('error', 'Each row in the CSV must have exactly 3 columns.')->withInput();
            }

            // Create a new postlist entry
            Postlist::create([
                'title' => $record['title'],
                'description' => $record['description'],
                'status' => $record['status'],
                'create_user_id' => Auth::id(),
                'updated_user_id' => Auth::id(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('postlist.index')->with('success', 'CSV data uploaded successfully.');
    } catch (Exception $e) {
        return redirect()->back()->with('error', 'There was an error processing the CSV file.')->withInput();
    }
}
}
