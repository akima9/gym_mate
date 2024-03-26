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
                        <p>채팅 기록이 없습니다.</p>
                        <p>같은 GYM을 이용하고 동일한 성별을 가진 사용자의 게시물을 통해 1:1 채팅이 가능합니다.</p>
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
