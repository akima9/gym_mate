<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <script>
        // import Echo from 'laravel-echo'

        // window.Echo = new Echo({
        //     broadcaster: 'pusher',
        //     key: 'e87e1d4e3f72a0b516ba',
        //     cluster: 'ap3',
        //     forceTLS: true
        // });

        var channel = window.Echo.channel('chat');
        channel.listen('.chatSent', function(data) {
            // alert(JSON.stringify(data));
            alert(data);
        });
    </script>
</x-app-layout>

