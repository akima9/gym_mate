<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            BOARD EDIT
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action={{route('boards.update', ['board' => $board])}} method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('제목')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus autocomplete="title" value="{{$board->title}}" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="content" :value="__('본문')" />
                            <x-text-area id="content" name="content" type="text" class="mt-1 block w-full" required autofocus autocomplete="content">
                                {{$board->content}}
                            </x-text-area>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>
                        <x-primary-button>{{ __('수정') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
