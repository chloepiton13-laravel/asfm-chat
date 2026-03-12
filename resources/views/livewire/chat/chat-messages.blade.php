<div class="flex-1 overflow-y-auto p-6 space-y-6 custom-scrollbar">
    @if($selectedConversationId)
        <div class="flex justify-center">
            <span class="px-3 py-1 bg-slate-200/50 dark:bg-slate-800 text-[10px] font-semibold text-slate-500 rounded-full uppercase tracking-wider">Aujourd'hui</span>
        </div>

        @foreach($messages as $message)
            @if($message->user_id !== auth()->id())
                {{-- MESSAGE REÇU (GAUCHE) --}}
                <div class="flex items-end gap-3 max-w-[80%]">
                    <div class="h-8 w-8 shrink-0 rounded-full bg-slate-100 overflow-hidden">
                        <img alt="{{ $message->sender->name }}" class="h-full w-full object-cover"
                             src="{{ $message->sender?->avatar ?? 'https://ui-avatars.com' . urlencode($message->sender->name) }}"/>
                    </div>
                    <div class="space-y-1">
                        <div class="rounded-xl rounded-bl-none bg-white dark:bg-slate-800 p-4 shadow-sm border border-slate-100 dark:border-slate-700">
                            @if($message->body) <p class="text-sm leading-relaxed">{{ $message->body }}</p> @endif

                            {{-- AFFICHAGE DU FICHIER SI PRÉSENT --}}
                            @if($message->hasMedia('attachments'))
                                <div class="mt-2 flex items-center gap-2 p-2 bg-slate-50 dark:bg-slate-900/50 rounded-lg border border-slate-100 dark:border-slate-700">
                                    <span class="material-symbols-outlined text-primary">description</span>
                                    <span class="text-[11px] font-medium truncate max-w-[120px]">{{ $message->getFirstMedia('attachments')->file_name }}</span>
                                    <a href="{{ $message->getFirstMediaUrl('attachments') }}" target="_blank" class="material-symbols-outlined text-primary text-sm ml-auto">download</a>
                                </div>
                            @endif
                        </div>
                        <span class="text-[10px] text-slate-400">{{ $message->created_at->format('H:i A') }}</span>
                    </div>
                </div>
            @else
                {{-- MESSAGE ENVOYÉ (DROITE) --}}
                <div class="flex flex-row-reverse items-end gap-3 max-w-[80%] ml-auto">
                    <div class="h-8 w-8 shrink-0 rounded-full bg-primary/20 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-sm">shield_person</span>
                    </div>
                    <div class="space-y-1 text-right">
                        <div class="rounded-xl rounded-br-none bg-primary text-white p-4 shadow-lg shadow-primary/10">
                            @if($message->body) <p class="text-sm leading-relaxed">{{ $message->body }}</p> @endif

                            {{-- AFFICHAGE DU FICHIER SI PRÉSENT --}}
                            @if($message->hasMedia('attachments'))
                                <div class="mt-2 flex items-center gap-2 p-2 bg-white/10 rounded-lg border border-white/20 text-left">
                                    <span class="material-symbols-outlined text-white">description</span>
                                    <span class="text-[11px] font-medium truncate max-w-[120px] text-white">{{ $message->getFirstMedia('attachments')->file_name }}</span>
                                    <a href="{{ $message->getFirstMediaUrl('attachments') }}" target="_blank" class="material-symbols-outlined text-white text-sm ml-auto">download</a>
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center justify-end gap-1">
                            <span class="text-[10px] text-slate-400">{{ $message->created_at->format('H:i A') }}</span>
                            <span class="material-symbols-outlined text-primary text-xs" style="font-variation-settings: 'FILL' 1">done_all</span>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="flex h-full items-center justify-center text-slate-400">
            Sélectionnez une conversation pour voir les messages.
        </div>
    @endif
</div>

<script>
    window.addEventListener('loadConversation', event => {
        setTimeout(() => {
            const container = document.querySelector('.custom-scrollbar');
            if (container) container.scrollTop = container.scrollHeight;
        }, 50);
    });

    window.addEventListener('messages-loaded', event => {
        const container = document.querySelector('.custom-scrollbar');
        if (container) container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
    });
</script>
