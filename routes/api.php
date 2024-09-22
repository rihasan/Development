<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\Routes\RouteHelper;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


RouteHelper::includeRoutesFiles(__DIR__ . '/api');

// require __DIR__ . '/api/users.php';
// require __DIR__ . '/api/posts.php';
// require __DIR__ . '/api/comments.php';