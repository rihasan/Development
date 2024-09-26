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



class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $pageSize = $request->pageSize ?? 20;
        $comments = Comment::query()->paginate($pageSize);

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     * @return CommentResurce
     */
    public function store(Request $request, CommentRepository $repository)
    {
        // Create the comment
        $created = Comment::create($request->only([
            'body',
            'user_id',
            'post_id',
        ]));

        return new CommentResource($created);
    }



    /**
     * Display the specified resource.
     * @return CommentResurce
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     * @return CommentResurce | JsonResponse
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
     * Remove the specified resource from storage.
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
