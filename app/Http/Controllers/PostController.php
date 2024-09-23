<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StorePostRequest;
// use App\Http\Requests\UpdatePostRequest;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
// use Illuminate\Http\Resources\Json\ResourceCollection;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index(Request $request)
    {

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
     * @return PostResource
     */
    public function store(Request $request)
    {
        // Before DB transaction method was as follows

        // $created = Post::query()->create([
        //     'title' => $request->title,
        //     'body' => $request->body,
        // ]);

        // return new JsonResponse([
        //     'data' => $created
        // ]);


        $created = DB::transaction(function() use ($request){

        $created = Post::query()->create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        $created->users()->sync($request->user_ids);

        return $created;

        });

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
    public function update(Request $request, Post $post)
    {

        // $post->update($request->only(['title', 'body']));

        $updated = $post->update([
            'title' => $request->title ?? $post->title,
            'body' => $request->body ?? $post->body,
        ]);

        if (!$updated) {

            return new JsonResponse([
                'errors' => 'Failed to update model.'                
            ], 400);
        }

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $deleted = $post->forceDelete();
        
        if (!$deleted) {
            return new JsonResponse([
                'errors' => [
                    'Could not delete the resource.'
                ]
            ], 400);
        }

        return new JsonResponse([
            'data' => 'Post deleted.'
        ]);
    }
}
