@component('mail::message')
    <p>Hello <b>{{ $User->first_name }}</b>,</p>
    <p>Thanks for signup! Please before you begin, you must confirm your account.</p>
    <p>Your activation code is <b><u>{{ $Code }}</u></b></p>
    <p>Thank you for using our application!</p>
    <p><b>{{ config('app.name') }}</b></p>
@endcomponent
