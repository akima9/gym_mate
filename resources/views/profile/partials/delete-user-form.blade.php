<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('회원 탈퇴') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('회원 탈퇴하게 되면 모든 자원과 데이터가 영구적으로 삭제됩니다.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('회원 탈퇴') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('회원 탈퇴를 진행 하시겠습니까?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('회원 탈퇴를 하게되면 해당 계정의 모든 자원과 데이터가 영구적으로 삭제됩니다. 계정을 영구적으로 삭제하려면 비밀번호를 입력하세요.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('비밀번호') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('비밀번호') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('취소') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('회원 탈퇴') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
