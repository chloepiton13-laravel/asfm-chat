<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\Friend;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatSidebarGauche extends Component
{
    public $search = '';
    public $selectedConversationId = null;
    public $filter = 'all'; // Gère l'affichage des onglets

    public function acceptFriendRequest($userId)
    {
        $authId = Auth::id();
        $user = User::findOrFail($userId);

        // 1. Mise à jour des statuts d'amitié
        Friend::where('user_id', $userId)
            ->where('friend_id', $authId)
            ->update(['status' => 'accepted']);

        Friend::updateOrCreate(
            ['user_id' => $authId, 'friend_id' => $userId],
            ['status' => 'accepted']
        );

        // 2. Création automatique de la conversation (pour l'onglet Amis)
        $existingConversation = Conversation::where('is_group', false)
            ->whereHas('users', fn($q) => $q->where('users.id', $authId))
            ->whereHas('users', fn($q) => $q->where('users.id', $userId))
            ->first();

        if (!$existingConversation) {
            $conversation = Conversation::create([
                'is_group' => false,
                'last_message_at' => now()
            ]);
            $conversation->users()->attach([$authId, $userId]);
        }

        // 3. Envoi des événements (Refresh + Toast)
        $this->dispatch('friendAccepted', id: $userId);

        // Notification Toast pour l'utilisateur
        $this->dispatch('notify', [
            'type'    => 'success',
            'message' => "Vous êtes maintenant ami avec {$user->name} !",
            'title'   => "Invitation acceptée"
        ]);
    }

    public function acceptFriend($userId)
    {
        $authId = auth()->id();
        $user = \App\Models\User::findOrFail($userId);

        // 1. Mise à jour du statut en 'accepted' via la relation définie dans User.php
        // On met à jour la ligne où l'on est le 'friend_id' (demande reçue)
        auth()->user()->friendRequestsReceived()->updateExistingPivot($userId, [
            'status' => 'accepted'
        ]);

        // On s'assure que la relation inverse existe aussi (bonne pratique pour les requêtes)
        auth()->user()->friends()->syncWithoutDetaching([
            $userId => ['status' => 'accepted']
        ]);

        // 2. Création automatique de la conversation si elle n'existe pas
        $existingConversation = \App\Models\Conversation::where('is_group', false)
            ->whereHas('users', fn($q) => $q->where('users.id', $authId))
            ->whereHas('users', fn($q) => $q->where('users.id', $userId))
            ->first();

        if (!$existingConversation) {
            $conversation = \App\Models\Conversation::create([
                'is_group' => false,
                'last_message_at' => now()
            ]);
            $conversation->users()->attach([$authId, $userId]);
        }

        // 3. Notifications et rafraîchissement
        $this->dispatch('notify',
            type: 'success',
            message: "Vous êtes maintenant ami avec {$user->name} !",
            title: "Invitation acceptée"
        );

        // On vide la recherche pour voir la liste d'amis mise à jour
        $this->reset('search');
    }


    public function declineFriendRequest($userId)
    {
        $authId = Auth::id();
        Friend::where(function($q) use ($authId, $userId) {
            $q->where('user_id', $authId)->where('friend_id', $userId);
        })->orWhere(function($q) use ($authId, $userId) {
            $q->where('user_id', $userId)->where('friend_id', $authId);
        })->where('status', 'pending')->delete();
    }

    public function toggleFriendship($userId)
    {
        $authId = Auth::id();
        Friend::updateOrCreate(
            ['user_id' => $authId, 'friend_id' => $userId],
            ['status' => 'pending']
        );
    }

    public function addFriend($userId)
    {
        $user = auth()->user();

        // 1. Sécurité : On ne s'ajoute pas soi-même
        if ($userId == $user->id) return;

        // 2. Vérification : Est-ce qu'une relation existe déjà ?
        // On vérifie dans la table pivot 'friends'
        $exists = \DB::table('friends')
            ->where(function($q) use ($user, $userId) {
                $q->where('user_id', $user->id)->where('friend_id', $userId);
            })
            ->orWhere(function($q) use ($user, $userId) {
                $q->where('user_id', $userId)->where('friend_id', $user->id);
            })
            ->exists();

        if (!$exists) {
            // 3. On utilise la relation 'friendRequestsSent' pour créer la demande
            // Le statut est mis à 'pending' par défaut via le pivot
            $user->friendRequestsSent()->attach($userId, ['status' => 'pending']);

            $this->dispatch('notify', message: 'Demande d\'ami envoyée !');
        } else {
            $this->dispatch('notify', message: 'Une relation existe déjà ou est en attente.');
        }

        // 4. On réinitialise la recherche
        $this->reset('search');
    }

    /**
     * Supprimer un ami de la liste
     */
    public function removeFriend($userId)
    {
        $authId = Auth::id();

        // On supprime la relation dans les deux sens (symétrie)
        Friend::where(function($q) use ($authId, $userId) {
            $q->where('user_id', $authId)->where('friend_id', $userId);
        })->orWhere(function($q) use ($authId, $userId) {
            $q->where('user_id', $userId)->where('friend_id', $authId);
        })
        ->where('status', 'accepted')
        ->delete();

        // Optionnel : Notifier l'utilisateur
        $this->dispatch('notify', [
            'type' => 'info',
            'message' => 'Ami supprimé de vos contacts.'
        ]);
    }


    public function render()
    {
        $authId = Auth::id();
        $users = [];
        $friendsList = [];

        // 1. RECHERCHE D'UTILISATEURS (Inchangée)
        if (strlen($this->search) >= 2) {
            $users = User::where('id', '!=', $authId)
                ->where('name', 'like', '%' . $this->search . '%')
                ->get()
                ->map(function ($user) use ($authId) {
                    $friendship = Friend::where(function($q) use ($authId, $user) {
                        $q->where('user_id', $authId)->where('friend_id', $user->id);
                    })->orWhere(function($q) use ($authId, $user) {
                        $q->where('user_id', $user->id)->where('friend_id', $authId);
                    })->first();

                    $user->friendship_status = $friendship?->status;
                    $user->is_sender = $friendship?->user_id === $authId;
                    return $user;
                })
                ->filter(fn($u) => $u->friendship_status !== 'accepted');
        }

    // 2. LOGIQUE DES AMIS (Uniquement pour l'onglet Amis)
    if ($this->filter === 'friends') {
        $friendIds = Friend::where('user_id', $authId)
            ->where('status', 'accepted')
            ->pluck('friend_id');

        $friendsList = User::whereIn('id', $friendIds)->orderBy('name', 'asc')->get();
    }

    // 3. RÉCUPÉRATION DES CONVERSATIONS (Affichage "Tous")
    $query = Auth::user()->conversations()
        ->with(['users', 'messages'])
        ->orderByDesc('last_message_at');

    // On n'ajoute de filtre QUE si on n'est PAS sur "all"
    if ($this->filter === 'conversations') {
        // Affiche uniquement les conversations privées (pas de groupes) qui ont déjà des messages
        $query->where('is_group', false)->has('messages');
    } elseif ($this->filter === 'friends') {
        // Affiche toutes les conversations individuelles (avec ou sans messages)
        $query->where('is_group', false);
    } elseif ($this->filter === 'groups') {
        // Affiche uniquement les groupes
        $query->where('is_group', true);
    }
    // Si le filtre est 'all', on ne restreint pas la requête


    // On transforme la collection pour la vue
    $conversations = $query->get()->map(function($conv) use ($authId) {
        $recipient = $conv->users->first(fn($u) => $u->id !== $authId);
        $name = $conv->is_group ? $conv->name : ($recipient->name ?? 'Utilisateur');

        $conv->display_name = $name;
        $conv->display_image = "https://ui-avatars.com" . urlencode($name);

        // Calcul simplifié du statut "Non lu"
        $userPivot = $conv->users->where('id', $authId)->first()->pivot ?? null;
        // Remplacez votre ligne 156 par celle-ci :
        $lastReadAt = $userPivot->last_read_at ?? '1970-01-01 00:00:00';
        $conv->has_unread = $conv->last_message_at > $lastReadAt;
        //$conv->last_msg_body = $conv->messages->sortByDesc('created_at')->first()?->body ?? 'Aucun message';

        return $conv;
    });

    // 4. CALCUL DES BADGES (Optionnel - à simplifier si erreur)
    $allUnread = $conversations->where('has_unread', true)->count();
    $friendsUnread = $conversations->where('is_group', false)->where('has_unread', true)->count();

    return view('livewire.chat.chat-sidebar-gauche', [
        'conversations' => $conversations,
        'users' => $users,
        'friendsList' => $friendsList,
        'allUnread' => $allUnread,
        'friendsUnread' => $friendsUnread
    ]);
}


}
