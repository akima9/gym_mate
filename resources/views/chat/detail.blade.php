<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            채팅
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="messages" class="p-6 text-gray-900 h-96 overflow-y-auto">
                </div>
                <div class="p-6 text-gray-900 flex">
                    <div class="flex-1">
                        <x-text-input onkeydown="chat.handleKeyPress(event)" id="message" name="message" type="text" class="block w-full" required autofocus autocomplete="message" />
                        <x-input-error class="mt-2" :messages="$errors->get('message')" />
                    </div>
                    <button onclick="chat.send()" class="inline-flex items-center ml-1 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('보내기') }}</button>
                </div>
            </div>
        </div>
    </div>

    @push('pusher-cdn')
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.2/dist/echo.iife.js"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/2.29.1/moment.min.js"></script>
    @endpush
    
    @push('scripts')
        <script>
            let messagesDiv = document.querySelector('#messages');
            let page = 1;
            messagesDiv.addEventListener('scroll',() => {
                if (messagesDiv.scrollTop === 0) {
                    chat.loadChat();
                }
            });
            let prevHeight = 0;
            
            const chat = {
                init: () => {
                    chat.loadChat();
                    chat.scrollToBottom();

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

                    let channel = window.Echo.channel('private-chats.{{$chatRoom->id}}');
                    channel.listen('ChatSent', function(data) {
                        chat.make(data);
                        chat.scrollToBottom();
                    });
                },
                handleKeyPress: (event) => {
                    if (event.keyCode === 13) {
                        chat.send();
                        document.querySelector('#message').value = "";
                    }
                },
                scrollToBottom: () => {
                    let messagesDiv = document.querySelector('#messages');
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                },
                make: (data) => {
                    let chatDiv = document.createElement('div');
                    let nicknameP = document.createElement('p');
                    let messageP = document.createElement('p');
                    let message = document.createTextNode(data.message);
                    let createAtP = document.createElement('p');
                    let createAt = document.createTextNode(moment(data.sentAt).fromNow());
                    
                    if (data.sender === {{auth()->user()->id}}) {
                        messageP.className = 'bg-slate-100 rounded py-2 px-3 ml-auto';
                        createAtP.className = 'text-sm text-gray-600 w-fit ml-auto';
                    } else {
                        nicknameP.className = 'text-sm text-gray-600';
                        nickname = document.createTextNode(data.nickname);
                        nicknameP.appendChild(nickname);
                        chatDiv.appendChild(nicknameP);

                        messageP.className = 'bg-slate-100 rounded py-2 px-3';
                        createAtP.className = 'text-sm text-gray-600';
                    }
                    chatDiv.className = 'mb-5';
                    messageP.setAttribute('style', 'width:fit-content;max-width:40%');

                    messageP.appendChild(message);
                    createAtP.appendChild(createAt);
                    chatDiv.appendChild(messageP);
                    chatDiv.appendChild(createAtP);
                    document.querySelector('#messages').appendChild(chatDiv);
                },
                send: () => {
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
                    .then(data => {})
                    .catch(error => console.error('Error:', error));
                },
                loadChat: () => {
                    //page는 전역 변수
                    let url = "{{ route('chats.load') }}";
                    let data = new URLSearchParams();
                    data.append('page', page);
                    data.append('chatRoomId', {{$chatRoom->id}});
                    chat.getData(`${url}?${data}`);
                    page++;
                },
                getData: (url) => {
                    fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response);
                        }
                        return response.json();
                    })
                    .then(data => {
                        let chatGroupDiv = document.createElement('div'); 
                        data.forEach((chat) => {
                            let chatDiv = document.createElement('div');
                            chatDiv.className = 'mb-3';

                            let messageP;
                            let createdAtP;
                            
                            if (chat.receive_user_id == {{ auth()->user()->id }}) {//받는 사람과 로그인한 사람이 같은 경우
                                let nickNameP = document.createElement('p');
                                nickNameP.className = 'text-sm text-gray-600';
                                
                                let nickName = document.createTextNode(chat.send_user.nickname);

                                messageP = document.createElement('p');
                                messageP.className = 'bg-slate-100 rounded py-2 px-3';
                                messageP.style.width = 'fit-content';
                                messageP.style.maxWidth = '40%';

                                createdAtP = document.createElement('p');
                                createdAtP.className = 'text-sm text-gray-600';
                                
                                nickNameP.appendChild(nickName);
                                chatDiv.appendChild(nickNameP);
                            } else {//받는 사람과 로그인한 사람이 다른 경우
                                messageP = document.createElement('p');
                                messageP.className = 'bg-slate-100 rounded py-2 px-3 ml-auto';
                                messageP.style.width = 'fit-content';
                                messageP.style.maxWidth = '40%';

                                createdAtP = document.createElement('p');
                                createdAtP.className = 'text-sm text-gray-600 w-fit ml-auto';
                            }
                            
                            let message = document.createTextNode(chat.message);
                            let createdAt = document.createTextNode(moment(chat.created_at).fromNow());
                            
                            messageP.appendChild(message);
                            createdAtP.appendChild(createdAt);
                            
                            chatDiv.appendChild(messageP);
                            chatDiv.appendChild(createdAtP);

                            chatGroupDiv.appendChild(chatDiv);
                        });
                        
                        let messagesDiv = document.querySelector('#messages');
                        prevHeight = messagesDiv.scrollHeight;
                        messagesDiv.insertBefore(chatGroupDiv, messagesDiv.firstChild);
                        currentHeight = messagesDiv.scrollHeight;
                        messagesDiv.scrollTo(0, currentHeight - prevHeight);
                    })
                    .catch(error => console.error('Error:', error));
                }
            };

            chat.init();
        </script>
    @endpush

</x-app-layout>
