@component('mail::message')
    <p>Hello <b>{{ $User->first_name }}</b>,</p>
    <p>You have changed your password successfully.</p>
    <p>Thank you for using our application!</p>
    <p><b>{{ config('app.name') }}</b></p>
@endcomponent
