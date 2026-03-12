@if ($paginator->hasPages())
    <div class="flex items-center justify-between px-4 py-3 sm:px-6">
        <!-- Version Mobile (Simple) -->
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-300 cursor-not-allowed">Précédent</span>
            @else
                <button wire:click="previousPage" class="relative inline-flex items-center rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Précédent</button>
            @endif

            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" class="relative ml-3 inline-flex items-center rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Suivant</button>
            @else
                <span class="relative ml-3 inline-flex items-center rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-300 cursor-not-allowed">Suivant</span>
            @endif
        </div>

        <!-- Version Desktop -->
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">
                    Affichage de <span class="font-bold text-slate-700">{{ $paginator->firstItem() }}</span> à <span class="font-bold text-slate-700">{{ $paginator->lastItem() }}</span> sur <span class="font-bold text-slate-700">{{ $paginator->total() }}</span> équipes
                </p>
            </div>

            <div>
                <nav class="isolate inline-flex -space-x-px rounded-xl shadow-sm" aria-label="Pagination">
                    {{-- Bouton Précédent --}}
                    <button wire:click="previousPage" @disabled($paginator->onFirstPage()) class="relative inline-flex items-center rounded-l-xl px-2 py-2 text-slate-400 border border-slate-200 bg-white hover:bg-slate-50 disabled:opacity-50 transition-colors">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </button>

                    {{-- Numéros de pages --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-400 border-y border-slate-200 bg-white">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <button wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                    @class([
                                        'relative inline-flex items-center px-4 py-2 text-sm font-bold border border-slate-200 transition-all',
                                        'z-10 bg-primary text-white border-primary shadow-lg shadow-primary/20' => $page == $paginator->currentPage(),
                                        'bg-white text-slate-600 hover:bg-slate-50' => $page != $paginator->currentPage(),
                                    ])>
                                    {{ $page }}
                                </button>
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Bouton Suivant --}}
                    <button wire:click="nextPage" @disabled(!$paginator->hasMorePages()) class="relative inline-flex items-center rounded-r-xl px-2 py-2 text-slate-400 border border-slate-200 bg-white hover:bg-slate-50 disabled:opacity-50 transition-colors">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </button>
                </nav>
            </div>
        </div>
    </div>
@endif
