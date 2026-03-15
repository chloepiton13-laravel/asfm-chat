<x-layouts::auth-app>
<style>
    .ice-glow { box-shadow: 0 0 30px rgba(6, 182, 212, 0.15), inset 0 0 15px rgba(6, 182, 212, 0.05); }
    .ice-border { border: 1px solid rgba(6, 182, 212, 0.2); }
    .scan-line {
        height: 2px;
        background: rgba(34, 211, 238, 0.5);
        box-shadow: 0 0 15px #22d3ee;
        animation: scan 3s linear infinite;
    }
    @keyframes scan { 0% { top: 0; } 100% { top: 100%; } }
</style>

<div class="min-h-screen w-full flex items-center justify-center bg-[#050505] p-6 selection:bg-amber-500/40">
    <div class="max-w-[440px] w-full relative">
    <!-- ACE BERG SECURITY HEADER -->
    <div class="mb-12 relative">
        <div class="absolute -left-4 top-0 w-1.5 h-full bg-cyan-500 shadow-[0_0_20px_#22d3ee]"></div>
        <div class="pl-6">
            <h2 class="text-white text-4xl font-black italic uppercase tracking-tighter flex items-center gap-3">
                ACE <span class="text-cyan-400">BERG</span>
                <span class="text-[9px] bg-cyan-500/10 text-cyan-400 px-2 py-1 rounded-sm tracking-[0.3em] border border-cyan-500/30 animate-pulse">SHIELD_ACTIVE</span>
            </h2>
            <p class="text-slate-500 text-[9px] font-black uppercase tracking-[0.5em] mt-2 italic">Protocol: Zero-Trust // Security_Terminal_Access</p>
        </div>
    </div>

    {{-- ALERTES SYSTÈME --}}
    @if (session('status') == 'two-factor-authentication-enabled')
        <div class="mb-8 p-4 bg-cyan-500/5 border border-cyan-500/30 text-cyan-400 text-[9px] font-black uppercase text-center italic tracking-[0.2em] animate-pulse">
            [ OK ] : Protocole initialisé. Scannez le vecteur de sécurité QR.
        </div>
    @endif

    @if (session('warning'))
        <div class="mb-8 p-4 bg-red-500/10 border border-red-500/30 text-red-500 text-[9px] font-black uppercase text-center italic tracking-[0.2em]">
            [ ERROR ] : {{ session('warning') }}
        </div>
    @endif

    @if(! auth()->user()->two_factor_secret)
        {{-- ÉTAT A : PROTOCOLE NON-ACTIVÉ --}}
        <div class="bg-slate-900/40 border border-slate-800 p-10 rounded-sm ice-glow relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/5 to-transparent pointer-events-none"></div>

            <p class="text-slate-400 text-[11px] leading-relaxed mb-10 uppercase tracking-widest font-bold">
                [ SYSTEM_MSG ] : L'accès aux privilèges d'administration est restreint. <br>
                Initialisez le protocole 2FA pour lever le verrouillage Ace Berg.
            </p>

            <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                @csrf
                <button type="submit" class="w-full py-4 bg-cyan-600 text-black font-black text-xs uppercase tracking-[0.5em] hover:bg-cyan-400 transition-all duration-500 shadow-lg active:scale-95">
                    INIT_SHIELD_V4
                </button>
            </form>
        </div>

    @else
        {{-- ÉTAT B : EN ATTENTE DE SCAN (QR CODE) --}}
        @if(! auth()->user()->two_factor_confirmed_at)
            <div class="bg-slate-950 border border-cyan-500/20 p-10 rounded-sm text-center ice-glow relative">
                <p class="text-cyan-500 text-[10px] font-black uppercase tracking-[0.6em] mb-8 italic animate-pulse">Scanning_Required</p>

                <div class="inline-block p-4 bg-white rounded-sm mb-10 relative overflow-hidden group">
                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                    <div class="absolute inset-0 w-full scan-line pointer-events-none"></div>
                </div>

                <div class="mb-10 px-6 py-4 bg-black/40 border border-slate-800 rounded-sm text-left">
                    <p class="text-[8px] text-slate-600 uppercase tracking-[0.2em] font-black mb-2">Clé_Manuelle_Encryptée</p>
                    <code class="text-cyan-400 text-xs font-mono select-all tracking-widest break-all">{{ decrypt(auth()->user()->two_factor_secret) }}</code>
                </div>

                <form method="POST" action="{{ url('/user/confirmed-two-factor-authentication') }}" class="space-y-8">
                    @csrf
                    <div class="space-y-3 text-left">
                        <label class="text-[9px] text-slate-500 font-black uppercase tracking-[0.3em] ml-1 italic">Entrez_Code_Auth</label>
                        <input type="text" name="code" placeholder="000000" required autofocus
                            class="w-full py-5 bg-black/60 border border-slate-800 rounded-sm text-cyan-400 text-center text-3xl font-black tracking-[0.8em] focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/5 outline-none transition-all">
                        @error('code', 'confirmTwoFactorAuthentication')
                            <p class="text-red-500 text-[9px] font-black uppercase mt-2 italic tracking-widest text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-4 bg-cyan-600 text-white font-black text-xs uppercase tracking-[0.4em] hover:bg-cyan-500 transition-all">
                        CONFIRM_LINK
                    </button>
                </form>
            </div>

        {{-- ÉTAT C : SYSTÈME SÉCURISÉ --}}
        @else
            <div class="space-y-8">
                <div class="p-10 bg-slate-900/40 border border-cyan-500/20 rounded-sm ice-glow relative overflow-hidden">
                    <div class="flex justify-between items-start mb-8 relative z-10">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full shadow-[0_0_10px_#10b981] animate-pulse"></span>
                                <span class="text-emerald-500 text-[10px] font-black uppercase tracking-widest italic font-mono underline underline-offset-4 decoration-emerald-500/30">Shield_Online</span>
                            </div>
                            <h3 class="text-white text-3xl font-black italic tracking-tighter uppercase leading-tight">Système_Intègre</h3>
                        </div>
                        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                            @csrf @method('DELETE')
                            <button class="text-red-500 text-[9px] font-black uppercase tracking-widest border-b border-red-500/30 hover:text-white hover:border-white transition-all italic">Purger_Shield</button>
                        </form>
                    </div>

                    {{-- CLÉS DE SECOURS --}}
                    <div class="bg-black/60 rounded-sm p-8 border border-slate-800 shadow-inner">
                        <div class="flex justify-between items-center mb-6">
                            <p class="text-slate-500 text-[9px] font-black uppercase tracking-[0.4em]">Emergency_Backup_Keys</p>
                            <form method="POST" action="{{ url('/user/two-factor-recovery-codes') }}">
                                @csrf
                                <button type="submit" class="text-[8px] text-cyan-600 hover:text-cyan-400 uppercase font-black tracking-widest transition-colors italic">[ RÉGÉNÉRER ]</button>
                            </form>
                        </div>

                        <div class="grid grid-cols-2 gap-3 font-mono text-[11px] text-cyan-400/80">
                            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                <div class="p-3 border border-slate-800 bg-slate-900/50 text-center tracking-widest select-all cursor-pointer hover:bg-cyan-500/5 transition-colors border-dashed">{{ $code }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="text-center pt-8">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-[9px] font-black text-slate-700 uppercase tracking-[0.5em] hover:text-cyan-500 transition-all italic">
                            Terminer_Session_Terminal
                        </button>
                    </form>
                </div>
            </div>
        @endif
    @endif
</div>
</x-layouts::auth-app>
