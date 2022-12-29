@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
{{$details['title']}}
{{$details['body']}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
