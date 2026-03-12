<x-layouts::auth-app>
<div class="flex-1 flex items-center justify-center p-4">
    <div class="w-full max-w-[450px]">

        <!-- Header -->
        <div class="flex flex-col items-center mb-8 text-center">
            <div class="bg-primary/10 p-4 rounded-full mb-4 text-primary">
                <span class="material-symbols-outlined text-4xl">security</span>
            </div>
            <h1 class="text-3xl font-bold text-text-main dark:text-slate-100 tracking-tight">Authentification Forte</h1>
            <p class="text-text-muted mt-2 font-medium px-6">
                Saisissez le code généré par votre application d'authentification (Google Authenticator, Authy, etc.).
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-slate-900 shadow-xl shadow-primary/5 rounded-xl border border-neutral-soft dark:border-slate-800 overflow-hidden">

            <form method="POST" action="{{ route('two-factor.login') }}" class="p-8 flex flex-col gap-6">
                @csrf

                <!-- Code d'authentification -->
                <div>
                    <label for="code" class="block text-sm font-semibold text-text-main dark:text-slate-200 mb-2">Code de sécurité</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-4 text-text-muted">pin</span>
                        <input type="text" id="code" name="code" inputmode="numeric" autofocus autocomplete="one-time-code"
                            placeholder="000000"
                            class="w-full pl-12 pr-4 py-3.5 bg-background-light dark:bg-slate-800 border @error('code') border-red-500 @else border-neutral-soft dark:border-slate-700 @enderror rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-text-main dark:text-slate-100 tracking-[0.5em] text-center text-xl font-bold" />
                    </div>
                    @error('code') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Alternative : Code de secours (Recovery Code) -->
                <div x-data="{ open: false }">
                    <button type="button" @click="open = !open" class="text-xs text-primary font-semibold hover:underline">
                        Utiliser un code de secours ?
                    </button>

                    <div x-show="open" class="mt-4">
                        <label for="recovery_code" class="block text-sm font-semibold text-text-main dark:text-slate-200 mb-2">Code de secours</label>
                        <input type="text" id="recovery_code" name="recovery_code" placeholder="xxxx-xxxx-xxxx"
                            class="w-full px-4 py-3.5 bg-background-light dark:bg-slate-800 border border-neutral-soft dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-text-main dark:text-slate-100 font-mono" />
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all transform active:scale-[0.98] flex items-center justify-center gap-2">
                    Vérifier le code
                </button>
            </form>

        </div>
    </div>
</div>
</x-layouts::auth-app>
