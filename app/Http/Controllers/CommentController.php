<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreCommentRequest;
// use App\Http\Requests\UpdateCommentRequest;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
// use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Repositories\CommentRepository;

/**
 * @group Comment Management
 *
 *APIs to manage the comment resource
 * 
**/

class CommentController extends Controller
{
    /**
     * Display a listing of comments.
     *
     * Gets a list of comments.
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
        $pageSize = $request->pageSize ?? 20;
        $comments = Comment::query()->paginate($pageSize);

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created comment in storage.
     * @bodyParam body string[] required Body of the comment. Example: ["This comment is super beautiful"]
     * @bodyParam user_id int required The author id of the comment. Example: 1
     * @bodyParam post_id int required The post id that the comment belongs to. Example: 1
     * @apiResource App\Http\Resources\CommentResource
     * @apiResourceModel App\Models\Comment
     * @param \Illuminate\Http\Request $request
     * @return CommentResource
     */
    
    public function store(Request $request, CommentRepository $repository)
    {
        // Create the comment
        $created = $repository->create($request->only([
            'body',
            'user_id',
            'post_id',
        ]));

        return new CommentResource($created);
    }


    /**
     * Display the specified comment.
     * @apiResource App\Http\Resources\CommentResource
     * @apiResourceModel App\Models\Comment
     * @param \App\Models\Comment $comment
     * @return CommentResource
     */
    

    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }
    
    /**
     * Update the specified comment in storage.
     * @bodyParam body string[] Body of the comment. Example: ["This comment is super beautiful"]
     * @bodyParam user_id int The author id of the comment. Example: 1
     * @bodyParam post_id int The post id that the comment belongs to. Example: 1
     * @apiResource App\Http\Resources\CommentResource
     * @apiResourceModel App\Models\Comment
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Comment $comment
     * @return CommentResource | JsonResponse
     */
    
    public function update(Request $request, Comment $comment, CommentRepository $repository)
    {

        $updated = $repository->update($comment, $request->only([
            'body',
            'user_id',
            'post_id',
        ]));

        return new CommentResource($comment);
    }

    /**
     * Remove the specified comment from storage.
     * @response 200 {
        "data": "Comment deleted."
     * }
     * @param \App\Models\Comment $comment
     * @return JsonResponse
     */
    
    public function destroy(Comment $comment, CommentRepository $repository)
    {
        $deleted = $repository->forceDelete($comment);

        return new JsonResponse([
            'data' => 'Comment deleted.'
        ]);
    }
}
