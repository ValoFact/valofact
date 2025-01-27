<x-mail::message>
# Introduction

The order '{{ $order->title }}' which you bided on got a new nid,

so automatically your old bid is outbided.

You can for sure bid again on that order and enhance your chances of winning it.

Click on the following button to consult order's details:

<x-mail::button :url="$orderUrl">
Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
