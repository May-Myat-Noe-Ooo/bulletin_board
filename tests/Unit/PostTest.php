<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_Post_store(): void
    {
        $data=[ 'title' => 'TestTitle2',
        'description' => 'description1',
        'create_user_id'=>1,
        'updated_user_id' =>1
    ];
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
}
