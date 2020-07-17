<?php

namespace App\Listeners;

use App\User;
use Illuminate\Queue\InteractsWithQueue;
use App\Listeners\initial_payment_listener;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class initial_payment_listener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(initial_payment_listener $event)
    {

        $user = User::findOrFail(1);

        $order = $event->order;

        $user->notify(new YourNewSubscription($order, $user));
        // Notification::send($user, new YourNewSubscription($event->order));

    }
}
