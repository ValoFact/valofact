<x-mail::message>
# Introduction

The order '{{ $order->title }}' got a new bid.
So officially all old bids are outbided.


Click on the following button to consult order's details:

<x-mail::button :url="orderUrl">
Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
