<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            게시판
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-center my-5 rounded">
                        <form action="{{route('boards.index')}}" method="get">
                            <select name="status" id="status" value="{{request('status')}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="running" @if (request('status') === 'running') selected @endif>모집중</option>
                                <option value="done" @if (request('status') === 'done') selected @endif>모집마감</option>
                            </select>
                            <input type="date" name="trainingDate" id="trainingDate" value="{{request('trainingDate')}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <input type="text" name="keyword" id="keyword" value="{{request('keyword')}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <x-primary-button>{{ __('검색') }}</x-primary-button>
                        </form>
                    </div>
                    <div class="flex justify-end">
                        <x-secondary-button onclick="mateBoard.checkGym()">글쓰기</x-secondary-button>
                    </div>
                    @foreach ($boards as $board)
                        <div class="border border-inherit p-3 mt-5 hover:bg-slate-50 rounded">
                            <a href="{{route('boards.show', ['board' => $board, 'page' => request('page'), 'status' => request('status'), 'trainingDate' => request('trainingDate'), 'keyword' => request('keyword')])}}">
                                <p class="mt-1 text-sm text-gray-600">
                                    {{$board->created_at->diffForHumans()}}
                                </p>
                                <h2 class="text-lg font-medium text-gray-900">
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
                                    <p class="mt-2 text-sm">
                                        {{$board->trainingDate}} {{$board->trainingStartTime}} ~ {{$board->trainingEndTime}}
                                    </p>
                                    <div class="mt-1">
                                        @foreach ($board->trainingParts as $value => $text)
                                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{$text}}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex space-x-4 justify-start mt-5">
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{$board->gym->title}}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{$board->user->nickname}}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    <div class="mt-5">
                        {{$boards->withQueryString()->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            @if(session('status') === 'user-registered')
                alert('인증 메일이 발송 되었습니다.');
            @endif
            const mateBoard = {
                checkGym: () => {
                    self.location = "{{route('boards.create')}}";
                }
            }
        </script>
    @endpush
</x-app-layout>
