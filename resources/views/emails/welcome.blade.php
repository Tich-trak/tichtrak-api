@component("mail::message")

# Hello {{$user->name}},

You are Welcome to Drive 45, We are Happy to have you here.

@component('mail::subcopy')
# Thanks you for chossing Drive45
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@endcomponent
