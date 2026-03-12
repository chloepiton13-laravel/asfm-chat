<x-layouts::auth-app>
<div class="flex-1 flex items-center justify-center p-4">
    <div class="w-full max-w-[450px]">

        <!-- Header -->
        <div class="flex flex-col items-center mb-8 text-center">
            <div class="bg-primary/10 p-3 rounded-xl mb-4 text-primary">
                <span class="material-symbols-outlined text-4xl">lock_reset</span>
            </div>
            <h1 class="text-3xl font-bold text-text-main dark:text-slate-100 tracking-tight">Nouveau mot de passe</h1>
            <p class="text-text-muted mt-2 font-medium">Réinitialisez votre accès en toute sécurité</p>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-slate-900 shadow-xl shadow-primary/5 rounded-xl border border-neutral-soft dark:border-slate-800 overflow-hidden">

            <form method="POST" action="{{ route('password.update') }}" class="p-8 flex flex-col gap-5">
                @csrf

                <!-- Le Token (Caché mais obligatoire) -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email (Pré-rempli pour la sécurité) -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-text-main dark:text-slate-200 mb-2">Email</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-4 text-text-muted">mail</span>
                        <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required readonly
                            class="w-full pl-12 pr-4 py-3.5 bg-neutral-soft/20 dark:bg-slate-800/50 border border-neutral-soft dark:border-slate-700 rounded-lg text-text-muted outline-none cursor-not-allowed" />
                    </div>
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-text-main dark:text-slate-200 mb-2">Nouveau mot de passe</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-4 text-text-muted">lock</span>
                        <input type="password" id="password" name="password" required autofocus placeholder="••••••••"
                            class="w-full pl-12 pr-4 py-3.5 bg-background-light dark:bg-slate-800 border @error('password') border-red-500 @else border-neutral-soft dark:border-slate-700 @enderror rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-text-main dark:text-slate-100" />
                    </div>
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-text-main dark:text-slate-200 mb-2">Confirmer le mot de passe</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-4 text-text-muted">lock_reset</span>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••"
                            class="w-full pl-12 pr-4 py-3.5 bg-background-light dark:bg-slate-800 border border-neutral-soft dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-text-main dark:text-slate-100" />
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/20 transition-all transform active:scale-[0.98] flex items-center justify-center gap-2 mt-2">
                    Mettre à jour le mot de passe
                </button>
            </form>

        </div>
    </div>
</div>
</x-layouts::auth-app>
