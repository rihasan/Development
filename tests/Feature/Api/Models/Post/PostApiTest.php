<?php

namespace Tests\Feature\Api\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Post;
use App\Events\Models\Post\PostCreated;
use App\Events\Models\Post\PostUpdated;
use App\Events\Models\Post\PostDeleted;

use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;






class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        // Arrange || Loads data from db
        $posts = Post::factory(10)->create();
        // map the posts id in array 
        // means this line extracts the IDs of all posts into a collection called $post_ids
        $post_ids = $posts->map(fn ($post) => $post->id);

        // Act || Call Index end-point
        $response = $this->json('get', 'api/posts');

        // Assert status
        $response->assertStatus(200);

        // verify records
        // dump($response->json());
        // $data = $response->json('data.19.id');
        $data = $response->json('data');
        collect($data)->each(fn ($post) => $this->assertTrue(in_array($post['id'], $post_ids->toArray())));
        // dump($data);

    }


    public function test_show()
    {
        // Arrange
        $posts = Post::factory()->create();

        // Act
        $response = $this->json('get', 'api/posts/'.$posts->id);

        // Assert
        $result = $response->assertStatus(200)->json('data');
        $this->assertEquals(data_get($result, 'id'), $posts->id, 'Response id is not same as Model id.');

    }


    public function test_create()
    {
        // Arrange
        Event::fake();
        $posts = Post::factory()->make();
        
        // Act
        $response = $this->json('post', 'api/posts', $posts->toArray());

        // Assert
        $result = $response->assertStatus(201)->json('data');

        Event::assertDispatched(PostCreated::class);
        $result = collect($result)->only(array_keys($posts->getAttributes()));

        $result->each(function($value, $field) use ($posts){
            $this->assertSame(data_get($posts, $field), $value, 'Fillable is not same.');
        });


    }


    public function test_updated()
    {
        // Arraange
        $posts = Post::factory()->create();
        $posts2 = Post::factory()->make();
        Event::fake();
        $fillables = collect((new Post())->getFillable());

        // Act
        $fillables->each(function ($toUpdate) use($posts, $posts2){
            $response = $this->json('patch', 'api/posts/'.$posts->id,[
                $toUpdate => data_get($posts2, $toUpdate)
            ]);

        // Assert
        $result = $response->assertStatus(200)->json('data');
        Event::assertDispatched(PostUpdated::class);
        $this->assertSame(data_get($posts2, $toUpdate), data_get($posts->refresh(), $toUpdate),'Failed to update.');

        });
    


    }

    public function test_delete()
    {
        // Arrange
        Event::fake();
        $posts = Post::factory()->create();

        // Assert
        $response = $this->json('delete', 'api/posts/'.$posts->id);

        $result = $response->assertStatus(200);

        Event::assertDispatched(PostDeleted::class);

        $this->expectException(ModelNotFoundException::class);
        
        Post::query()->findOrFail($posts->id);

    }





}
