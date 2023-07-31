<x-mail::message>
# Welcome

<x-mail::button :url="'/'">
Action Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
