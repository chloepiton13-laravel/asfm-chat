{{-- resources/views/profile/two-factor-authentication.blade.php --}}

<x-layouts::auth-app>
<div class="max-w-xl mx-auto py-20 px-6">

    <!-- HEADER SECTION -->
    <div class="mb-12 border-l-4 border-emerald-500 pl-6">
        <h2 class="text-white text-3xl font-black italic uppercase tracking-tighter">Security Terminal</h2>
        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.3em]">Gestion du protocole 2FA</p>
    </div>

    {{-- AFFICHAGE DES ALERTES (ERREURS OU REDIRECTION MIDDLEWARE) --}}
    @if (session('status') == 'two-factor-authentication-enabled')
        <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-emerald-500 text-[9px] font-black uppercase text-center italic tracking-widest">
            Protocole initialisé avec succès. Scannez le QR Code.
        </div>
    @endif

    @if (session('warning'))
        <div class="mb-8 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-500 text-[9px] font-black uppercase text-center italic tracking-widest">
            ⚠️ {{ session('warning') }}
        </div>
    @endif

    @if(! auth()->user()->two_factor_secret)
        {{-- ÉTAT A : NON-ACTIVÉ --}}
        <div class="bg-[#0A0D2E]/40 border border-white/5 p-8 rounded-[2rem]">
            <p class="text-slate-400 text-xs leading-relaxed mb-8 uppercase tracking-widest font-medium">
                L'authentification à deux facteurs n'est pas encore configurée sur ce terminal.
                Activez-la pour renforcer la protection de vos actifs.
            </p>

            <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                @csrf
                <button type="submit" class="w-full py-4 bg-white text-black font-black text-[11px] uppercase tracking-[0.4em] rounded-xl hover:bg-emerald-500 transition-all italic">
                    Initialiser le protocole
                </button>
            </form>
        </div>

    @else
        {{-- ÉTAT B : EN ATTENTE DE CONFIRMATION (QR CODE) --}}
        @if(! auth()->user()->two_factor_confirmed_at)
            <div class="bg-[#0A0D2E]/60 border-2 border-emerald-500/20 p-10 rounded-[2.5rem] text-center shadow-2xl">
                <p class="text-emerald-500 text-[9px] font-black uppercase tracking-[0.5em] mb-6 italic">Scan Required</p>

                <div class="inline-block p-4 bg-white rounded-2xl mb-8">
                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                </div>

                {{-- CODE SETUP KEY (Alternative si le scan échoue) --}}
                <div class="mb-8 px-4 py-2 bg-black/20 rounded-lg">
                    <p class="text-[8px] text-slate-500 uppercase tracking-widest font-black mb-1">Clé de configuration manuelle</p>
                    <code class="text-emerald-500 text-xs font-mono select-all">{{ decrypt(auth()->user()->two_factor_secret) }}</code>
                </div>

                <form method="POST" action="{{ url('/user/confirmed-two-factor-authentication') }}" class="space-y-6">
                    @csrf
                    <div class="space-y-2 text-left">
                        <label class="text-[9px] text-slate-500 font-black uppercase tracking-widest ml-2">Code de confirmation</label>
                        <input type="text" name="code" placeholder="000000" required autofocus autocomplete="one-time-code"
                            class="w-full py-4 bg-black/40 border @error('code', 'confirmTwoFactorAuthentication') border-red-500 @else border-white/10 @enderror rounded-xl text-white text-center text-2xl font-black tracking-[0.5em] focus:border-emerald-500 outline-none">
                        @error('code', 'confirmTwoFactorAuthentication')
                            <p class="text-red-500 text-[9px] font-black uppercase mt-1 italic tracking-widest">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-4 bg-emerald-500 text-white font-black text-[11px] uppercase tracking-[0.3em] rounded-xl">
                        Valider l'activation
                    </button>
                </form>
            </div>

        {{-- ÉTAT C : ACTIVÉ ET SÉCURISÉ --}}
        @else
            <div class="space-y-8">
                <div class="p-8 bg-emerald-500/5 border border-emerald-500/30 rounded-[2rem] relative overflow-hidden">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <span class="text-emerald-500 text-[10px] font-black uppercase tracking-widest italic">Status: Online</span>
                            <h3 class="text-white text-xl font-black italic tracking-tighter uppercase leading-tight">Système Sécurisé</h3>
                        </div>
                        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 text-[9px] font-black uppercase tracking-widest hover:underline">Désactiver</button>
                        </form>
                    </div>

                    {{-- CODES DE SECOURS --}}
                    <div class="bg-black/40 rounded-2xl p-6 border border-white/5">
                        <p class="text-slate-500 text-[9px] font-black uppercase tracking-[0.3em] mb-4">Clés de secours (Backup Keys)</p>
                        <div class="grid grid-cols-2 gap-2 font-mono text-[10px] text-emerald-500/80">
                            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                <div class="p-2 border border-white/5 rounded bg-black/20 text-center tracking-widest select-all cursor-pointer hover:bg-black/40 transition-colors">{{ $code }}</div>
                            @endforeach
                        </div>

                        <form method="POST" action="{{ url('/user/two-factor-recovery-codes') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="text-[8px] text-slate-500 hover:text-white uppercase font-black tracking-widest transition-colors italic">
                                Régénérer les clés
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
</x-layouts::auth-app>
