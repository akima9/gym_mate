<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            BOARD EDIT
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action={{route('boards.update', ['board' => $board])}} method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <x-input-label for="status" :value="__('모집 상태')" />
                            <select name="status" id="status" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="running">모집중</option>
                                <option value="done">모집마감</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('제목')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus autocomplete="title" value="{{$board->title}}" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="trainingDate" :value="__('운동 일자')" />
                            <input type="date" name="trainingDate" id="trainingDate" class="mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{$board->trainingDate}}">
                            <x-input-error class="mt-2" :messages="$errors->get('trainingDate')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="trainingTime" :value="__('운동 시간')" />
                            <input type="time" name="trainingStartTime" id="trainingStartTime" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{$board->trainingStartTime}}">
                            ~
                            <input type="time" name="trainingEndTime" id="trainingEndTime" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{$board->trainingEndTime}}">
                            <x-input-error class="mt-2" :messages="$errors->get('trainingStartTime')" />
                            <x-input-error class="mt-2" :messages="$errors->get('trainingEndTime')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="trainingPart" :value="__('운동 부위')" />
                            <select name="trainingPart" id="trainingPart" onchange="editBoard.handleChange()" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="skip">선택해주세요</option>
                                <option value="chest">가슴</option>
                                <option value="back">등</option>
                                <option value="shoulder">어깨</option>
                                <option value="lowerBody">하체</option>
                                <option value="biceps">이두</option>
                                <option value="triceps">삼두</option>
                                <option value="abs">복부</option>
                            </select>
                            <div class="trainingParts"></div>
                            <x-input-error class="mt-2" :messages="$errors->get('trainingParts')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="content" :value="__('추가 내용')" />
                            <x-text-area id="content" name="content" type="text" class="mt-1 block w-full" required autofocus autocomplete="content">
                                {{$board->content}}
                            </x-text-area>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>
                        <x-primary-button>{{ __('수정') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const editBoard = {
                loadTrainingParts: () => {
                    let trainingParts = @json($board->trainingParts);

                    for (const key in trainingParts) {
                        let value = key;
                        let text = trainingParts[key];
                        editBoard.makeHiddenInput(value, text);
                        editBoard.makeBadge(value, text);
                    }
                },
                handleChange: () => {
                    let selectedOption = document.querySelector('#trainingPart').selectedOptions[0];
                    let selectedValue = selectedOption.value;
                    let selectedText = selectedOption.text;
                    let hiddenInput = document.querySelector('.' + selectedValue); //null이 아니면 중복선택임.

                    if (selectedValue !== 'skip' && hiddenInput === null) {
                        editBoard.makeHiddenInput(selectedValue, selectedText);
                        editBoard.makeBadge(selectedValue, selectedText);
                    }
                },
                makeHiddenInput: (selectedValue, selectedText) => {
                    let trainingPartsDiv = document.querySelector('.trainingParts');
                    let hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'trainingParts['+selectedValue+']';
                    hiddenInput.value = selectedText;
                    hiddenInput.className = selectedValue;
                    trainingPartsDiv.appendChild(hiddenInput);
                },
                makeBadge: (selectedValue, selectedText) => {
                    let trainingPartsDiv = document.querySelector('.trainingParts');
                    let badge = document.createElement('span');
                    badge.textContent = selectedText;
                    badge.className = "inline-flex items-center rounded-md bg-blue-50 px-2 py-1 font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 mt-1 mr-1";
                    
                    let deleteLink = document.createElement('a');
                    deleteLink.textContent = 'X';
                    deleteLink.className = 'ml-1 hover:cursor-pointer';
                    deleteLink.onclick = () => {
                        trainingPartsDiv.removeChild(badge);
                        let hiddenInput = document.querySelector('.' + selectedValue);
                        trainingPartsDiv.removeChild(hiddenInput);
                    };
                    
                    badge.appendChild(deleteLink);
                    trainingPartsDiv.appendChild(badge);
                }
            }
            editBoard.loadTrainingParts();
        </script>
    @endpush
</x-app-layout>
