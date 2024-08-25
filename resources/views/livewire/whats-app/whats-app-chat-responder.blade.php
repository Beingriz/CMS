<div>
    <div class="container mx-auto">
        <div class="flex">
            <!-- Conversations Sidebar -->
            <div class="w-1/4 p-4 bg-gray-100">
                <h2 class="font-bold text-lg">Conversations</h2>
                <ul class="mt-4">
                    @foreach ($messages as $message)
                        <li class="mb-2">
                            <button wire:click="$set('selectedUser', '{{ $message['user'] }}')"
                                    class="block w-full text-left px-4 py-2 bg-white border border-gray-300 rounded">
                                {{ $message['user'] }}
                                @if (!$message['read'] && !$message['sent'])
                                    <span class="ml-2 text-red-500 font-bold">(New)</span>
                                @endif
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Chat Window -->
            <div class="w-3/4 p-4 bg-white border border-gray-300">
                @if ($selectedUser)
                    <h2 class="font-bold text-lg">Chat with {{ $selectedUser }}</h2>

                    <div class="chat-box mt-4 h-96 overflow-y-auto border p-4">
                        @foreach ($messages as $message)
                            @if ($message['user'] === $selectedUser)
                                <div class="mb-2 {{ $message['sent'] ? 'text-right' : '' }}">
                                    <div class="inline-block px-4 py-2 {{ $message['sent'] ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">
                                        {{ $message['body'] }}
                                        @if ($message['attachment_url'])
                                            <a href="{{ $message['attachment_url'] }}" target="_blank" class="block mt-2 text-sm text-blue-700">View Attachment</a>
                                        @endif
                                    </div>
                                    @if ($message['sent'] && $message['read'])
                                        <span class="text-xs text-green-500">Read</span>
                                    @elseif ($message['sent'])
                                        <span class="text-xs text-gray-500">Sent</span>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Send Message Form -->
                    <form wire:submit.prevent="sendMessage" class="mt-4 flex items-center space-x-4">
                        <input type="text" wire:model="messageBody" placeholder="Type your message here..."
                               class="w-full border border-gray-300 px-4 py-2 rounded">
                        <input type="file" wire:model="attachment" class="hidden" id="attachment">
                        <label for="attachment" class="cursor-pointer bg-gray-300 px-4 py-2 rounded">Attach</label>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Send</button>
                    </form>
                @else
                    <p class="text-gray-500">Select a conversation to start chatting.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('message-received', event => {
        alert('New message received: ' + event.detail.message.body);
    });
</script>
