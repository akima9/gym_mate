<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            게시글
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
                        @auth
                            @if ($board->status === 'running' 
                                && $board->user_id !== auth()->user()->id 
                                && $board->gym_id === auth()->user()->gym_id
                                && $board->user->gender === auth()->user()->gender)
                                <form action="{{route('chats.detail')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="chatPartner" value="{{ $board->user_id }}">
                                    <x-primary-button>{{ __('채팅') }}</x-primary-button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        {{$board->created_at->diffForHumans()}}
                    </p>
                    <h2 class="text-lg font-medium text-gray-900 mb-5">
                        @if ($board->status === 'running')
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">모집중</span>
                            @if ($board->user->gender === 'man')
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">남자</span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">여자</span>
                            @endif
                        @else
                            <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">모집마감</span>
                        @endif
                        {{$board->title}}
                    </h2>
                    <div>
                        <p class="mt-2">
                            운동 일자: {{$board->trainingDate}} {{$board->trainingStartTime}} ~ {{$board->trainingEndTime}}
                        </p>
                        <div class="mt-1">
                            운동 부위: 
                            @foreach ($board->trainingParts as $value => $text)
                                <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{$text}}</span>
                            @endforeach
                        </div>
                    </div>
                    <p class="mt-5 leading-loose">
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
