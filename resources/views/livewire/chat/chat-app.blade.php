<main class="flex flex-1 overflow-hidden">
    <livewire:chat.chat-sidebar-gauche />

    @if($selectedConversationId)
        <section class="flex flex-1 flex-col bg-slate-50 dark:bg-background-dark/50 relative"
                 wire:key="chat-section-{{ $selectedConversationId }}">

            {{-- Le Header --}}
            <livewire:chat.chat-header
                :conversationId="$selectedConversationId"
                :key="'header-'.$selectedConversationId" />

            {{-- Les Messages --}}
            <livewire:chat.chat-messages
                :conversationId="$selectedConversationId"
                :key="'messages-'.$selectedConversationId" />

            {{-- L'Input --}}
            <livewire:chat.chat-input
                :conversationId="$selectedConversationId"
                :key="'input-'.$selectedConversationId" />
        </section>

        {{-- Sidebar Droite --}}
        <livewire:chat.chat-sidebar-droite
            :conversationId="$selectedConversationId"
            :key="'sidebar-right-'.$selectedConversationId" />
    @else
        {{-- État Vide --}}
        <div class="flex flex-1 flex-col items-center justify-center bg-slate-50 dark:bg-slate-900/50 text-slate-400">
            <span class="material-symbols-outlined text-6xl mb-4 opacity-20">chat_bubble</span>
            <p class="text-sm font-medium">Sélectionnez une discussion pour commencer à messager.</p>
        </div>
    @endif
</main>
