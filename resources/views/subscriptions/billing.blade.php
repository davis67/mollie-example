@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Billing</div>

        <div class="card-body">
            <div class="row">
                @include('subscriptions.subscription')
            </div>
        </div>
    </div>
</div>
@endsection
