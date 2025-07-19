@component('mail::message')
# Reset Your Password

Hello,

{{ $langg->lang531 }}

@component('mail::button', ['url' => url('/user/change-password', $token) . '/' . urlencode($email)])
{{ $langg->lang534 }}
@endcomponent

{{ $langg->lang532 }}

{{ $langg->lang533 }},<br>
{{ config('app.name') }}
@endcomponent

