<?php

use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


require __DIR__ . '/api/users.php';
require __DIR__ . '/api/posts.php';
require __DIR__ . '/api/comments.php';