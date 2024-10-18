<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StorePostRequest;
// use App\Http\Requests\UpdatePostRequest;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Repositories\PostRepository;
// use App\Exceptions\GeneralJsonException;
use Illuminate\Support\Facades\Validator;
use App\Rules\IntegerArray;


/**
 * @group Post Management
 *
 *APIs to manage the post resource
 * 
**/

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     *
     * Gets a list of posts.
     *
     * @queryParam page_size int Size per page. Defaults to 20. Example: 20
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
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
     * Store a newly created post in storage.
     * @bodyParam title string required Title of the post. Example: Amazing Post
     * @bodyParam body string[] required Body of the post. Example: ["This post is super beautiful"]
     * @bodyParam user_ids int[] required The author ids of the post. Example: [1, 2]
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     * @param  PostStoreRequest  $request
     * @return PostResource
     */
    

    public function store(Request $request, PostRepository $repository)
    {
        $payload = $request->only([
            'title',
            'body',
            'user_ids',
        ]);

        $validator = Validator::make($payload,[
            'title' => 'required|string|max:256',
            'body' => ['required', 'string'],
            'user_ids' => [
                'array',
                'required',

                new IntegerArray(),

                // function ($attributes, $value, $fail){
                //     $integerOnly = collect($value)->every(fn ($element) => is_int($element));
                //     if (!$integerOnly) {
                //         $fail($attributes. ' can only be integer.');
                //         }
                //     }
                
                ]
            ],

            [
                'body.required' => 'Please insert a valid body for the post.',
            ],

            [
                'user_ids' => 'User ID'
            ]);


        // $errors = $validator->errors();
        // $errors = $validator->messages();

        // dump($validator->fails());
        // dump($validator->passes());
        // dump($validator->getData());
        // dump($validator->attributes());

        // dd($validator->failed());


        // $validator->after(function($validator){
        //     dump('this will dump');
        // });

        // dd($validator->validateString('test', 123));

        // $validator->validate();

        $created = $repository->create($payload);

        return new PostResource($created);
    }

    /**
     * Display the specified post.
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     * @param  \App\Models\Post  $post
     * @return PostResource
     */
    
    public function show(Post $post)
    {
        return new PostResource($post);
    }
    

    /**
     * Update the specified post in storage.
     * @bodyParam title string required Title of the post. Example: Amazing Post
     * @bodyParam body string[] required Body of the post. Example: ["This post is super beautiful"]
     * @bodyParam user_ids int[] required The author ids of the post. Example: [1, 2]
     * @apiResource App\Http\Resources\PostResource
     * @apiResourceModel App\Models\Post
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
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
     * Remove the specified post from storage.
     * @response 200 {
        "data": "Post deleted."
     * }
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    
    
    public function destroy(Post $post, PostRepository $repository)
    {
        $deleted = $repository->forceDelete($post);

        return new JsonResponse([
            'data' => 'Post deleted.'
        ]);
    }
}
