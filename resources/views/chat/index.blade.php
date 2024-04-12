<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            채팅 목록
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($chatPartners->isEmpty())
                        <p class="font-semibold mb-2">채팅 기록이 없습니다.</p>
                        <p class="mb-2">같은 GYM을 이용하고, 동일한 성별을 가진 사용자의 게시물을 통해 1:1 채팅이 가능합니다.</p>
                        <div>
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">동일 GYM</span> + 
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">동일 성별</span> +
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">게시글 채팅버튼</span> =
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">채팅 가능</span>
                        </div>
                    @endif
                    @foreach ($chatPartners as $chatPartner)
                        <a onclick="goToChat({{$chatPartner->id}})" class="hover:cursor-pointer m-1">
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
                </div>
            </div>
        </div>
    </div>

    <form action="{{route('chats.detail')}}" method="POST" id="hiddenForm">
        @csrf
        <input type="hidden" name="chatPartner" id="chatPartner">
    </form>

    @push('scripts')
        <script>
            function goToChat(chatPartner) {
                let form = document.querySelector("#hiddenForm");
                document.querySelector("#chatPartner").value = chatPartner;
                form.submit();
            }
        </script>
    @endpush
</x-app-layout>
