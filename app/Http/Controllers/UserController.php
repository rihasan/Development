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



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Display the specified resource.
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(User $user, UserRepository $repository)
    {
        $deleted = $repository->forceDelete($user);
        
        return new JsonResponse([
            'data' => 'User Deleted.'
        ]);
    }
}