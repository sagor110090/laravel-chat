<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{On,Layout,Title};
use App\Models\Message;
use Illuminate\Support\Facades\Validator;


new 

#[Layout('layouts.app')]
#[Title('Chat Box')]

class extends Component {
    
    public $messages = [];
     
    public $message = '';

    public function loadMessages() {
        $this->messages = Message::all();
        $this->dispatch('messages-loaded');
    }

    public function send(){
        
        Validator::make(['message' => $this->message], [
            'message' => 'required|string|max:600'
        ])->validate();
                
        Message::create([
            'content' => $this->message,
            'user_id' => auth()->id()
        ]);
        
        $this->message = ''; 

        
    }
    
}; ?>

<div class="flex items-center justify-center h-screen bg-gray-100" wire:init="loadMessages">
    <div class="w-full max-w-md mx-auto overflow-hidden bg-white rounded-lg shadow-lg">
        <!-- Chat Header -->
        <div class="px-4 py-2 text-white bg-blue-500">
            <h1 class="text-lg font-semibold">Chat Room</h1>
        </div>
        <!-- Chat Messages -->
        <div class="h-64 p-4 overflow-y-auto" wire:poll.500ms="loadMessages" id="chat-box" @messages-loaded.window="document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight;">
            @foreach ($messages as $message)

            <div class="mb-4" wire:key="{{ $message->id }}">

                <div class="flex items-center ">
                    <div class="p-2 bg-gray-300 rounded-lg {{ $message->user_id == auth()->id() ? 'ml-auto' : '' }}">
                        <p class="text-sm">{{ $message->content }}</p>
                    </div>
                </div>

                <small class="flex text-xs text-gray-500 {{ $message->user_id == auth()->id() ? 'justify-end' : '' }}"> 
                    {{ $message->created_at->format('h:i A') }}
                </small>


            </div>


            @endforeach
        </div>
        <!-- Chat Input -->
        <div class="px-4 py-2 bg-gray-200">
            <form class="flex" wire:submit="send">
                <input type="text" class="flex-1 px-2 py-1 rounded-l-lg focus:outline-none"
                    placeholder="Type your message..." wire:model="message">
                <button type="submit" class="px-4 py-1 text-white bg-blue-500 rounded-r-lg">Send</button>
            </form>
            @error('message')
            <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

 
  
