<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResumeSubscriptionController extends Controller
{
      /**

     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(){
    	$user = auth()->user();
    	try{
    		if($user->current_plan->onGracePeriod()){
				$user->current_plan->resume();
				return redirect()->back()->withMessage('You have succssfully cancelled a subscription');
		}

    		return redirect()->back()->withMessage('You have succssfully resumed a subscription');
    	}catch(\Exception $e){
    		return redirect()->back()->withMessage($e->getMessage());
    	}
    	return redirect()->back()->withMessage('You have succssfully resumed a subscription');
    }
}
