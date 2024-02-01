<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            CHAT DETAIL
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="messages" class="p-6 text-gray-900 h-96 overflow-y-auto">
                    @foreach ($chats as $chat)
                        @if ($chat->receiveUser->id === auth()->user()->id)
                            <div class="mb-5">
                                <p class="text-sm text-gray-600">{{ $chat->sendUser->nickname }}</p>
                                <p class="bg-slate-100 rounded p-2">{{ $chat->message }}</p>
                                <p class="text-sm text-gray-600">{{ $chat->created_at->diffForHumans() }}</p>
                            </div>
                        @else
                            <div class="mb-5 text-right">
                                <p class="bg-slate-100 rounded p-2">{{ $chat->message }}</p>
                                <p class="text-sm text-gray-600">{{ $chat->created_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <x-text-input id="message" name="message" type="text" class="mt-1 block w-full" required autofocus autocomplete="message" />
                        <x-input-error class="mt-2" :messages="$errors->get('message')" />
                    </div>
                    <button onclick="chat.send()" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('보내기') }}</button>
                </div>
            </div>
        </div>
    </div>

    @push('pusher-cdn')
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.2/dist/echo.iife.js"></script>
    @endpush
    
    @push('scripts')
        <script>
            window.Pusher = Pusher;
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: 'e87e1d4e3f72a0b516ba',
                cluster: 'ap3',
                wsHost: `ws-ap3.pusher.com`,
                wsPort: 80,
                wssPort: 443,
                forceTLS: true,
                enabledTransports: ['ws', 'wss'],
            });

            let channel = window.Echo.channel('chat');
            channel.listen('ChatSent', function(data) {
                chat.make(data);
            });

            const chat = {
                make: (data) => {
                    console.log('call make');
                    console.log(data);

                    let chatDiv = document.createElement('div');
                    chatDiv.className = 'mb-5 text-right';

                    let messageP = document.createElement('p');
                    messageP.className = 'bg-slate-100 rounded p-2';
                    let message = document.createTextNode(data.message);
                    messageP.appendChild(message);
                    
                    let createAtP = document.createElement('p');
                    createAtP.className = 'text-sm text-gray-600';
                    let createAt = document.createTextNode(moment(data.sentAt).fromNow());
                    createAtP.appendChild(createAt);
                    
                    chatDiv.appendChild(messageP);
                    chatDiv.appendChild(createAtP);
                    console.log(chatDiv);
                    document.querySelector('#messages').appendChild(chatDiv);
                },
                // load: () => {
                //     let apiUrl = "{{ route('chats.load') }}";
                //     let data = {
                //         receive_user_id: '{{ $chatPartnerId }}',
                //         send_user_id: '{{Auth::user()->id}}'
                //     };
                //     let url = new URL(apiUrl);
                //     Object.keys(data).forEach(key => url.searchParams.append(key, data[key]));

                //     chat.getData(url, data);
                // },
                send: () => {
                    console.log('call send')
                    let messageInput = document.querySelector('#message');
                    let message = messageInput.value;

                    if (message.length == 0) {
                        alert('메시지를 입력해주세요.');
                        focus(messageInput);
                        return;
                    }

                    let url = "{{ route('chats.send') }}";
                    let data = {
                        'message': message,
                        'receive_user_id': '{{ $chatPartnerId }}',
                    };

                    chat.postData(url, data);
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
                        console.log(data);
                        // chat.load();
                    })
                    .catch(error => console.error('Error:', error));
                },
                getData: (url, data) => {
                    fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // console.log(data);
                        let chats = data.chats;
                        let sendUser = data.sendUser;
                        let receiveUser = data.receiveUser;
                        chat.showChat(chats, sendUser, receiveUser);
                    })
                    .catch(error => console.error('Error:', error));
                },
                showChat: (chats, sendUser, receiveUser) => {
                    chats.forEach((chat) => {
                        let chatDiv = document.createElement('div');
                        chatDiv.className = 'mb-3';
                        
                        let nickNameP = document.createElement('p');
                        nickNameP.className = 'text-sm text-gray-600';
                        let nickName;
                        if (chat.send_user_id == sendUser.id) {
                            nickName = document.createTextNode(sendUser.nickname);
                        } else {
                            nickName = document.createTextNode(receiveUser.nickname);
                        }
                        nickNameP.appendChild(nickName);

                        let messageP = document.createElement('p');
                        messageP.className = 'bg-slate-100 rounded p-2';
                        let message = document.createTextNode(chat.message);
                        messageP.appendChild(message);
                        
                        let createAtP = document.createElement('p');
                        createAtP.className = 'text-sm text-gray-600';
                        let createAt = document.createTextNode(moment(chat.created_at).fromNow());
                        createAtP.appendChild(createAt);
                        
                        chatDiv.appendChild(nickNameP);
                        chatDiv.appendChild(messageP);
                        chatDiv.appendChild(createAtP);
                        console.log(chatDiv);
                        document.querySelector('#messages').appendChild(chatDiv);
                    });
                }
            };

            // chat.load();
        </script>
    @endpush

</x-app-layout>
