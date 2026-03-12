<x-layouts::auth-app>
<div class="flex-1 flex items-center justify-center p-4">
    <div class="w-full max-w-[450px]">
        <!-- Logo + Header -->
        <div class="flex flex-col items-center mb-8">
            <div class="bg-primary/10 p-3 rounded-xl mb-4">
                <svg class="size-12 text-primary" fill="none" viewBox="0 0 48 48">
                    <path d="M24 4C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm1 31h-2v-2h2v2zm0-6h-2V13h2v16z" fill="currentColor" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-text-main dark:text-slate-100 tracking-tight">Mot de passe oublié</h1>
            <p class="text-text-muted mt-2 font-medium text-center px-4">
                Entrez votre email pour recevoir un lien de réinitialisation.
            </p>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-slate-900 shadow-xl shadow-primary/5 rounded-xl border border-neutral-soft dark:border-slate-800 overflow-hidden">

            <!-- Message de succès (Session Status) -->
            @if (session('status'))
                <div class="bg-emerald-50 dark:bg-emerald-900/20 p-4 border-b border-emerald-100 dark:border-emerald-800 text-sm text-emerald-600 dark:text-emerald-400 font-medium text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="p-8 flex flex-col gap-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-text-main dark:text-slate-200 mb-2">Email</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-4 text-text-muted">mail</span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="votre-email@exemple.com"
                            class="w-full pl-12 pr-4 py-3.5 bg-background-light dark:bg-slate-800 border @error('email') border-red-500 @else border-neutral-soft dark:border-slate-700 @enderror rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-text-main dark:text-slate-100" />
                    </div>
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all transform active:scale-[0.98] flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-xl">send</span>
                    Envoyer le lien
                </button>
            </form>

            <!-- Back to Login -->
            <div class="px-8 py-6 bg-neutral-soft/30 dark:bg-slate-800/50 border-t border-neutral-soft dark:border-slate-800 text-center">
                <a href="{{ route('login') }}" class="text-sm text-primary font-bold hover:underline inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Retour à la connexion
                </a>
            </div>
        </div>
    </div>
</div>
</x-layouts::auth-app>
