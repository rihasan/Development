<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StorePostRequest;
// use App\Http\Requests\UpdatePostRequest;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
// use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Repositories\UserRepository;


/**
 * @group User Management
 *
 *APIs to manage the user resource
 * 
**/

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * Gets a list of users.
     *
     * @queryParam pageSize int Size per page. Default to 20. 
     * 
     * @queryParam page int Page to view
     *
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     * 
     * @return ResourceCollection
     */
    

    public function index(Request $request)
    {
        $pageSize = $request->pageSize ?? 20;
        $users  = User::query()->paginate($pageSize);

        return UserResource::collection($users);
    }

     /**
     * Store a newly created resource in storage.
     * @bodyParam name string required Name of the user. Example: John Doe
     * @bodyParam email string required Email of the user. Example: doe@doe.com
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     * @param \Illuminate\Http\Request $request
     * @return UserResource
     */
    
    
    public function store(Request $request, UserRepository $repository)
    {
        $created = $repository->create($request->only([
            'name' ,
            'email',
            'password',
        ]));

        return new UserResource($created);
    }

    /**
     * Display the specified users.
     *
     * Gets a specified user.
     *
     * @urlParam id int required user ID
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     * 
     * @return UserResource
     */
    
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified user in storage.
     * @bodyParam name string Name of the user. Example: John Doe
     * @bodyParam email string Email of the user. Example: doe@doe.com
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return UserResource | JsonResponse
     */
    
    public function update(Request $request, User $user, UserRepository $repository)
    {
        $user = $repository->update($user, $request->only([
            'name',
            'email',
            'password',
        ]));

        return new UserResource($user);
    }

    /**
     * Remove the specified user from storage.
     * @response 200 {
        "data": "User Deleted."
     * }
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function destroy(User $user, UserRepository $repository)
    {
        $deleted = $repository->forceDelete($user);
        
        return new JsonResponse([
            'data' => 'User Deleted.'
        ]);
    }
}