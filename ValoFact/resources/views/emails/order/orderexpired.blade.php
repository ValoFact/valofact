<x-mail::message>
# Introduction

The order '{{ $order->title }}' posted by '{{ $user->company_name }}' is expired with NO BIDS.

Click on the following button to consult the order's details:
<x-mail::button :url="$orderUrl">
Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
