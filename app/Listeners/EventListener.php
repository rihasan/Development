<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Subscribers\EventSubscriber;

// User Models Event
use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserUpdated;
use App\Events\Models\User\UserDeleted;

// Post Models Event
use App\Events\Models\Post\PostCreated;
use App\Events\Models\Post\PostUpdated;
use App\Events\Models\Post\PostDeleted;

// Comment Models Event
use App\Events\Models\Comment\CommentCreated;
use App\Events\Models\Comment\CommentUpdated;
use App\Events\Models\Comment\CommentDeleted;



class EventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {

        // User Models Event
        if ($event instanceof UserCreated) {
            Mail::to($event->user)->send(new WelcomeMail($event->user));
            // dump('UserCreated mail triggered.');
        }elseif ($event instanceof UserUpdated) {
            dump('UserUpdated mail triggered.');
        }elseif($event instanceof UserDeleted){
            dump('UserDeleted mail triggered.');
        }

        // Post Models Event
        if ($event instanceof PostCreated) {
            dump('PostCreated mail triggered.');
        }elseif ($event instanceof PostUpdated) {
            dump('PostUpdated mail triggered.');
        }elseif($event instanceof PostDeleted){
            dump('PostDeleted mail triggered.');
        }

        // Comment Models Event
        if ($event instanceof CommentCreated) {
            dump('CommentCreated mail triggered.');
        }elseif ($event instanceof CommentUpdated) {
            dump('CommentUpdated mail triggered.');
        }elseif($event instanceof CommentDeleted){
            dump('CommentDeleted mail triggered.');
        }
    }
}
