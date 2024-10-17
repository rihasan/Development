<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
// use App\Http\Requests\UpdatePostRequest;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Repositories\PostRepository;
// use App\Exceptions\GeneralJsonException;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index(Request $request)
    {

        // throw new GeneralJsonException ("An error occurred", 422);
        // abort(404);
        
        $pageSize = $request->pageSize ?? 20;
        $posts = Post::query()->paginate($pageSize);

        // echo "<pre>";
        // print_r($posts);
        // dump($posts);
        // dd($posts);

        return PostResource::collection($posts);

    }

    /**
     * Store a newly created resource in storage.
     * @param StorePostRequest $request
     * @return PostResource
     */
    public function store(StorePostRequest $request, PostRepository $repository)
    {
        $created = $repository->create($request->only([
            'title',
            'body',
            'user_ids',
        ]));

        return new PostResource($created);
    }

    /**
     * Display the specified resource.
     * @return PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     * @return PostResource | JsonResponse
     */
    public function update(Request $request, Post $post, PostRepository $repository)
    {
        $post = $repository->update($post, $request->only([
            'title',
            'body',
            'user_ids',
        ]));

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, PostRepository $repository)
    {
        $deleted = $repository->forceDelete($post);

        return new JsonResponse([
            'data' => 'Post deleted.'
        ]);
    }
}
