@component('mail::message')
# Dear {{ $user->name }}

We hope you enjoyed the events you visited, please pay the amount stated below.

@component('mail::table')
Event | Date | Price
| :------------- | :------------- | :-------- |
@foreach($events as $event)
    | {{ $event->name }} | {{ $event->event_date }} | € {{ number_format($event->price, 2) }} |
@endforeach
| **Total** | | **€ {{ number_format($events->sum('price'), 2) }}** |
@endcomponent

@component('mail::panel')
    Transfer € {{ number_format($events->sum('price'), 2) }} to Thijs Bouwes NL92 INGB 0655 1554 73
@endcomponent

@if($user->last_login === null)
### Your account isn't active
If you want to view your event history and details about upcoming events.
Complete your account now!
@component('mail::button', ['url' => $url])
    Complete Account
@endcomponent
*Activation link is 60 minutes valid, after that you have to reset your password!*
@else
### View your details
You can view your event history and details about upcoming events in your online profile.
@component('mail::button', ['url' => $url])
    View details
@endcomponent
@endif

Greetings,<br>
{{ config('app.name') }} - {{ config('app.owner') }}
@endcomponent