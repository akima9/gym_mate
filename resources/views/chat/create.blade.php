<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            CHAT CREATE
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>test</p>
                </div>
                <div class="p-6 text-gray-900">
                    {{-- <form action="{{route('chats.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="receive_user_id" value="{{$board->user_id}}">
                        <div class="mb-4">
                            <x-text-input id="message" name="message" type="text" class="mt-1 block w-full" required autofocus autocomplete="message" />
                            <x-input-error class="mt-2" :messages="$errors->get('message')" />
                        </div>
                        <x-primary-button>{{ __('보내기') }}</x-primary-button>
                    </form> --}}
                    <div class="mb-4">
                        <x-text-input id="message" name="message" type="text" class="mt-1 block w-full" required autofocus autocomplete="message" />
                        <x-input-error class="mt-2" :messages="$errors->get('message')" />
                    </div>
                    <button>{{ __('보내기') }}</button>
                    <x-primary-button>{{ __('보내기') }}</x-primary-button>
                </div>
            </div>
        </div>
    </div>

    <script>
        console.log('JS!!');
    </script>
</x-app-layout>
