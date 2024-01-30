<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            CHAT CREATE
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="messages" class="p-6 text-gray-900">
                    {{-- <div class="mb-3">
                        <p class="text-sm text-gray-600">nickname</p>
                        <p class="bg-slate-100 rounded p-2">text</p>
                        <p class="text-sm text-gray-600">time</p>
                    </div> --}}
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
    
    @push('scripts')
        <script>
            const chat = {
                load: () => {
                    let apiUrl = "{{ route('chats.load') }}";
                    let data = {
                        receive_user_id: '{{$board->user_id}}',
                        send_user_id: '{{Auth::user()->id}}'
                    };
                    let url = new URL(apiUrl);
                    Object.keys(data).forEach(key => url.searchParams.append(key, data[key]));

                    chat.getData(url, data);
                },
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
                        'receive_user_id': '{{$board->user_id}}',
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
                        chat.load();
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

            chat.load();
        </script>
    @endpush

</x-app-layout>
