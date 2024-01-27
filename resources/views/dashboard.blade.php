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
</x-app-layout>

<script>
    // window.Echo.private(`orders.${orderId}`)
    //     .listen('OrderShipmentStatusUpdated', (e) => {
    //         console.log(e.order);
    //     });

    // this.echo.channel('chat').listen('ChatSent', (e) => {
    //     this.onChatSent(e);
    //   });
    console.log(window.Echo);
    console.log(Echo);
    window.Echo.channel('chat').listen('ChatSent', (e) => {
        console.log(e);
    })
</script>
