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
                    <a href="{{route('boards.create')}}" class="bg-indigo-500 hover:bg-indigo-600 py-2 px-3 rounded text-white text-sm font-bold">글작성</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
