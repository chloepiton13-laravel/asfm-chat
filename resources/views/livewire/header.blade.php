<header class="sticky top-0 flex h-16 items-center justify-between border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md px-6 shrink-0 z-50">
    <div class="flex items-center gap-4">
        <!-- Logo -->
        <div class="flex items-center gap-2 text-primary">
            <span class="material-symbols-outlined text-3xl font-semibold">forum</span>
            <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                ASFM <span class="font-normal text-slate-500">Chat</span>
            </h1>
        </div>

        <!-- Navigation Desktop -->
        <nav class="ml-10 hidden lg:flex items-center gap-6">
            @foreach($navLinks as $link)
                <a href="{{ $link['url'] }}"
                   class="text-sm font-medium transition-all duration-200 {{ $link['active'] ? 'text-primary border-b-2 border-primary pb-5 mt-5' : 'text-slate-600 dark:text-slate-400 hover:text-primary' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>
    </div>

    <div class="flex items-center gap-4">
        <!-- Recherche avec Livewire -->
        <div class="relative hidden sm:block">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Global search..."
                class="h-9 w-64 rounded-lg border-none bg-slate-100 dark:bg-slate-800 pl-10 text-sm focus:ring-2 focus:ring-primary/20 transition-all"
            />
        </div>

        <!-- Notifications -->
        <button class="relative group rounded-full p-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <span class="material-symbols-outlined text-slate-600 dark:text-slate-400 group-hover:scale-110 transition-transform">notifications</span>
            <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white dark:ring-slate-900"></span>
        </button>

        <!-- Profil Dropdown -->
        <div x-data="{ open: false }" @click.away="open = false" class="relative">
            <button
                @click="open = !open"
                class="flex items-center gap-3 group focus:outline-none"
            )
                <div class="h-9 w-9 rounded-full ring-2 ring-transparent group-hover:ring-primary/30 transition-all overflow-hidden border border-slate-200 dark:border-slate-700">
                    <img alt="Admin" class="h-full w-full object-cover" src="https://ui-avatars.com"/>
                </div>
                <div class="hidden md:flex flex-col items-start leading-none">
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Admin User</span>
                    <span class="text-[10px] uppercase tracking-wider text-slate-500 font-bold">Premium</span>
                </div>
                <span class="material-symbols-outlined text-slate-400 text-sm transition-transform duration-200" :class="open ? 'rotate-180' : ''">expand_more</span>
            </button>

            <!-- Menu Déroulant -->
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-3 w-56 origin-top-right rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl z-50 overflow-hidden"
                style="display: none;"
            >
                <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-700">
                    <p class="text-xs text-slate-500 dark:text-slate-400">Connecté en tant que</p>
                    <p class="text-sm font-medium text-slate-900 dark:text-white truncate">admin@asfm-chat.com</p>
                </div>

                <div class="p-2">
                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-lg">person</span>
                        Mon Profil
                    </a>
                    <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-lg">settings</span>
                        Paramètres
                    </a>
                </div>

                <div class="p-2 border-t border-slate-100 dark:border-slate-700">
                    <button class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-lg">logout</span>
                        Déconnexion
                    </button>
                </div>
            </div>
        </div>


        <!-- Burger Menu (Mobile) -->
        <button wire:click="toggleMobileMenu" class="lg:hidden p-2 text-slate-600 dark:text-slate-400">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </div>

    <!-- Dropdown Mobile (Conditionnel) -->
    @if($isMobileMenuOpen)
        <div class="absolute top-16 left-0 w-full bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 p-4 flex flex-col gap-4 lg:hidden shadow-xl animate-in slide-in-from-top duration-200">
            @foreach($navLinks as $link)
                <a href="{{ $link['url'] }}" class="text-sm font-medium {{ $link['active'] ? 'text-primary' : 'text-slate-600' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    @endif
</header>
