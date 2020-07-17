<?php

namespace App\Subscribers;

use App\User;
use App\Notifications\YourFailedOrder;
use App\Notifications\YourNewSubscription;
use App\Notifications\YourRenewedSubscription;
use App\Notifications\YourCancelledSubscription;

class PaymentEventHandler
{
	public function onFirstPaymentPaid($event)
	    {
	    	dd($event);
	        $order = $event->order;
	        $user = User::find($order->owner_id);
	        $user->notify(new YourNewSubscription($order, $user));
	    }

	    public function onPaymentPaid($event)
	    {
	        $order = $event->order;
	        $user = User::find($order->owner_id);
	        $user->notify(new YourRenewedSubscription($order, $user));
	    }

	    public function onPaymentFailed($event)
	    {
	        $order = $event->order;
	        $user = User::find($order->owner_id);
	        $user->notify(new YourFailedOrder($order, $user));
	    }

	    public function onSubscriptionCancelled($event)
	    {
	        $subscription = $event->subscription;
	        $user = User::find($subscription->owner_id);
	        $user->notify(new YourCancelledSubscription($subscription, $user));
	    }

	    public function subscribe($events)
	    {
	        // First payment paid
	        $events->listen(
	            'Laravel\Cashier\Events\FirstPaymentPaid',
	            'App\Subscribers\PaymentEventHandler@onFirstPaymentPaid'
	        );

	        // Payment paid
	        $events->listen(
	            'Laravel\Cashier\Events\OrderPaymentPaid',
	            'App\Subscribers\PaymentEventHandler@onPaymentPaid'
	        );

	        // Payment failed
	        $events->listen(
	            [
	                'Laravel\Cashier\Events\FirstPaymentFailed',
	                'Laravel\Cashier\Events\OrderPaymentFailed',
	            ],
	            'App\Subscribers\PaymentEventHandler@onPaymentFailed'
	        );

	        // Subscription cancelled
	        $events->listen(
	            'Laravel\Cashier\Events\SubscriptionCancelled',
	            'App\Subscribers\PaymentEventHandler@onSubscriptionCancelled'
	        );
	    }
}
