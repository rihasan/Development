<?php

namespace App\Subscribers;

use Illuminate\Events\Dispatcher;

use Illuminate\Support\Facades\Event;

use App\Listeners\EventListener;

// User Models Events
use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserUpdated;
use App\Events\Models\User\UserDeleted;

// Post Models Events
use App\Events\Models\Post\PostCreated;
use App\Events\Models\Post\PostUpdated;
use App\Events\Models\Post\PostDeleted;

// Comment Models Events
use App\Events\Models\Comment\CommentCreated;
use App\Events\Models\Comment\CommentUpdated;
use App\Events\Models\Comment\CommentDeleted;




class EventSubscriber 

{
	public function subscribe(Dispatcher $events)
	{
		// User Models Events
		$events->listen(UserCreated::class,[EventListener::class, 'handle']);
		$events->listen(UserUpdated::class,[EventListener::class, 'handle']);
		$events->listen(UserDeleted::class,[EventListener::class, 'handle']);

		// Post Models Events
		$events->listen(PostCreated::class,[EventListener::class, 'handle']);
		$events->listen(PostUpdated::class,[EventListener::class, 'handle']);
		$events->listen(PostDeleted::class,[EventListener::class, 'handle']);

		// Comment Models Events
		$events->listen(CommentCreated::class,[EventListener::class, 'handle']);
		$events->listen(CommentUpdated::class,[EventListener::class, 'handle']);
		$events->listen(CommentDeleted::class,[EventListener::class, 'handle']);
	}
}