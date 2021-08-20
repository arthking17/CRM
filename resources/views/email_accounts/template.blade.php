@component('mail::message')
# {{ $subject }}

{!! $body !!}

@component('mail::button', ['url' => config('app.url')])
Visit our website
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
