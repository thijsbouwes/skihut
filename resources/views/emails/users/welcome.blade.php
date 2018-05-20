@component('mail::message')
# Dear {{ $user->name }}

Welcome to {{ config('app.name') }} your account has been created!

![Welcome image](https://media.giphy.com/media/3o6ZtpxSZbQRRnwCKQ/giphy.gif "Logo Title Text 1")

## Token
{{ $token }}

@component('mail::button', ['url' => config('app.url')])
    Complete Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent