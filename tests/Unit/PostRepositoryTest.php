<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\Post;
use App\Repositories\PostRepository;
use App\Exceptions\GeneralJsonException;

class PostRepositoryTest extends TestCase
{
    public function test_create() {
        // 1. Define the Goals
        // test if create() actually creates a record in the DB
        
        // 2. Replicate the env / restriction
        $repository = $this->app->make(PostRepository::class);

        // 3. Define the source of truth
        $data = [
            'title' => 'hena',
            'body' => [],
        ];

        // 4. compare the result
        $result = $repository->create($data);

        $this->assertSame($data['title'], $result->title, 'Post created does not have the same title.');

    }

    // Alternative way
    // 
    // public function test_create(){
    //     // Arrange
    //     $postRepository = new PostRepository();
    //     $data = [
    //         'title' => 'My First Post',
    //         'body' => 'This is the content of the first post.'
    //     ];

    //     // Act
    //     $post = $postRepository->create($data);

    //     // Assert
    //     $this->assertInstanceOf(Post::class, $post);  // Check if $post is a Post instance
    //     $this->assertEquals('my first post', $post->title);  // Check if the title matches
    //     $this->assertEquals('This is the content of the first post.', $post->body);  // Check if the content matches
    
    // }


    public function test_update() {
        
        // 1. Goals: make sure we can update a post using update() method
        // 2. Replicate the env /restriction
            // $repository = $this->app->make(PostRepository::class);
            $repository = new PostRepository();
            $dummyPost = Post::factory(1)->create()[0];
            // $dummyPost = Post::factory()->create();

        // 3. Source of truth
            $data = [
                'title' => 'abcd1234',
            ];
        
        // 4. Result compaire
            $updated = $repository->update($dummyPost, $data);
            $this->assertSame($data['title'], $updated->title, 'Post Updated does not have same title ');
        
    }

    public function test_delete_throw_exception_while_try_to_delete_un_existed_post()
    {
        // Arrange
        $repository = New PostRepository();
        $data = Post::factory(1)->make()->first();

        // Act
        $this->ExpectException(GeneralJsonException::class);
        $deleted = $repository->forceDelete($data);
    }


    public function test_delete() {
        // 1. Goals: forceDelete() can delete the post
        // 2. Replicate env
            $repository = $this->app->make(PostRepository::class);
            // $dummyPost = Post::factory(1)->create()->first();
            $dummyPost = Post::factory()->create();

        // 3. Compaire
            $deleted = $repository->forceDelete($dummyPost);

        // 4. Verify if actually deleted
            $found = Post::query()->find($dummyPost->id);

            $this->assertSame(null, $found, 'Post is not deleted.');
        
    }
}
