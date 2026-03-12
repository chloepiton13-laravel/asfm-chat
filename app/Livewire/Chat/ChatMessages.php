<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;

class ChatMessages extends Component
{
    public $messages = [];
    public $selectedConversationId;

    /**
     * Définit les écouteurs dynamiques.
     * Livewire va ré-évaluer cette fonction à chaque changement d'ID.
     */
    public function getListeners()
    {
        if (!$this->selectedConversationId) {
            return ['loadConversation' => 'loadMessages'];
        }

        return [
            "echo-private:chat.{$this->selectedConversationId},MessageSent" => 'broadcastedMessageReceived',
            "loadConversation" => 'loadMessages',
        ];
    }

    public function broadcastedMessageReceived($event)
    {
        // On recharge les messages quand Bilele reçoit l'alerte de Reverb
        $this->loadMessages($this->selectedConversationId);
    }

    #[On('loadConversation')]
    public function loadMessages($conversationId)
    {
        $this->selectedConversationId = $conversationId;

        $this->messages = Message::where('conversation_id', $conversationId)
            ->with(['sender', 'media'])
            ->orderBy('created_at', 'asc')
            ->get();

        $this->dispatch('messages-loaded');
    }

    public function render()
    {
        return view('livewire.chat.chat-messages');
    }
}
