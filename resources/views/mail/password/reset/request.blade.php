@component('mail::message')
    <p>Hello <b>{{ $User->first_name }}</b>,</p>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>Your reset code is <b><u>{{$Token}}</u></b></p>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>Thank you for using our application!</p>
    <p><b>{{ config('app.name') }}</b></p>
@endcomponent
