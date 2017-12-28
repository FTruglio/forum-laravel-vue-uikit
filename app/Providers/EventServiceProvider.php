<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // When this
        'App\Events\ThreadReceivedNewReply' => [
            // Then this
            'App\Listeners\NotifyMentionedUsers',
            'App\Listeners\NotifySubscribers',
        ],

        Registered::class => [
            // Then this
            'App\Listeners\SendEmailConfirmationRequest',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
