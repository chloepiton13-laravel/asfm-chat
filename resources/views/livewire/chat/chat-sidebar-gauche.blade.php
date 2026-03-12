<aside class="flex w-80 flex-col border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shrink-0 relative">

    <div class="p-4 space-y-4 flex-1 flex flex-col">

        <!-- HEADER -->
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Chats</h2>
            <button class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary hover:bg-primary/20 transition-colors">
                <span class="material-symbols-outlined text-xl">add</span>
            </button>
        </div>

        <!-- RECHERCHE -->
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">
                search
            </span>
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Rechercher des discussions ou des amis..."
                class="h-10 w-full rounded-lg border-none bg-slate-100 dark:bg-slate-800 pl-10 text-sm focus:ring-2 focus:ring-primary/20 dark:text-white"
            />
        </div>
        <!-- FILTRES -->
        <div class="flex border-b border-slate-100 dark:border-slate-800">

            {{-- NOUVEL ONGLET CONV --}}
            <button wire:click="$set('filter', 'conversations')"
                class="flex-1 py-2.5 text-xs font-semibold transition-all duration-200
                {{ $filter === 'conversations' ? 'text-primary border-b-2 border-primary bg-primary/5' : 'text-slate-500 hover:bg-slate-50' }}">
                Conv
                @if($conversations->where('has_unread', true)->count() > 0)
                    <span class="ml-1 bg-primary text-white text-[10px] px-1.5 py-0.5 rounded-full">
                        {{ $conversations->where('has_unread', true)->count() }}
                    </span>
                @endif
            </button>

            <button wire:click="$set('filter', 'all')"
                class="flex-1 py-2.5 text-xs font-semibold transition-all duration-200
                {{ $filter === 'all' ? 'text-primary border-b-2 border-primary bg-primary/5' : 'text-slate-500 hover:bg-slate-50' }}">
                Tous
                @if($allUnread > 0)
                    <span class="ml-1 bg-primary text-white text-[10px] px-1.5 py-0.5 rounded-full">
                        {{ $allUnread }}
                    </span>
                @endif
            </button>

            <button wire:click="$set('filter', 'friends')"
                class="flex-1 py-2.5 text-xs font-semibold transition-all duration-200
                {{ $filter === 'friends' ? 'text-primary border-b-2 border-primary bg-primary/5' : 'text-slate-500 hover:bg-slate-50' }}">
                Amis
            </button>

            <button wire:click="$set('filter', 'groups')"
                class="flex-1 py-2.5 text-xs font-semibold transition-all duration-200
                {{ $filter === 'groups' ? 'text-primary border-b-2 border-primary bg-primary/5' : 'text-slate-500 hover:bg-slate-50' }}">
                Groupes
            </button>

        </div>


        <!-- SCROLL PRINCIPAL -->
        <div class="flex-1 overflow-y-auto custom-scrollbar mt-2">

            {{-- ========================= --}}
            {{-- 🔎 RESULTATS RECHERCHE --}}
            {{-- ========================= --}}
            @if(strlen($search) >= 2)
                <div class="space-y-1">
                    <p class="px-4 mb-2 text-[10px] font-bold uppercase tracking-wider text-primary">
                        Résultats
                    </p>

                    {{-- resources/views/livewire/chat/chat-sidebar-gauche.blade.php --}}

                    @forelse($users as $user)
                        <div class="flex items-center justify-between px-4 py-2 hover:bg-primary/5 transition-all group">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="h-9 w-9 rounded-full overflow-hidden border border-slate-200">
                                    <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com' . urlencode($user->name) }}" class="h-full w-full object-cover" />
                                </div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white truncate">
                                    {{ $user->name }}
                                </p>
                            </div>

                            @if($user->id !== auth()->id())
                                @if(auth()->user()->friends->contains($user->id))
                                    {{-- Déjà amis --}}
                                    <span class="text-[10px] font-bold text-green-500 uppercase">Ami</span>
                                @elseif(auth()->user()->friendRequestsSent->contains($user->id))
                                    {{-- Demande envoyée --}}
                                    <span class="text-[10px] font-bold text-orange-500 uppercase">En attente</span>
                                @elseif(auth()->user()->friendRequestsReceived->contains($user->id))
                                    {{-- Il m'a envoyé une demande : Bouton pour accepter --}}
                                    <button wire:click="acceptFriend({{ $user->id }})" class="p-1.5 text-green-600 hover:bg-green-50 rounded-full">
                                        <span class="material-symbols-outlined text-xl">person_check</span>
                                    </button>
                                @else
                                    {{-- Personne : Bouton ajouter --}}
                                    <button wire:click="addFriend({{ $user->id }})" class="p-1.5 text-primary hover:bg-primary/10 rounded-full transition-colors">
                                        <span class="material-symbols-outlined text-xl">person_add</span>
                                    </button>
                                @endif
                            @endif
                        </div>
                    @empty
                        <p class="px-4 text-xs text-slate-500 italic">Aucun résultat trouvé</p>
                    @endforelse


                </div>
            @else
                {{-- ========================= --}}
                {{-- 👥 LISTE DES AMIS --}}
                {{-- ========================= --}}
                {{-- 💬 ONGLET CONVERSATIONS (Conv) --}}
                {{-- ========================= --}}
                @if($filter === 'conversations' || $filter === 'all')
                    <div class="space-y-1">
                        @forelse($conversations as $conversation)
                            {{-- Insérez ici votre bloc de design "conversations" (celui avec has_unread, display_image, etc.) --}}
                            <div wire:key="conv-{{ $conversation->id }}"
                                 wire:click="$dispatch('chatSelected', { id: {{ $conversation->id }} })"
                                 class="flex items-center gap-3 px-4 py-3 cursor-pointer transition-all border-b border-slate-50 dark:border-slate-800/50
                                 {{ $selectedConversationId == $conversation->id ? 'bg-primary/10 border-r-4 border-primary' : 'hover:bg-slate-50 dark:hover:bg-slate-800/50' }}">
                                 {{-- ... Votre contenu de conversation ... --}}
                            </div>
                        @empty
                            @if($filter === 'conversations')
                                <p class="p-8 text-center text-sm text-slate-500 italic">Aucune discussion active</p>
                            @endif
                        @endforelse
                    </div>
                @endif

                {{-- ========================= --}}
                {{-- 👥 LISTE DES AMIS --}}
                {{-- ========================= --}}
                @if($filter === 'friends' || $filter === 'all')
                    <div class="space-y-1 {{ $filter === 'all' ? 'mt-4 border-t border-slate-100 pt-2' : '' }}">
                        @if($filter === 'all')
                             <p class="px-4 mb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Mes Amis</p>
                        @endif

                        @foreach($friendsList as $friend)
                            {{-- Votre code existant pour la boucle friendsList --}}
                            <div wire:key="friend-{{ $friend->id }}" ...>
                                {{-- ... --}}
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- ========================= --}}
                {{-- 💬 CONVERSATIONS --}}
                {{-- ========================= --}}
                <div class="mt-3 border-t border-slate-100 dark:border-slate-800"></div>
                <div class="space-y-1">
                    @forelse($conversations as $conversation)
                        <div wire:key="conv-{{ $conversation->id }}"
                             wire:click="$dispatch('chatSelected', { id: {{ $conversation->id }} })"
                             class="flex items-center gap-3 px-4 py-3 cursor-pointer transition-all border-b border-slate-50 dark:border-slate-800/50
                             {{ $selectedConversationId == $conversation->id ? 'bg-primary/10 border-r-4 border-primary' : 'hover:bg-slate-50 dark:hover:bg-slate-800/50' }}">
                            <div class="relative h-12 w-12 shrink-0">
                                @if($conversation->is_group)
                                    <div class="h-12 w-12 flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500">
                                        <span class="material-symbols-outlined">groups</span>
                                    </div>
                                @else
                                    <img class="rounded-full h-full w-full object-cover shadow-sm"
                                         src="{{ $conversation->display_image }}"
                                         alt="{{ $conversation->display_name }}" />
                                    @if($conversation->is_online)
                                        <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-500 ring-2 ring-white dark:ring-slate-900"></span>
                                    @endif
                                @endif
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-semibold truncate">
                                        {{ $conversation->display_name }}
                                    </span>
                                    <span class="text-[10px] text-slate-400">
                                        {{ $conversation->last_message_at?->diffForHumans(null, true) }}
                                    </span>
                                </div>
                                <p class="text-xs truncate">
                                    {{ $conversation->last_msg_body }}
                                </p>
                            </div>
                            @if($conversation->has_unread)
                                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-primary text-[10px] font-bold text-white shadow-sm">
                                    !
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <span class="material-symbols-outlined text-slate-300 text-4xl mb-2">
                                chat_bubble_outline
                            </span>
                            <p class="text-sm text-slate-500">
                                Aucune discussion trouvée.
                            </p>
                        </div>
                    @endforelse
                </div>
            @endif

        </div>

    </div>
</aside>
