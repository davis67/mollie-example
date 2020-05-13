<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CancelSubscriptionController extends Controller
{
     /**

     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(){
    	$user = auth()->user();
		if($user->subscribed($user->current_plan->name)){
			$user->current_plan->cancel();
			return redirect()->back()->withMessage('You have succssfully cancelled a subscription');
		}
    	return redirect()->back()->withMessage('Your subscription couldnt be cancelled');
    }
}
