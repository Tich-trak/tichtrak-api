@component("mail::message")

# Hello {{$user->name}},

Click on the Link Below to Activate your Drive45 Account,

@component('mail::button', ['url' => env('APP_URL') . '/api/v1/verify/' . $token])
Verify Email
@endcomponent

# Button Not Working?? Try pasting the link below into your Browser

{{env('APP_URL') . '/api/v1/verify/' . $token}}

# Below is your Login Credentials

Email: {{$user->email}},<br>
password: {{ env('DEFAULT_PASSWORD') }}

@component('mail::subcopy')
# Thanks you for chossing Drive45
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@endcomponent
