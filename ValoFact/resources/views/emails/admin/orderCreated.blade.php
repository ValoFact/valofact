<x-mail::message>
# Introduction

A new order has been created by this user: {{ $user->name }}


Click on the following button to examine that order:

<x-mail::button :url="$orderUrl">
See Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
