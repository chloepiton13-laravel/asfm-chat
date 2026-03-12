<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;
use Livewire\Attributes\On;

class ChatHeader extends Component
{
    public ?Conversation $conversation = null;

    #[On('loadConversation')]
    public function loadConversation($conversationId)
    {
        // On charge la conversation avec les utilisateurs pour identifier l'interlocuteur
        $this->conversation = Conversation::with('users')->find($conversationId);
    }

    public function render()
    {
        // Récupération de l'autre utilisateur (celui qui n'est pas moi)
        $receiver = $this->conversation
            ? $this->conversation->users->where('id', '!=', auth()->id())->first()
            : null;

        return view('livewire.chat.chat-header', [
            'receiver' => $receiver
        ]);
    }
}
