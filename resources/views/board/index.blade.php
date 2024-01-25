<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            BOARD INDEX
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-primary-anchor :href="route('boards.create')">글작성</x-primary-anchor>
                    @foreach ($boards as $board)
                        <div class="border border-inherit p-3 mt-5 hover:bg-slate-50">
                            <a href="{{route('boards.show', ['board' => $board])}}">
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{$board->title}}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{$board->user->nickname}}
                                </p>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{$board->gym->title}}
                                </p>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{$board->created_at->diffForHumans()}}
                                </p>
                            </a>
                        </div>
                    @endforeach
                    <div class="mt-5">
                        {{$boards->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
