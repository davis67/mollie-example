@component('mail::message')
# Hello pulse, {{$user->name}}

We have have received an initial payment of {{$order->amount}} from {{$user->name}}.
Login to the system to view more information

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
