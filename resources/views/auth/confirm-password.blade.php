<x-layouts::auth-app>
<div class="flex-1 flex items-center justify-center p-4">
    <div class="w-full max-w-[450px]">

        <!-- Header -->
        <div class="flex flex-col items-center mb-8 text-center">
            <div class="bg-primary/10 p-4 rounded-full mb-4 text-primary">
                <span class="material-symbols-outlined text-4xl">lock_person</span>
            </div>
            <h1 class="text-3xl font-bold text-text-main dark:text-slate-100 tracking-tight">Zone Sécurisée</h1>
            <p class="text-text-muted mt-2 font-medium px-6">
                Pour votre sécurité, veuillez confirmer votre mot de passe avant de modifier vos paramètres de double authentification.
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-slate-900 shadow-xl shadow-primary/5 rounded-xl border border-neutral-soft dark:border-slate-800 overflow-hidden">

            <form method="POST" action="{{ route('password.confirm') }}" class="p-8 flex flex-col gap-6">
                @csrf

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-text-main dark:text-slate-200 mb-2">Mot de passe actuel</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-4 text-text-muted">lock</span>
                        <input type="password" id="password" name="password" required autofocus autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full pl-12 pr-4 py-3.5 bg-background-light dark:bg-slate-800 border @error('password') border-red-500 @else border-neutral-soft dark:border-slate-700 @enderror rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-text-main dark:text-slate-100" />
                    </div>
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all transform active:scale-[0.98] flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-xl">key</span>
                    Confirmer l'accès
                </button>
            </form>

            <!-- Back Footer -->
            <div class="px-8 py-4 bg-neutral-soft/30 dark:bg-slate-800/50 border-t border-neutral-soft dark:border-slate-800 text-center">
                <a href="{{ url()->previous() }}" class="text-xs text-text-muted hover:text-primary transition-colors">
                    Annuler et retourner en arrière
                </a>
            </div>
        </div>
    </div>
</div>
</x-layouts::auth-app>
