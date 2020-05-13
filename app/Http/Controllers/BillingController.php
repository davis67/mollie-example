<?php

namespace App\Http\Controllers;


class BillingController extends Controller
{
     /**

     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(){
    	return view('subscriptions.billing');
    }
}
