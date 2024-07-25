<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use League\Csv\Statement;
use Carbon\Carbon;
use Exception;
class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_Post_store(): void
    {
        $data = ['title' => 'TestTitle2', 'description' => 'description1', 'create_user_id' => 1, 'updated_user_id' => 1];
        $post = Post::createNewPost($data);
        // dd($post);
        //$response->assertStatus($response->status(),302);
        // Check the database
        $this->assertDatabaseHas('posts', [
            'title' => 'TestTitle2',
            'description' => 'description1',
            'status' => 1,
            'create_user_id' => 1,
            'updated_user_id' => 1,
        ]);
    }
    public function test_Post_update(): void
    {
        // Create a sample post
        $data = ['title' => 'OldTitle', 'description' => 'OldDescription', 'create_user_id' => 1, 'updated_user_id' => 1, 'status' => 1];
        $post = Post::createNewPost($data);

        // Mock the request
        $request = new Request([
            'toggle_switch' => 0,
            'title' => 'NewTitle',
            'description' => 'NewDescription',
        ]);

        // Mock Auth::id()
        Auth::shouldReceive('id')->andReturn(2);

        // Call the updatePost method
        $postService = new PostService();
        $postService->updatePost($request, $post->id);

        // Verify the post was updated
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'NewTitle',
            'description' => 'NewDescription',
            'status' => 0,
            'updated_user_id' => 2,
        ]);
    }
    public function test_Post_delete(): void
    {
        // Create a sample post
        $data = ['title' => 'TestTitleToDelete', 'description' => 'TestDescriptionToDelete', 'create_user_id' => 1, 'updated_user_id' => 1, 'status' => 1];
        $post = Post::createNewPost($data);

        // Call the deletePostById method
        $postService = new PostService();
        $postService->deletePostById($post->id);

        // Verify the post was deleted
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
    public function test_Post_export(): void
    {
        // Create sample posts
        $data1 = [
            'title' => 'TestTittle1',
            'description' => 'TestDescription1',
            'create_user_id' => 1,
            'updated_user_id' => 1,
            'status' => 0,
        ];
        $post1 = Post::createNewPost($data1);

        $data2 = [
            'title' => 'TestTittle2',
            'description' => 'TestDescription2',
            'create_user_id' => 1,
            'updated_user_id' => 1,
            'status' => 1,
        ];
        $post2 = Post::createNewPost($data2);

        // Mock the request
        $request = new Request([
            'search-keyword' => 'TestTittle',
            'current-route' => 'postlist.index',
        ]);

        // Call the export method
        $postService = new PostService();
        $response = $postService->export($request);

        // Verify the response is a StreamedResponse
        $this->assertInstanceOf(StreamedResponse::class, $response);

        // Capture the CSV output
        ob_start();
        $response->sendContent();
        $csvOutput = ob_get_clean();

        // Expected CSV headers and content
        $expectedCsvOutput = "id,title,description,status,create_user_id,updated_user_id,deleted_user_id,created_at,updated_at,deleted_at\n" . "{$post1->id},TestTittle1,TestDescription1,0,1,1,,\"{$post1->created_at}\",\"{$post1->updated_at}\",\n" . "{$post2->id},TestTittle2,TestDescription2,1,1,1,,\"{$post2->created_at}\",\"{$post2->updated_at}\",\n";

        // Verify the CSV content
        $this->assertEquals($expectedCsvOutput, $csvOutput);
    }
    public function test_Post_uploadCsv(): void
    {
        // Retrieve an existing user or create one
        $user = User::first() ?? User::factory()->create();
        Auth::login($user);

        // Create a sample CSV content
        $csvContent = "title,description,status\n" . "Te1,TestDescription1,0\n" . "Te2,TestDescription2,1\n";

        // Save the CSV content to a temporary file
        Storage::fake('local');
        $file = UploadedFile::fake()->createWithContent('posts.csv', $csvContent);

        // Mock the request
        $request = new Request();
        $request->files->set('csvfile', $file);

        // Call the uploadCsv method
        $postService = new PostService();
        $result = $postService->uploadCsv($request);

        // Debugging step: Output the result
        fwrite(STDOUT, print_r($result, true));

        // Verify the result
        $this->assertArrayHasKey('success', $result, 'The result does not contain the success key.');
        $this->assertEquals('CSV data uploaded successfully.', $result['success']);

        // Verify that the posts were created in the database
        $this->assertDatabaseHas('posts', [
            'title' => 'Te1',
            'description' => 'TestDescription1',
            'status' => 0,
            'create_user_id' => $user->id,
            'updated_user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Te2',
            'description' => 'TestDescription2',
            'status' => 1,
            'create_user_id' => $user->id,
            'updated_user_id' => $user->id,
        ]);
    }

    public function test_Post_uploadCsv_withErrors(): void
    {
        // Retrieve an existing user or create one
        $user = User::first() ?? User::factory()->create();
        Auth::login($user);

        // Create a sample CSV content with errors
        $csvContent = "title,description,status\n" . "Te1,TestDescription1,0\n" . "Te2,TestDescription2,1\n"; // Duplicate title

        // Save the CSV content to a temporary file
        Storage::fake('local');
        $file = UploadedFile::fake()->createWithContent('posts.csv', $csvContent);

        // Mock the request
        $request = new Request();
        $request->files->set('csvfile', $file);

        // Call the uploadCsv method
        $postService = new PostService();
        $result = $postService->uploadCsv($request);

        // Debugging step: Output the result
        fwrite(STDOUT, print_r($result, true));

        // Verify the result
        $this->assertArrayHasKey('error_html', $result, 'The result does not contain the error_html key.');
        $this->assertContains('The title \'Te1\' has already been taken.', $result['error_html']);

        // Verify that only the first post was created in the database
        $this->assertDatabaseHas('posts', [
            'title' => 'Te1',
            'description' => 'TestDescription1',
            'status' => 0,
            'create_user_id' => $user->id,
            'updated_user_id' => $user->id,
        ]);

        $this->assertDatabaseMissing('posts', [
            'title' => 'Te1',
            'description' => 'TestDescription2',
            'status' => 1,
        ]);
    }

    public function test_createUserInRegister_with_image_storage(): void
    {
        // Ensure the public/img directory exists
        if (!file_exists(public_path('img'))) {
            mkdir(public_path('img'), 0777, true);
        }

        // Create a fake image file
        $file = UploadedFile::fake()->image('profile.jpg');

        // Move the file to the public/img directory
        $imageName = time() . '.' . $file->extension();
        $file->move(public_path('img'), $imageName);
        $profilePath = 'img/' . $imageName;

        // Create a user data array with the profile path
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'phone' => '1234567890',
            'date' => '1990-01-01',
            'address' => '123 Main St',
            'profile_path' => $profilePath,
            'type' => 'Admin',
        ];

        // Mock the authenticated user
        $adminUser = User::first() ?? User::factory()->create();
        Auth::login($adminUser);

        // Call the createUserInRegister method
        $user = User::createUserInRegister($userData);

        // Verify the user is created in the database
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '1234567890',
            'dob' => '1990-01-01',
            'address' => '123 Main St',
            'type' => 0, // Admin
            'create_user_id' => $adminUser->id,
            'updated_user_id' => $adminUser->id,
            'profile' => $profilePath,
        ]);

        // Verify the image was stored in the real filesystem
        $this->assertFileExists(public_path($profilePath));

        // Clean up: remove the test image file
        unlink(public_path($profilePath));
    }
}
