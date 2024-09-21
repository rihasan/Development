<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;
use App\Models\User;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/users', function(Request $request){
    // dump($request);
    return new JsonResponse([
        'data' => 'API Route is Working.'
    ]);
});

Route::get('/users/{id}', function (User $id)
{
    return new JsonResponse([
        'data' => $id
    ]);
});

Route::post('/users', function()
{
    return new JsonResponse([
        'data' => 'Posted.'
    ]);
});

Route::patch('/users/{id}', function(User $id){
    return new JsonResponse([
        'data' => 'Patched'
    ]);
});

Route::delete('/users/{id}', function(User $id){
    return new JsonResponse([
        'data' => 'Deleted'
    ]);
});