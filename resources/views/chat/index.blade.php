<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            CHAT INDEX
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($chatPartners as $chatPartner)
                        {{-- <a href="{{route('chats.detail', ['user' => $user, 'chatPartner' => $chatPartner])}}"> --}}
                        <a href="{{route('chats.detail', ['chatPartner' => $chatPartner])}}">
                            <div class="bg-slate-100 rounded p-4">
                                @if(isset($latestMessages[$chatPartner->id]))
                                    <div class="flex justify-between">
                                        <p>{{ $chatPartner->nickname }}</p>
                                        <p class="text-sm text-gray-600">{{ $latestMessages[$chatPartner->id]->created_at->diffForHumans() }}</p>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $latestMessages[$chatPartner->id]->message }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                    
                    {{-- <div class="flex justify-end">
                        <x-primary-anchor :href="route('boards.create')">글쓰기</x-primary-anchor>
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
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
