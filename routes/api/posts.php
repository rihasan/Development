<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Route::apiResource('/posts',PostController::class);

Route::group([
	
	'as' => 'posts.'
	
], function(){

	Route::get('/posts', [PostController::class, 'index'])->name('index');
	Route::post('/posts', [PostController::class, 'store'])->name('store');
	Route::get('/posts/{post}', [PostController::class, 'show'])->name('show');
	Route::patch('/posts/{post}', [PostController::class, 'update'])->name('update');
	Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('delete');

});