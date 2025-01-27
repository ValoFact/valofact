<x-mail::message>
# Introduction

The Order: '{{ $order->title }}' which's posted by '{{ $order->user->company_name }}' 
is officially sold to the recycler: '{{ $bid->user->company_name }}'.

Cklick on the following button to consult the order's details:
<x-mail::button :url="$orderUrl">
Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
