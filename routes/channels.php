<?php

use Illuminate\Support\Facades\Broadcast;

// routes/channels.php
Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    $conversation = \App\Models\Conversation::find($conversationId);
    // Vérifie si l'utilisateur fait partie de la conversation
    return $conversation && $conversation->users->contains($user->id);
});
