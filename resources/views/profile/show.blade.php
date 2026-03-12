<div class="bg-white dark:bg-slate-900 shadow rounded-xl p-8 border border-neutral-soft dark:border-slate-800">
    <h3 class="text-xl font-bold text-text-main dark:text-slate-100 mb-4">Authentification à deux facteurs</h3>

    @if(! auth()->user()->two_factor_secret)
        {{-- ÉTAT : DÉSACTIVÉ --}}
        <div class="text-sm text-text-muted mb-6">
            L'authentification à deux facteurs ajoute une sécurité supplémentaire à votre compte.
        </div>
        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
            @csrf
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-lg font-bold transition-all shadow-lg shadow-primary/20">
                Activer la protection
            </button>
        </form>
    @else
        <div class="space-y-6">
            {{-- CAS 1 : EN ATTENTE DE CONFIRMATION (QR Code affiché mais pas encore validé) --}}
            @if(is_null(auth()->user()->two_factor_confirmed_at) && config('fortify.two_factor_authentication.confirm'))
                <div class="bg-amber-50 text-amber-700 p-4 rounded-lg text-sm font-medium border border-amber-200">
                    Dernière étape : Scannez le QR Code et saisissez le code de votre application pour confirmer l'activation.
                </div>

                <div class="p-4 bg-white border-2 border-neutral-soft rounded-xl shadow-inner inline-block">
                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                </div>

                <form method="POST" action="{{ url('/user/confirmed-two-factor-authentication') }}" class="mt-4">
                    @csrf
                    <div class="flex gap-4">
                        <input type="text" name="code" placeholder="Code 6 chiffres" required
                            class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary/20 outline-none">
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg font-bold">
                            Confirmer
                        </button>
                    </div>
                </form>

            {{-- CAS 2 : TOTALEMENT ACTIVÉ --}}
            @else
                @if(session('status') == 'two-factor-authentication-enabled')
                    <div class="bg-emerald-50 text-emerald-600 p-4 rounded-lg text-sm font-medium border border-emerald-100">
                        Le 2FA est maintenant actif et confirmé !
                    </div>
                @endif

                <div class="flex flex-col md:flex-row gap-8 items-start">
                    {{-- Codes de récupération --}}
                    <div class="flex-1 w-full">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-sm font-bold text-text-main dark:text-slate-200">Codes de secours :</p>
                            <form method="POST" action="{{ url('/user/two-factor-recovery-codes') }}">
                                @csrf
                                <button type="submit" class="text-xs text-primary font-bold hover:underline">Régénérer</button>
                            </form>
                        </div>
                        <div class="grid grid-cols-2 gap-2 bg-background-light dark:bg-slate-800 p-4 rounded-lg font-mono text-xs border">
                            @foreach (auth()->user()->recoveryCodes() as $code)
                                <div class="p-1 text-center">{{ $code }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- BOUTON DE DÉSACTIVATION --}}
            <div class="pt-4 border-t">
                <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm underline underline-offset-4">
                        Désactiver le 2FA
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
