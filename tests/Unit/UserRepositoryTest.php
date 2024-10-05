<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Exceptions\GeneralJsonException;
use Illuminate\Support\Str;


class UserRepositoryTest extends TestCase
{
  
  public function test_create()
  {
    // Goals: Test create() actually create records in DB
    
    // Arrange / replicate env
    $repository = $this->app->make(UserRepository::class);

    // Source of truth
    $data = [
        'name' => 'Hena',
        'email' => 'hena'.str::random(3).'@gamil.com',
        'password' => 'secret',
    ];

    // Act / Compare result
    $result = $repository->create($data);

    // Assert
    $this->assertSame($data['name'], $result->name, 'Post User does not have the same name.');
    $this->assertSame($data['email'], $result->email, 'Post User does not have the same email.');


  }


  public function test_update()
  {
    // Goals: Test update() actually update an exisiting records in DB
    // Arrange / Replicate env
    $repository = $this->app->make(UserRepository::class);
    $dummyUser = User::factory(1)->create()->first();

    // Source of truth
    $data = [
        'name' => 'Amrit',
        'email' => 'amrit'.str::random(3).'@yahoo.com',
    ];

    // Act / Compare result
    $result = $repository->update($dummyUser, $data);

    // Assert
    $this->assertSame($data['name'], $result->name, 'Post User does not have the same name.');
    $this->assertSame($data['email'], $result->email, 'Post User does not have the same email.');

  }

  public function test_delete_throw_exception_while_try_to_delete_un_existed_post()
  {
    // Arrange
    $repository = $this->app->make(UserRepository::class);
    $data = User::factory()->make();

    // Act
    $this->ExpectException(GeneralJsonException::class);
    $deleted = $repository->forceDelete($data);

  }

  public function test_delete()
  {
    // Goals: Test if forceDelete() actually delete records
    // Arrange / Replicate env
    $repository = $this->app->make(UserRepository::class);

    $dummyUser = User::factory()->create();

    // Act / Compare result
    $result = $repository->forceDelete($dummyUser);

    // verify if actually deleted
    $found = User::query()->find($dummyUser->id);
    $this->assertSame(null, $found, 'User is not deleted.');



  }



}
