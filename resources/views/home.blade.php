@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Billing</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card" style="height: 320px;">
                                <div class="card-header">Basic</div>
                                <div class="card-body">
                                    <ul>
                                         @foreach(["User profile", "Hub Forum access","Access educational tools","Receive in-network discounts on teen training & apparel"] as $feature)
                                         <li>{{$feature}}</li>
                                         @endforeach
                                    </ul>
                                </div>
                                <div class="card-footer">
                                   <div class="card-footer">
                                    @if(auth()->user() && auth()->user()->current_plan->plan == 'basic' && !auth()->user()->current_plan->cancelled())
                                    <a href="{{route('billing', 'premium')}}" class="btn btn-primary">current plan</a>
                                    @else
                                    <a href="{{route('subscriptions.store', 'premium')}}" class="btn btn-primary">Subscribe</a>
                                    @endif
                                </div>
                                </div>
                            </div>
                            <div></div>
                        </div>
                         <div class="col-md-6">
                            <div class="card" style="height: 320px;">
                                <div class="card-header">Premium</div>
                                <div class="card-body">
                                    <ul>
                                         @foreach(["User profile", "Hub Forum access","Access educational tools","Receive in-network discounts on teen training & apparel","Access the idea builder tool","Communicate with business users (pro)"] as $feature)
                                         <li>{{$feature}}</li>
                                         @endforeach
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    @if(auth()->user() && auth()->user()->current_plan->plan == 'premium')
                                    <a href="{{route('billing', 'premium')}}" class="btn btn-primary">current plan</a>
                                    @else
                                    <a href="{{route('subscriptions.store', 'premium')}}" class="btn btn-primary">Subscribe</a>
                                    @endif
                                </div>
                            </div>
                            <div></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
