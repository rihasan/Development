<?php

namespace Tests\Feature\Api\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserUpdated;
use App\Events\Models\User\UserDeleted;

use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class UserApiTest extends TestCase
{

    use RefreshDatabase;

    protected $uri = 'api/users';

    public function test_index()
    {    
        // Arrane || Load data from DB
        $users = User::factory(10)->create();
        // Map the User id in array
        // Means this line extracts the IDs of all users into a collection named $user_ids
        $user_ids = $users->map(fn ($user) => $user->id);

        // Act || Call index-end point
        $response = $this->json('get', $this->uri);

        // Assert status
        $response->assertStatus(200);

        // verify records
        // dump($response->json());
        // $data = $response->json('data.9.name');
        // dump($data);
        
        $data = $response->json('data');
        collect($data)->each(fn ($user) => $this->assertTrue(in_array($user['id'], $user_ids->toArray())));

    }


    public function test_show()
    {
        // Arrange
        $users = User::factory()->create();

        // Act
        $response = $this->json('get', $this->uri.'/'.$users->id);

        // Assert
        $result = $response->assertStatus(200)->json('data');
        $this->assertEquals(data_get($result, 'id'), $users->id, 'Response id is not same as the Model id.');

    }

    // public function test_create()
    // {
    //     // This houses errors with password HASH
    //     // Arrange
    //     $users = User::factory()->make();
    //     // dd($users->toArray()); // Add this to check the attributes

    //     // Act
    //     $response = $this->json('post', $this->uri, $users->toArray());

    //     // Assert
    //     $result = $response->assertStatus(201)->json('data');

    //     $result = collect($result)->only(array_keys($users->getAttributes()));

    //     $result->each(function($value, $filed) use($users){
    //         $this->assertSame(data_get($users, $filed), $value, 'Fillable is not same.');
    //     });

    // }
    

    public function test_create()
    {
        // Arrange
        Event::fake();
        $userData = User::factory()->make()->toArray();

        // Act
        $response = $this->json('post', $this->uri, $userData);

        // Assert
        $response->assertStatus(201);
        $result = $response->json('data');

        Event::assertDispatched(UserCreated::class);
        // Check the expected fields
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('email', $result);
        // $this->assertArrayHasKey('email_verified_at', $result);

        // Assert that returned data matches input (excluding password)
        $this->assertEquals($userData['name'], $result['name']);
        $this->assertEquals($userData['email'], $result['email']);

    }


    // public function test_update()
    // {
    //     // This is ok but triggered events trice as fillables looped trice
    //     // Arrange
    //     $users = User::factory()->create();
    //     $updateData = User::factory()->make();
    //     Event::fake();
    //     $fillables = collect((new User())->getFillable());

    //     // Act
    //     $fillables->each(function($toUpdate) use($users, $updateData){
    //         $response = $this->json('patch', $this->uri.'/'.$users->id, [
    //             $toUpdate => data_get($updateData, $toUpdate)
    //         ]);
    //     // Assert
    //     $result = $response->assertStatus(200)->json('data');
    //     Event::assertDispatched(UserUpdated::class);
    //     $this->assertSame(data_get($updateData, $toUpdate), data_get($users->refresh(), $toUpdate), 'Failed to update.');

    //     });

    // }



    public function test_update()
    {
        // Arrange
        $users = User::factory()->create();
        $updateData = User::factory()->make()->toArray(); // Get all the attributes for updating
        Event::fake();
        // Act
        $response = $this->json('patch', $this->uri.'/'.$users->id, $updateData);

        // Assert
        $result = $response->assertStatus(200)->json('data');
        Event::assertDispatched(UserUpdated::class);
        // Check that the user was updated
        foreach ($updateData as $key => $value) {
            $updatedValue = data_get($users->refresh(), $key);
            
            if ($updatedValue instanceof \Carbon\Carbon) {
                $this->assertSame($value, $updatedValue->toISOString(), 'Failed to update.');
            } else {
                $this->assertSame($value, $updatedValue, 'Failed to update.');
            }
        }
    }


    
    public function test_delete()
    {
        // Arrange
        Event::fake();
        $user = User::factory()->create();

        // Assert 
        $response = $this->json('delete', $this->uri.'/'.$user->id);
        $result = $response->assertStatus(200);
        Event::assertDispatched(UserDeleted::class);
        $this->expectException(ModelNotFoundException::class);
        User::query()->findOrFail($user->id);
    }


}
