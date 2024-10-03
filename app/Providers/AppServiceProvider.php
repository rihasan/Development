<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Event;

// use App\Events\Models\User\UserCreated;
// use App\Listeners\EventListener;

use App\Subscribers\EventSubscriber;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Event::listen(UserCreated::class, EventListener::class);
       
        // Register the UserEventListener subscriber 
        Event::subscribe(EventSubscriber::class);

    }
}
