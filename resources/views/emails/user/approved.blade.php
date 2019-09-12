@component('mail::message')
# Hi {{ strtoupper($newfirstname) }},

Your request to register has been approved by the admin.

@component('mail::button', ['url' => config('app.url'), 'color' => 'success'])
Login Now
@endcomponent

Thank You,<br>
{{ config('app.name') }}
@endcomponent
