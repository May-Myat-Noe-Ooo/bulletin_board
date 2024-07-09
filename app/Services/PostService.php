<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use League\Csv\Statement;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exports\PostlistsExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PostService
{
    /* Get post according to query and role for Postlist display UI */
    public function getPosts(Request $request): LengthAwarePaginator
    {
        $keyword = $request->input('search-keyword');
        $pageSize = $request->input('page-size', 6);
        $route = $request->route()->getName();

        $postlist = Post::getFilteredPosts($keyword, $pageSize, $route);

        $postlist->appends(['page-size' => $pageSize]);

        return $postlist;
    }
    /* Get each post according to the id for edit */
    public function getPostById(string $id): Post
    {
        $post = Post::findByIdOrFail($id);

        return $post;
    }
    /**
     * Prepare data for confirmation view.
     *
     * @param array $validatedData
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function prepareDataForConfirmation(array $validatedData, \Illuminate\Http\Request $request): array
    {
        $title = $validatedData['title'];
        $description = $validatedData['description'];
        $toggleStatus = $request->input('toggle_switch');
        //dd($toggleStatus);
        return [
            'title' => $title,
            'description' => $description,
            'toggleStatus' => $toggleStatus,
        ];
    }
    /**
     * Update the specified post.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return void
     */
    public function updatePost(Request $request, string $id): void
    {
        $post = Post::findByIdOrFail($id);
        $post->status = $request->input('toggle_switch');
        $post->updated_user_id = Auth::id();
        $post->update($request->all());
    }
    /* Delete post according to specific id */
    public function deletePostById(string $id): void
    {
        $post = Post::findByIdOrFail($id);

    /*Update fields before deleting (soft delete)*/
    //$postlist->deleted_at = Carbon::now();
    //$post->deleted_user_id = Auth::id();
    //$post->save();

    // Perform the delete operation (hard delete)
    $post->delete();
    }
    /**
     * Prepare data for confirmation new Post.
     *
     * @param array $validatedData
     * @return array
     */
    public function confirmPost(array $validatedData): array
    {
        $title = $validatedData['title'];
        $description = $validatedData['description'];
        return [
            'title' => $title,
            'description' => $description,
        ];
    }
    /**
     * Store the new post.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return void
     */
    public function storePost(array $validatedData): void
    {
       // Create a new post
       $data = [
        'title' => $validatedData['title'],
        'description' => $validatedData['description'],
        'create_user_id' => Auth::id(),
        'updated_user_id' => Auth::id(),
    ];

    Post::createNewPost($data);
    }
    /**
     * Upload and process the CSV file.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function uploadCsv($request): array
    {
        // Validate the file input
        $validator = Validator::make($request->all(), [
            'csvfile' => 'required|file|mimes:csv|mimetypes:text/csv',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()->first()];
        }

        // Retrieve the uploaded file
        $file = $request->file('csvfile');

        try {
            // Read the file content
            $content = file_get_contents($file->getRealPath());

            // Normalize line endings to Unix style
            $content = str_replace(["\r\n", "\r"], "\n", $content);

            // Write the normalized content back to a temporary file
            $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.csv';
            file_put_contents($tempPath, $content);

            // Parse the CSV file using league/csv
            $csv = Reader::createFromPath($tempPath, 'r');
            $csv->setHeaderOffset(0); // Set the header offset

            // Get the header and check its length
            $header = $csv->getHeader();
            // Check if the header has exactly 3 columns
            if (count($header) !== 3) {
                return ['error' => 'CSV must have exactly 3 columns.'];
            }

            // Get the records
            $records = Statement::create()->process($csv);

            // Array to collect errors
            $errors = [];

            // Validate each row
            foreach ($records as $index => $record) {
                if (count($record) !== 3) {
                    $errors[] = 'Row ' . ($index + 1) . ': Each row in the CSV must have exactly 3 columns.';
                    continue;
                }

                // Check for unique title in the database
                if (Post::titleExists($record['title'])) {
                    $errors[] = 'Row ' . ($index + 1) . ": The title '{$record['title']}' has already been taken.";
                    continue;
                }

                // Create a new postlist entry
                Post::createNewPost([
                    'title' => $record['title'],
                    'description' => $record['description'],
                    'status' => $record['status'],
                    'create_user_id' => Auth::id(),
                    'updated_user_id' => Auth::id(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            if (!empty($errors)) {
                return ['error_html' => $errors];
            }

            return ['success' => 'CSV data uploaded successfully.'];
        } catch (Exception $e) {
            return ['error' => 'There was an error processing the CSV file.'];
        }
    }
    /**
     * Export posts to a CSV file based on the given criteria.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export($request): StreamedResponse
    {
        $keyword = $request->input('search-keyword');
        $route = $request->input('current-route');

        // Fetch the filtered posts using the model method
        $postlist = Post::getFilteredPostsForExport($keyword, $route);
        // Handle the CSV export logic
        return new StreamedResponse(
            function () use ($postlist) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['id', 'title', 'description', 'status', 'create_user_id', 'updated_user_id', 'deleted_user_id', 'created_at', 'updated_at', 'deleted_at']);
                foreach ($postlist as $post) {
                    fputcsv($handle, [$post->id, $post->title, $post->description, $post->status, $post->create_user_id, $post->updated_user_id, $post->deleted_user_id, $post->created_at, $post->updated_at, $post->deleted_at]);
                }
                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="posts.csv"',
            ]
        );
    }

}
