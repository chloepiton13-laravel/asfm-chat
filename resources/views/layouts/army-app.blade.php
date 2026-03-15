<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }} | HQ Command</title>

    <!-- Google Fonts pour un look plus "Data" -->
    <link href="https://fonts.googleapis.com" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* Effet de scanline discret pour le look militaire */
        .scanline {
            background: linear-gradient(to bottom, transparent 50%, rgba(0, 255, 128, 0.02) 50%);
            background-size: 100% 4px;
        }
    </style>
    <style>
        /* PAGINATION TACTIQUE LIVEWIRE */
        nav[role="navigation"] {
            @apply flex items-center justify-between bg-slate-900/50 p-4 border border-slate-800/60 mt-6;
        }

        /* Cache le texte "Showing X to Y" sur mobile si besoin */
        nav[role="navigation"] .text-sm.text-gray-700 {
            @apply font-mono text-[10px] uppercase tracking-widest text-slate-500 font-bold !important;
        }

        /* Les boutons Précédent / Suivant et les Numéros */
        nav[role="navigation"] span[aria-current="page"] span {
            @apply bg-emerald-500 text-black border-emerald-400 font-black px-3 py-1 mx-1 rounded-sm shadow-[0_0_10px_rgba(16,185,129,0.3)] !important;
        }

        nav[role="navigation"] a,
        nav[role="navigation"] span[disabled] span {
            @apply bg-black/40 border-slate-800 text-slate-500 font-mono text-[11px] px-3 py-1 mx-1 rounded-sm hover:bg-slate-800 hover:text-emerald-400 transition-all !important;
        }

        /* Flèches de navigation */
        nav[role="navigation"] svg {
            @apply w-4 h-4 !important;
        }
    </style>

    @livewireStyles
</head>
<body class="antialiased bg-[#020617] text-slate-300 selection:bg-emerald-500/30 selection:text-emerald-400">

    <!-- Overlay de texture (Scanlines) -->
    <div class="fixed inset-0 pointer-events-none scanline z-[9999]"></div>

    <div class="min-h-screen flex flex-col relative overflow-hidden">

        <!-- Dégradé de fond radial pour donner de la profondeur -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[500px] bg-emerald-500/5 blur-[120px] rounded-full pointer-events-none"></div>

        <!-- Navigation / Header (Optionnel mais recommandé) -->
        <header class="border-b border-slate-800/60 bg-slate-950/50 backdrop-blur-xl sticky top-0 z-40">
            <div class="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-500 rounded-sm flex items-center justify-center shadow-[0_0_15px_rgba(16,185,129,0.4)]">
                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <span class="text-xs font-black uppercase tracking-[0.4em] text-white">Archives Terminal <span class="text-emerald-500">v4.0</span></span>
                </div>
                <div class="text-[10px] font-mono text-slate-500 uppercase">System Status: <span class="text-emerald-500 animate-pulse font-bold">Online</span></div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 max-w-[1600px] w-full mx-auto p-6 md:p-10 relative">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts

    <!-- SYSTÈME DE NOTIFICATIONS MILITAIRE -->
    <div x-data="{
            notifications: [],
            add(e) {
                const data = e.detail[0] || e.detail;
                const id = Date.now();
                this.notifications.push({ id, type: data.type || 'success', message: data.message || '' });
                setTimeout(() => this.remove(id), 4500);
            },
            remove(id) { this.notifications = this.notifications.filter(n => n.id !== id); }
         }"
         @notify.window="add($event)"
         class="fixed top-5 right-5 z-[10000] flex flex-col gap-3 w-full max-w-sm pointer-events-none font-mono">

        <template x-for="notice in notifications" :key="notice.id">
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="pointer-events-auto flex items-start gap-4 p-4 rounded-sm border-l-2 bg-slate-900/90 backdrop-blur-md shadow-2xl"
                 :class="{
                    'border-emerald-500 text-emerald-400': notice.type === 'success',
                    'border-red-500 text-red-400': notice.type === 'error',
                    'border-blue-500 text-blue-400': notice.type === 'info',
                    'border-amber-500 text-amber-400': notice.type === 'warning'
                 }">

                <div class="pt-0.5">
                    <template x-if="notice.type === 'success'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></template>
                    <template x-if="notice.type === 'error'"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></template>
                </div>

                <div class="flex-1">
                    <div class="text-[10px] font-black uppercase tracking-widest opacity-50 mb-1" x-text="notice.type"></div>
                    <div class="text-xs font-bold leading-relaxed" x-text="notice.message"></div>
                </div>

                <button @click="remove(notice.id)" class="opacity-50 hover:opacity-100 transition-opacity">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </template>
    </div>
</body>
</html>
