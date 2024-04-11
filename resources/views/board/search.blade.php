<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                게시판 검색
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('boards.index')}}" method="get">
                        <select name="status" id="status" value="{{request('status')}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mb-3">
                            <option value="running" @if (request('status') === 'running') selected @endif>모집중</option>
                            <option value="done" @if (request('status') === 'done') selected @endif>모집마감</option>
                        </select>
                        <input type="date" name="trainingDate" id="trainingDate" value="{{request('trainingDate')}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mb-3">
                        <input type="text" name="keyword" id="keyword" value="{{request('keyword')}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mb-3">
                        <x-primary-button class="w-full justify-center">{{ __('검색') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const searchBoard = {
                init: () => {
                    searchBoard.setDefaultTrainingDate();
                },
                setDefaultTrainingDate: () => {
                    let trainingDate = document.querySelector('#trainingDate');
                    if (trainingDate.value.length == 0) {
                        let today = new Date();
                        trainingDate.value = today.toISOString().substring(0,10);
                    }
                }
            }

            searchBoard.init();
        </script>
    @endpush
</x-app-layout>
