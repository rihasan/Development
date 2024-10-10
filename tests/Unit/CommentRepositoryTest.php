<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Repositories\CommentRepository;
use App\Exceptions\GeneralJsonException;
use Illuminate\Foundation\Testing\RefreshDatabase;



class CommentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create(): void
    {
        // Goals: Test create() actually create records in DB
        // Arrange / replicate env
        $repository = $this->app->make(CommentRepository::class);

        $user = User::factory()->create();
        $post = Post::factory()->create();

        $data = [
            'body' => 'This is comments body',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ];

        // Act / Compare result
        $result = $repository->create($data);
        
        // Assert
        $this->assertSame($data['body'], $result->body, 'Comment create does not have the same body');
        
    }

        public function test_update()
        {
            // Arrange /replicate env
            $repository = $this->app->make(CommentRepository::class);

            // Create a valid User and Post
            $user = User::factory()->create();
            $post = Post::factory()->create();

            // Create a comment associated with the created user and post
            $dummyComment = Comment::factory()->create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);

            $data = [
                'body' => 'This is patched body',
                // 'user_id' => $dummyComment->user_id, 
                // 'post_id' => $dummyComment->post_id, 

            ];

            // Act / Compare result
            $result = $repository->update($dummyComment, $data);

            // assert
            $this->assertSame($data['body'], $result->body, 'Comment updated does not have the same body.');

        }

        public function test_delete_throw_exception_while_try_to_delete_un_existed_post()
        {
            // Arrange / replicate env
            $repository = $this->app->make(CommentRepository::class);
            $data = Comment::factory()->make();

            // Act
            $this->ExpectException(GeneralJsonException::class);

            $deleted = $repository->forceDelete($data);

        }

        public function test_delete()
        {
            // Arrange / replicate env
           $repository = $this->app->make(CommentRepository::class);

            // $dummyComment = Comment::factory(1)->create()->first();
            // Create a valid User and Post
            $user = User::factory()->create();
            $post = Post::factory()->create();

            // Create a comment associated with the created user and post
            $dummyComment = Comment::factory()->create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);


            // Act / compare
           $result = $repository->forceDelete($dummyComment);

            // verify if actually deleted
           $found = Comment::query()->find($dummyComment->id);

            // Assert
            // $this->assertSame(null, $found, 'Comment is not deleted.');
            $this->assertNull($found, 'Comment is not deleted.');

        }



}
