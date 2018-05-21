@component('mail::message')
# Dear {{ $user->name }}

Welcome to {{ config('app.name') }} your account has been created!

![Welcome image](https://media.giphy.com/media/3o6ZtpxSZbQRRnwCKQ/giphy.gif "Welcome gif")

@component('mail::button', ['url' => $url])
    Complete Account
@endcomponent
*Activation link is 60 minutes valid, after that you have to reset your password!*

Greetings,<br>
{{ config('app.name') }} - {{ config('app.owner') }}
@endcomponent