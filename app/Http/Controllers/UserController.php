<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StorePostRequest;
// use App\Http\Requests\UpdatePostRequest;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
// use Illuminate\Http\Resources\Json\ResourceCollection;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index()
    {
        $users  = User::query()->get();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     * @return UserResource
     */
    public function store(Request $request)
    {
        $created = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

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
    public function update(Request $request, User $user)
    {
        // dump($request);
        $updated = $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ?? $user->password,
        ]);

        if (!$updated) {

            return new JsonResponse([
                'errors' => 'Failed to updated Models'
            ], 400);
        }

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $deleted = $user->forceDelete();
        
        if (!$deleted) {
            return new JsonResponse([
                'errors' =>[
                    'Failed to delete resource.'
                ]
            ], 400);
        }

        return new JsonResponse([
            'data' => 'User Deleted.'
        ]);
    }
}