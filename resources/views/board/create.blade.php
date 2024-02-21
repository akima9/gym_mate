<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            BOARD CREATE
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('boards.store')}}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('제목')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus autocomplete="title" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="" :value="__('운동 일자')" />
                            <input type="date" name="" id="" class="mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <x-input-label for="" :value="__('운동 시간')" />
                            <input type="time" name="" id="" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            ~
                            <input type="time" name="" id="" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <x-input-label for="" :value="__('운동 부위')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="content" :value="__('추가 내용')" />
                            <x-text-area id="content" name="content" type="text" class="mt-1 block w-full" required autofocus autocomplete="content" />
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>
                        <x-primary-button>{{ __('등록') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
