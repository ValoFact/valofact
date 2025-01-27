<x-mail::message>
# Introduction

The order "{{ $order->title }}" that you've been biding on has been updated by her owner: {{ $user->name }}.

Click on the following button to consult the order:

<x-mail::button :url="$orderUrl">
See Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
