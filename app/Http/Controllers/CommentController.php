<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreCommentRequest;
// use App\Http\Requests\UpdateCommentRequest;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $comments = Comment::query()->get();

        return new JsonResponse([
            'data' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // have problem with user_id & post_id 
        
        // Create the comment
        $created = Comment::create([
            'body' => $request->body,
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
        ]);

        return new JsonResponse([
            'data' => $created
        ], 201);
    }



    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new JsonResponse([
            'data' => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
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
                'errors' => [
                    'Failed to update resource.'
                ]
            ], 400);
        }

        return new JsonResponse([
            'data' => 'Comment updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
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
