<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Facades\DB;


/**
 * UserRepository manage User Model
 */

class UserRepository extends BaseRepository
{
	public function create (array $attributes)
	{
		return DB::transaction(function () use ($attributes) {

	       $created = User::query()->create([
	            'name' => data_get($attributes, 'name'),
	            'email' => data_get($attributes, 'email'),
	            'password' => data_get($attributes, 'password'),
       		 ]);

	       return $created;
		});
	}


	 /**
     * @param User $user
     * @param array $attributes
     * @return mixed
     */
    
	public function update($user, array $attributes)
	{
		return DB::transaction(function () use ($user, $attributes) {
		    
		  $updated = $user->update([
	            'name' => data_get($attributes, 'name', $user->name),
	            'email' => data_get($attributes, 'email', $user->email),
	            'password' => data_get($attributes, 'password', $user->password),
       		 ]);

		  if (!$updated) {
		  	throw new \Exception("Can not update user.");
		  	
		  }
		  
		  return $user;

		});
	}

	 /**
     * @param User $user
     * @return mixed
     */
    
	public function forceDelete($user)
	{
		return DB::transaction(function () use ($user) {

		    $deleted = $user->forceDelete();
		    if (!$deleted) {
		    	throw new \Exception("Can not delete user.");
		    }
		    return $deleted;
		});
	}

}