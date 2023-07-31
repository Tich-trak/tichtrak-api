@component("mail::message")

# Hello {{$user->name}},

Click on the Link Below to Reset your drive45 Account Password,

@component('mail::button', ['url' => env('APP_URL') . '/api/v1/reset_token/' . $token])
Reset Password
@endcomponent

# Button Not Working?? Try pasting the link below into your Browser

{{env('APP_URL') .  '/api/v1/reset_token/' . $token}}

@component('mail::subcopy')
# Thanks you for chossing Drive45
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@endcomponent
