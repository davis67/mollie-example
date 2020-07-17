<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
 use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'trial_ends_at', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     *attach to the users collection
     * @return array An array of strings
     */
    protected $appends = ['current_subscription', 'status'];

     /**
     * Get the receiver information for the invoice.
     * Typically includes the name and some sort of (E-mail/physical) address.
     *
     * @return array An array of strings
     */
    public function getInvoiceInformation()
    {
        return [$this->name, $this->email];
    }

    /**
     * Get additional information to be displayed on the invoice.
     * Typically a note provided by the customer.
     *
     * @return string|null
     */
    public function getExtraBillingInformation()
    {
        return null;
    }

    /**
     * Get the current subscription plan
     */
    public function getCurrentSubscriptionAttribute()
    {
        return auth()->user()->subscriptions->isEmpty() ? null : $this->subscriptions->first();
    }

    /**
     * Get the subscription status
     */
    public function getStatusAttribute()
    {
         if ($this->onTrial()) {
            return 'onTrial';
        }

        if ($this->onGracePeriod()) {
            return 'onGracePeriod';
        }

        if ($this->cancelled()) {
            return 'cancelled';
        }

        if ($this->ended()) {
            return 'ended';
        }

        if ($this->active()) {
            return 'active';
        }

        return 'inactive';
    }

    /**
     * Determine if the subscription is active.
     */
    protected function active(): bool
    {
        return is_null($this->current_subscription->ends_at) || $this->onTrial() || $this->onGracePeriod();
    }

    /**
     * Determine if the subscription has ended and the grace period has expired.
     */
    protected function ended(): bool
    {
        return $this->current_subscription->cancelled() && !$this->current_subscription->onGracePeriod();
    }

    /**
     * Determine if the subscription is within its trial period.
     */
    protected function onTrial(): bool
    {
        return $this->trial_ends_at || Carbon::parse($this->current_subscription->trial_ends_at)->isFuture();
    }

    /**
     * Determine if the subscription is within its grace period after cancellation.
     */
    protected function onGracePeriod(): bool
    {
        return $this->current_subscription->ends_at && Carbon::parse($this->current_subscription->ends_at)->isFuture();
    }

    /**
     * Determine if the subscription is recurring and not on trial.
     */
    protected function recurring(): bool
    {
        return !$this->onTrial() && !$this->current_subscription->cancelled();
    }

    /**
     * Determine if the subscription is no longer active.
     */
    protected function cancelled(): bool
    {
        return !is_null($this->current_subscription->ends_at);
    }

    /**
     * Determine if the user has a running subscription
     */

     public function hasRunningSubscription(): bool
    {
        $hasActiveSubscription = false;

        foreach ($this->subscriptions as $subscription) {
            if ($subscription->active()) {
                $hasActiveSubscription = true;
            }
        }

        return $hasActiveSubscription;
    }

    /**
     * Dertemine Users current cycle
     */

    public function currentCycle(){
        return Carbon::parse($this->current_subscription->cycle_ends_at)->format('m/d/Y');
    }
}
