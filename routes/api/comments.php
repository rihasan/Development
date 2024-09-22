<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

// Route::apiResource('/comments',CommentController::class);

Route::group([

	'as' => 'comments.'

], function(){

	Route::get('/comments', [CommentController::class, 'index'])->name('index');
	Route::post('/comments', [CommentController::class, 'store'])->name('store');
	Route::get('/comments/{comment}', [CommentController::class, 'show'])->name('show');
	Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('update');
	Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('delete');

});