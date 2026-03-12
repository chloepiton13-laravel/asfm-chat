<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use Livewire\Attributes\{Layout, Title, On, Url};

#[Layout('layouts::chat-app')]
#[Title('Chat')]
class ChatApp extends Component
{
    #[Url(as: 'c')]
    public $selectedConversationId;

    /**
     * mount() récupère l'ID, mais on ne dispatch pas encore
     */
    public function mount()
    {
        if ($this->selectedConversationId) {
            // Optionnel : vérification de sécurité immédiate
            $conversation = Conversation::find($this->selectedConversationId);
            if (!$conversation || !$conversation->users->contains(auth()->id())) {
                $this->selectedConversationId = null;
            }
        }
    }

    /**
     * Dispatch l'ID après que les composants enfants soient initialisés
     */
    public function rendered()
    {
        if ($this->selectedConversationId) {
            $this->dispatch('loadConversation', conversationId: $this->selectedConversationId);
        }
    }

    #[On('chatSelected')]
    public function updateSelectedConversation($id)
    {
        $this->selectedConversationId = $id;

        $conversation = Conversation::findOrFail($id);
        if (!$conversation->users->contains(auth()->id())) {
            abort(403, 'Accès non autorisé.');
        }

        $this->dispatch('loadConversation', conversationId: $id);
    }

    public function render()
    {
        return view('livewire.chat.chat-app');
    }
}
