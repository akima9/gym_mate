<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            글쓰기
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('boards.store')}}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('제목')" />
                            <x-text-input :value="old('title')" id="title" name="title" type="text" class="mt-1 block w-full" autofocus autocomplete="title" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="trainingDate" :value="__('운동 일자')" />
                            <input type="date" name="trainingDate" id="trainingDate" class="mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{old('trainingDate')}}">
                            <x-input-error class="mt-2" :messages="$errors->get('trainingDate')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="trainingTime" :value="__('운동 시간')" />
                            <input type="time" name="trainingStartTime" id="trainingStartTime" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{old('trainingStartTime')}}">
                            ~
                            <input type="time" name="trainingEndTime" id="trainingEndTime" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{old('trainingEndTime')}}">
                            <x-input-error class="mt-2" :messages="$errors->get('trainingStartTime')" />
                            <x-input-error class="mt-2" :messages="$errors->get('trainingEndTime')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="trainingPart" :value="__('운동 부위')" />
                            <select name="trainingPart" id="trainingPart" onchange="createBoard.handleChange()" class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
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
                            <x-text-area id="content" name="content" type="text" class="mt-1 block w-full" autofocus autocomplete="content" />
                        </div>
                        <x-primary-button>{{ __('등록') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const createBoard = {
                init: () => {
                    createBoard.setDefaultTrainingDate();
                    createBoard.setDefaultTrainingStartTime();
                    createBoard.setDefaultTrainingEndTime();
                },
                setDefaultTrainingDate: () => {
                    let trainingDate = document.querySelector('#trainingDate');
                    if (trainingDate.value.length == 0) {
                        let today = new Date();
                        trainingDate.value = today.toISOString().substring(0,10);
                    }
                },
                setDefaultTrainingStartTime: () => {
                    let trainingStartTime = document.querySelector('#trainingStartTime');
                    if (trainingStartTime.value.length == 0) {
                        let today = new Date();
                        trainingStartTime.value = today.toISOString().substring(11,16);
                    }
                },
                setDefaultTrainingEndTime: () => {
                    let trainingEndTime = document.querySelector('#trainingEndTime');
                    if (trainingEndTime.value.length == 0) {
                        let today = new Date();
                        today.setHours(today.getHours() + 1);
                        trainingEndTime.value = today.toISOString().substring(11,16);
                    }
                },
                handleChange: () => {
                    let selectedOption = document.querySelector('#trainingPart').selectedOptions[0];
                    let selectedValue = selectedOption.value;
                    let selectedText = selectedOption.text;
                    let hiddenInput = document.querySelector('.' + selectedValue); //null이 아니면 중복선택임.

                    if (selectedValue !== 'skip' && hiddenInput === null) {
                        createBoard.makeHiddenInput(selectedValue, selectedText);
                        createBoard.makeBadge(selectedValue, selectedText);
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

            createBoard.init();
        </script>
    @endpush
</x-app-layout>
