<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Ninkname -->
        <div>
            <x-input-label for="nickname" :value="__('Nickname')" />
            <x-text-input id="nickname" class="block mt-1 w-full" type="text" name="nickname" :value="old('nickname')" required autofocus autocomplete="nickname" />
            <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
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

        <!-- Gender -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700">{{__('Gender')}}</label>
            <div class="flex justify-around bg-gray-50 rounded-md shadow-sm mt-1 py-2">
                <div>
                    <input type="radio" name="gender" id="man" value="man">
                    <label for="man">Man</label>
                </div>
                <div>
                    <input type="radio" name="gender" id="woman" value="woman">
                    <label for="woman">Woman</label>
                </div>
            </div>
        </div>

        <!-- Age group -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700">{{__('Age group')}}</label>
            <select name="age" id="age" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                <option value="10">Teenagers</option>
                <option value="20">Twenties</option>
                <option value="30">Thirties</option>
                <option value="40">Forties</option>
                <option value="50">Fifties</option>
                <option value="60">Sixties</option>
                <option value="70">Seventies</option>
                <option value="80">Eighties</option>
                <option value="90">Nineties</option>
            </select>
        </div>

        <!-- Gym list -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700">{{__('Gym')}}</label>
            <div class="flex mt-1">
                <div class="flex-1">
                    <x-text-input onkeydown="chat.handleKeyPress(event)" id="title" name="title" type="text" class="block w-full" required autofocus autocomplete="title" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>
                <button onclick="" class="inline-flex items-center ml-1 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('Search') }}</button>
            </div>
            {{-- <select name="gym_id" id="gym_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mt-1">
                <option value="1">gym1</option>
            </select> --}}
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
