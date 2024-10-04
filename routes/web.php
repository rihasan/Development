<?php

use Illuminate\Support\Facades\Route;
use App\Mail\WelcomeMail;
use \Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    return view('welcome');
});

if (App::Environment('local')) {
    Route::get('/email', function() {
        $user = \App\Models\User::factory()->make();
        Mail::to($user)->send(new WelcomeMail($user));
        return "Mail sent";
    });
}