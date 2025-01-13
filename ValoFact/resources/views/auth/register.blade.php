<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Profile Type --> 
        <div class="mt-4">
            <x-input-label for="type" :value="__('Profile Type')" />
            <x-select id="type" class="block w-full" name="type">
                <option value="" selected disabled hidden>{{ __('--') }}</option>
                @foreach (App\Enums\UserType::cases() as $type)
                    <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                        {{ ucfirst($type->value) }} </option>
                @endforeach
            </x-select>
            <x-input-error :messages="$errors->get('type')" class="mt-2" />
        </div>


        <!-- Company Name -->
        <div class="mt-4">
            <x-input-label for="company_name" :value="__('Company Name')" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')"/>
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>


        <!-- Contact Informations -->
        <div class="mt-4">
            <x-input-label for="contact_information" :value="__('Contact Informations')" />
            <x-text-input id="contact_information" class="block mt-1 w-full" type="text" name="contact_information" :value="old('contact_information')" required />
            <x-input-error :messages="$errors->get('contact_information')" class="mt-2" />
        </div>


        <!-- Location -->
        <div class="mt-4">
            <x-input-label for="location" :value="__('Location')" />
            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
        </div>


        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
