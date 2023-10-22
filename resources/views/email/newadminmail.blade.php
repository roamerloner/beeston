@component('mail::message')
# Congratulations!

{{ $created_by }} Account opened successfully, please use your information to login.

@component('mail::panel')
# Email Address : {{ $email }}
# Password : {{ $password }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
