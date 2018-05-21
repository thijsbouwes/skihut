@component('mail::message')
# Dear {{ $user->name }}

Welcome to {{ config('app.name') }} your account has been created!

@component('mail::button', ['url' => $url])
    Complete Account
@endcomponent

![Welcome image](https://media.giphy.com/media/3o6ZtpxSZbQRRnwCKQ/giphy.gif "Logo Title Text 1")

Greetings,<br>
{{ config('app.name') }} - Thijs
@endcomponent