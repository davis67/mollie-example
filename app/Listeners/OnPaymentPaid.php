<?php

namespace App\Listeners;

use App\Mail\NewOrderPayment;
use App\Notifications\NewOrderPaid;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Events\OrderPaymentPaid;

class OnPaymentPaid
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
    public function handle(OrderPaymentPaid $event)
    {
        $user = User::findOrFail(1);

        $order = $event->order;

        Mail::to($user->email) ->send(new NewOrderPayment());

        // $user->notify(new NewOrderPaid($order, $user));
    }
}
