<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::loginUsingId(3);
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return auth()->user()->current_plan->cancelled();
});

Route::get('/subscription', function () {
    $user = Auth::user();
    return Auth::user()->subscribed('premium')?'yes you have sunscribed to premium':'no you are still under basic' ;
});



Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::middleware('auth')->group(function () {
    Route::name('subscriptions.store')->get('/subscriptions/store/{plan}', 'CreateSubscriptionController');
    Route::get('billing', 'BillingController@index')->name('billing');
    Route::get('cancel', 'CancelSubscriptionController@index')->name('cancel');
    Route::get('resume', 'ResumeSubscriptionController@index')->name('resume');
});
