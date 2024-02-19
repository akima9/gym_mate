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
                    <div class="flex justify-end">
                        <x-secondary-button onclick="mateBoard.checkGym()">글쓰기</x-secondary-button>
                    </div>
                    @foreach ($boards as $board)
                        <div class="border border-inherit p-3 mt-5 hover:bg-slate-50">
                            <a href="{{route('boards.show', ['board' => $board])}}">
                                <p class="mt-1 text-sm text-gray-600">
                                    {{$board->created_at->diffForHumans()}}
                                </p>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{$board->title}}
                                </h2>
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
                        {{$boards->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const mateBoard = {
                checkGym: () => {
                    @auth
                        let gym_id = "{{auth()->user()->gym_id}}";
                        if (!gym_id) {
                            if (confirm('GYM 설정 후 작성 가능합니다.')) {
                                self.location = "{{route('profile.edit')}}";
                            }
                        } else {
                            self.location = "{{route('boards.create')}}";
                        }
                    @else
                        self.location = "{{route('boards.create')}}";
                    @endauth
                }
            }
        </script>
    @endpush
</x-app-layout>
