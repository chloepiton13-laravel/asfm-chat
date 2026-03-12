<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between px-2">
    {{-- Bouton Précédent --}}
    @if ($paginator->onFirstPage())
        <span class="p-1 text-slate-300 cursor-not-allowed">
            <span class="material-symbols-outlined text-lg">chevron_left</span>
        </span>
    @else
        <button wire:click="previousPage" wire:loading.attr="disabled" class="p-1 text-primary hover:bg-primary/10 rounded-full transition-colors">
            <span class="material-symbols-outlined text-lg font-bold">chevron_left</span>
        </button>
    @endif

    {{-- Indicateur de position (ex: 1-5 / 24) --}}
    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest flex items-center">
        {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}
        <span class="text-slate-300 mx-1">/</span>
        {{ $paginator->total() }}
    </div>

    {{-- Bouton Suivant --}}
    @if ($paginator->hasMorePages())
        <button wire:click="nextPage" wire:loading.attr="disabled" class="p-1 text-primary hover:bg-primary/10 rounded-full transition-colors">
            <span class="material-symbols-outlined text-lg font-bold">chevron_right</span>
        </button>
    @else
        <span class="p-1 text-slate-300 cursor-not-allowed">
            <span class="material-symbols-outlined text-lg">chevron_right</span>
        </span>
    @endif
</nav>
