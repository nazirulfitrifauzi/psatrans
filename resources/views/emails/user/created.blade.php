@component('mail::message')
# Hi {{ strtoupper($newfirstname) }},

Your account has been successfully created. Please reset your password before login to your account. Never login in with your temporary password.
<br>
&nbsp;
<br>
Your temporary password is: psa@123!

@component('mail::button', ['url' => config('app.urlchangepassword'), 'color' => 'success'])
Reset your password
@endcomponent

Thank You,<br>
{{ config('app.name') }}
@endcomponent
