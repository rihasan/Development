<?php

namespace Tests\Feature\Api\Models\Comment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Comment;
use App\Events\Models\Comment\CommentCreated;
use App\Events\Models\Comment\CommentUpdated;
use App\Events\Models\Comment\CommentDeleted;

use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class CommentApiTest extends TestCase
{
    use RefreshDatabase;        

    protected $uri = 'api/comments';


    public function test_index()
    {
        // Arrange || Load data from DB
        $comments = Comment::factory(10)->create();
        // Map the comments id in array
        // Means this line extracts the IDs of all comments into a collection named $comment_ids
        $comment_ids = $comments->map(fn ($comment) => $comment->id);

        // Act || call index-end point
        $response = $this->json('get', $this->uri);

        // Assert Status
        $response->assertStatus(200);

        // Verify records
        // dump($response->json());
        // $data = $response->json('data.9.body');
        $data =  $response->json('data');
        collect($data)->each(fn ($comment) => $this->assertTrue(in_array($comment['id'], $comment_ids->toArray())));

    }


    public function test_show()
    {
        // Arrange
        $comments = Comment::factory()->create();

        // Act
        $response = $this->json('get', $this->uri.'/'.$comments->id);

        // Assert
        $result = $response->assertStatus(200)->json('data');
        $this->assertEquals(data_get($result, 'id'), $comments->id, 'Response id is not same as the Model id.');

    }


    public function test_create()
    {
        // Arrange
        Event::fake();
        $comments = Comment::factory()->make();

        // Act
        $response = $this->json('post', $this->uri, $comments->toArray());

        // Assert
        $result = $response->assertStatus(201)->json('data');

        Event::assertDispatched(CommentCreated::class);

        $result = collect($result)->only(array_keys($comments->getAttributes()));

        $result->each(function($value, $field) use($comments){
            $this->assertSame(data_get($comments, $field
            ), $value, 'Fillable mismatched.');
        });

    }


    public function test_update()
    {
        // Arrange
        $comments = Comment::factory()->create();
        $updateData = Comment::factory()->make()->toArray();
        Event::fake();
        // Act
        $response = $this->json('patch', $this->uri.'/'.$comments->id, $updateData);
        
        // Assert
        $result = $response->assertStatus(200)->json('data');
        Event::assertDispatched(CommentUpdated::class);
        
        // Check that the comment was updated
        foreach ($updateData as $key => $value) {
            $updatedValue = data_get($comments->refresh(), $key);
            if ($updatedValue instanceof \Carbon\Carbon){
                $this->assertSame($value, $updatedValue->toISOString(), 'Failed to update.');
                }else{
                    $this->assertSame($value, $updatedValue, 'Failed to update.');
                }
            }

    }


    public function test_delete()
    {
        // Arrange
        Event::fake();
        $comment = Comment::factory()->create();

        // Assert
        $response = $this->json('delete', $this->uri.'/'.$comment->id);
        
        $result = $response->assertStatus(200);

        Event::assertDispatched(Commentdeleted::class);

        $this->ExpectException(ModelNotFoundException::class);
        
        Comment::query()->findOrFail($comment->id);

    }


}
