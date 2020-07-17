<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PremiumController extends Controller
{
	 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('premium');
    }

    /**

     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(){
    	return view('subscriptions.premium');
    }
}
