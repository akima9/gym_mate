<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            BOARD SHOW
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex space-x-2 justify-end">
                        <x-primary-anchor :href="route('boards.index')">목록</x-primary-anchor>
                        @can('update', $board)
                            <x-primary-anchor :href="route('boards.edit', ['board' => $board])">수정</x-primary-anchor>
                        @endcan
                        @can('delete', $board)
                            <form action="{{route('boards.destroy', ['board' => $board])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-primary-button>{{ __('삭제') }}</x-primary-button>
                            </form>
                        @endcan
                        <x-primary-anchor :href="route('chats.create', ['board' => $board])">채팅</x-primary-anchor>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        {{$board->created_at->diffForHumans()}}
                    </p>
                    <h2 class="text-lg font-medium text-gray-900 mb-5">
                        {{$board->title}}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 leading-loose">
                        {!!nl2br(e($board->content))!!}
                    </p>
                    <div class="flex space-x-4 justify-start mt-5">
                        <p class="mt-1 text-sm text-gray-600">
                            {{$board->gym->title}}
                        </p>
                        <p class="mt-1 text-sm text-gray-600">
                            {{$board->user->nickname}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
