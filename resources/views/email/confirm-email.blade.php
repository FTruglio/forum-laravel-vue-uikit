@component('mail::message')
# One last step

We just need you to confirm your email address to prove that you're a human.

@component('mail::button', ['url' => $url])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
