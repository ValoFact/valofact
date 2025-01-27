<x-mail::message>
# Introduction
A new profile has been registered:

        name  ===>  {{ $user->name }}
        email  ===>  {{ $user->email }} 
        type  ===>  {{ $user->type }} 
        company_name  ===>  {{ $user->company_name }} 
        contact_information  ===>  {{ $user->contact_information }}
        location  ===>  {{ $user->location }} 
        


Click on the following button to validate this profile

<x-mail::button :url="$url">
Validate Profile
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
