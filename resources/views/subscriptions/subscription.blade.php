@if(Auth::user()->status === 'active')
<div class="alert alert-warning">
	<span>You are currently subscribed to {{auth()->user()->current_subscription->plan}}.Your  Subscription will expire on {{auth()->user()->currentCycle()}}</span>
</div>
@endif
@if(Auth::user()->status === 'inactive')
<div class="alert alert-warning">
	<span>You are not subscribed to any subscription</span>
</div>
@endif

@if(Auth::user()->status === 'onTrial')
<div class="alert alert-warning">
	@if(Auth::user()->trial_ends_at)
		<span>You are currently subscribed to Free trial.Please subscribe to access more features</span>
	@endif
	@if(optional(Auth::user()->current_subscription)->trial_ends_at)
		<span>You are currently subscribed to Free trial of {{auth()->user()->current_subscription->plan}} Your  Subscription will expire on {{auth()->user()->currentCycle()}}</span>
	@endif
</div>
@endif
