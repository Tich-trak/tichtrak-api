<x-mail::message>

# Hello {{$data['user']['name']}},

<x-mail::panel>
We are Happy to have you onboard, Please Click on the Link Below to Activate your TichTrak Account,
</x-mail::panel>

<x-mail::button :url="env('APP_URL') . '/api/v1/verify/' . $data['verification_token']" color="primary">
Verify Email
</x-mail::button>

# Button Not Working?? Try pasting the link below into your Browser

{{env('APP_URL') . '/api/v1/verify/' . $data['verification_token']}}

# Below is your Login Credentials

Email: {{$data['user']['email']}},<br>
password: {{ $data['password'] }}

<x-mail::subcopy>
Thanks you for chosing Tichtrak
</x-mail::subcopy>

Thanks,<br>
# {{ config('app.name') }}

</x-mail::message>
