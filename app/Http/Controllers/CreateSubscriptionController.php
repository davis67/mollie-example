<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CreateSubscriptionController extends Controller
{
    /**
     * @param string $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(string $plan)
    {
        $user = Auth::user();
        if($user->subscribed($plan) && $user->current_plan->plan != $plan) {
            $user->subscription($user->current_plan->name)->swapNextCycle($plan);
            return back()->withMessage('you have successfully changed your subscription.The effect will start at the end of current plan');
        }

        if(!$user->subscribed($plan)) {

            $name = ucfirst($plan) . ' membership';

            // $result = $user->newSubscriptionViaMollieCheckout($name, $plan)->create();
            $result = $user->newSubscription($name, $plan)->create();
            if(is_a($result, RedirectResponse::class)) {
                return $result; // Redirect to Mollie checkout
            }

            // $result is a \Laravel\Cashier\Subscription model
            return back()->with('status', 'Welcome to the ' . $plan . ' plan');
        }

        return back()->with('status', 'You are already on the ' . $plan . ' plan');
    }
}
