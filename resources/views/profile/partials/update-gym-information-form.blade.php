<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('GYM') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("계정의 헬스장 정보를 업데이트하세요.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updateForGym') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="title" :value="__('현재 GYM')" />
            @if (empty($user->gym_id))
                <p class="mt-1 text-sm text-gray-600">
                    GYM을 설정하지 않았습니다.
                </p>
            @else
                <p class="mt-1 text-sm text-gray-600">
                    {{$user->gym->title}}
                </p>
            @endif
        </div>
        <div>
            <x-input-label for="title" :value="__('GYM 검색')" />
            <x-text-input onkeyup="gymProfile.handleKeyPress()" id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" autofocus autocomplete="title" />
        </div>
        <div>
            <x-input-label for="gym_id" :value="__('GYM 선택')" />
            <select name="gym_id" id="gym_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gym_id')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('수정') }}</x-primary-button>

            @if (session('status') === 'gym-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('수정 되었습니다.') }}</p>
            @endif
        </div>
    </form>

    @push('scripts')
        <script>
            const gymProfile = {
                handleKeyPress: () => {
                    let title = document.querySelector('#title').value;
                    let url = "{{ route('gyms.find') }}";
                    let data = {
                        'title': title,
                    };
                    if (title.length > 0) {
                        gymProfile.postData(url, data);
                    }
                },
                postData: (url, data) => {
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector("#gym_id").innerHTML = '';
                        data.forEach(element => {
                            console.log(element);
                            let optionBox = document.createElement('option');
                            optionBox.value = element.id;
                            optionBox.textContent = element.title + ' (' + element.address + ')';
                            document.querySelector("#gym_id").appendChild(optionBox);
                        });
                    })
                    .catch(error => console.error('Error:', error));
                },
            };
        </script>
    @endpush
</section>
