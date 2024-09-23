<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreCommentRequest;
// use App\Http\Requests\UpdateCommentRequest;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
// use Illuminate\Http\Resources\Json\ResourceCollection;



class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return ResourceCollection
     */
    public function index()
    {

        $comments = Comment::query()->get();

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     * @return CommentResurce
     */
    public function store(Request $request)
    {

        // Create the comment
        $created = Comment::create([
            'body' => $request->body,
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
        ]);

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
    public function update(Request $request, Comment $comment)
    {
        // Validate the request
        $validated = $request->validate([
            'body' => 'required|string|max:500',
        ]);

        $updated = $comment->update([
            'body' => $request->body 
        ]);

        if (!$updated) {
            return new JsonResponse([
                'errors' => 'Failed to update resource.'
            ], 400);
        }

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(Comment $comment)
    {
        $deleted = $comment->forceDelete();

        if (!$deleted) {
            return new JsonResponse([
                'errors' => [
                    'Failed to delete resource.'
                ]
            ], 400);
        }

        return new JsonResponse([
            'data' => 'Comment deleted.'
        ]);
    }
}
