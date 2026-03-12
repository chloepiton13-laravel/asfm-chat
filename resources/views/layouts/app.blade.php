<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased bg-gray-50">

  <main class="flex-1 overflow-y-auto p-8">
      {{ $slot }}
  </main>

    @livewireScripts

    <!-- SYSTÈME DE NOTIFICATIONS ALPINE.JS -->
    <div x-data="{
            notifications: [],
            add(e) {
                // Support pour Livewire 3 (e.detail)
                const data = e.detail[0] || e.detail;
                const id = Date.now();

                this.notifications.push({
                    id: id,
                    type: data.type || 'success',
                    message: data.message || ''
                });
                setTimeout(() => this.remove(id), 4500);
            },
            remove(id) {
                this.notifications = this.notifications.filter(n => n.id !== id);
            }
         }"
         @notify.window="add($event)"
         class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 w-full max-w-xs pointer-events-none">

        <template x-for="notice in notifications" :key="notice.id">
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-12"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-end="opacity-0 transform scale-90"
                 class="pointer-events-auto flex items-center p-4 rounded-xl shadow-2xl border-l-4 text-white font-bold text-sm"
                 :class="{
                    'bg-emerald-600 border-emerald-800': notice.type === 'success',
                    'bg-red-600 border-red-800': notice.type === 'error',
                    'bg-blue-600 border-blue-800': notice.type === 'info',
                    'bg-amber-500 border-amber-700': notice.type === 'warning'
                 }">

                <div class="flex-1 mr-2" x-text="notice.message"></div>

                <button @click="remove(notice.id)" class="text-white hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </template>
    </div>
</body>
</html>
