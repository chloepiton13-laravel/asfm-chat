<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Events\MessageSent; // Importez l'événement
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class ChatInput extends Component
{
    use WithFileUploads;

    public $body = '';
    public $file;
    public $selectedConversationId;

    #[On('loadConversation')]
    public function updateConversationId($conversationId)
    {
        $this->selectedConversationId = $conversationId;
    }

    public function sendMessage()
    {
        if ((empty(trim($this->body)) && !$this->file) || !$this->selectedConversationId) {
            return;
        }

        // 1. Création du message
        $message = Message::create([
            'conversation_id' => $this->selectedConversationId,
            'user_id' => auth()->id(),
            'body' => $this->body ?? '',
            'type' => $this->file ? 'file' : 'text',
        ]);

        // 2. Gestion du fichier
        if ($this->file) {
            $message->addMedia($this->file->getRealPath())
                ->usingFileName($this->file->getClientOriginalName())
                ->toMediaCollection('attachments');
            $message->load('media');
        }

        // 🚀 AJOUTER CETTE LIGNE ICI POUR BILELE
        // Elle envoie le signal à Reverb pour prévenir le destinataire
        broadcast(new \App\Events\MessageSent($message));

        $this->reset(['body', 'file']);

        // Rafraîchit MON propre écran (localement)
        $this->dispatch('loadConversation', conversationId: $this->selectedConversationId);
    }

    public function render()
    {
        return view('livewire.chat.chat-input');
    }
}
