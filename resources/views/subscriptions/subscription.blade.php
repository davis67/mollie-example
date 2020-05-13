<!-- cancelled -->
@if(auth()->user()->current_plan && auth()->user()->current_plan->cancelled())
	<div class="col-12 mx-auto">
	    <h2 class="">Billing</h2>
	    <hr class="tw-border-b-2 w-full tw-border-gray-300"></hr>
	    <div class="jumbotron">
	      <h1 class="">Current Plan</h1>
	      <p class="lead">Your current subscription was cancelled. Your grace Period will expire on {{\Carbon\Carbon::parse(auth()->user()->current_plan->ends_at)->isoFormat('ll')}}</p>
	     	 <a href="{{route('resume')}}" class="btn btn-primary text-white">Resume</a>
			<a href="{{route('home')}}" class="btn btn-primary text-white">Change Plan</a>
	    </div>
	</div>
@endif

<!-- expired -->
@if(auth()->user()->current_plan && !auth()->user()->subscribed(auth()->user()->current_plan->name))
	<div class="col-12 mx-auto">
	    <h2 class="">Billing</h2>
	    <hr class="tw-border-b-2 w-full tw-border-gray-300"></hr>
	    <div class="jumbotron">
	      <h1 class="">Current Plan</h1>
	      <p class="lead">Your current subscription was expired on {{\Carbon\Carbon::parse(auth()->user()->current_plan->cycle_ended_at)->isoFormat('ll')}}.</p>
	     	 <a href="{{route('resume')}}" class="btn btn-primary text-white">Resume</a>
			<a href="{{route('home')}}" class="btn btn-primary text-white">Change Plan</a>
	    </div>
	</div>
@endif
<!-- current -->
@if(auth()->user()->current_plan && !auth()->user()->current_plan->cancelled() && auth()->user()->subscribed(auth()->user()->current_plan->name))
	<div class="col-12 mx-auto">
	    <h2 class="">Current Plan</h2>
	    <hr class="tw-border-b-2 w-full tw-border-gray-300"></hr>
	    <div class="jumbotron">
	     <p class="lead">Your are currently Subscribed to {{auth()->user()->current_plan->plan}}. Your Subscription will expire on {{\Carbon\Carbon::parse(auth()->user()->current_plan->cycle_ends_at)->isoFormat('ll')}}</p>
	     	 <a href="{{route('cancel')}}" class="btn btn-primary text-white">cancel plan</a>
			<a href="{{route('home')}}" class="btn btn-primary text-white">Change Plan</a>
	    </div>
	</div>
@endif
