<x-layouts::auth-app>
    @slot('title', 'Enregistrement | Système Onyx')

    <div class="min-h-screen w-full flex items-center justify-center bg-[#050505] p-4 selection:bg-amber-500/30">
        <div class="max-w-md w-full relative">

            <!-- Effet Scanline Global -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden z-20 rounded-lg">
                <div class="w-full h-[1px] bg-amber-500/20 shadow-[0_0_15px_#f59e0b] animate-scan opacity-30"></div>
            </div>

            <!-- Filigrane SVG en arrière-plan -->
            <div class="absolute -top-12 -right-12 opacity-5 pointer-events-none transform rotate-12">
                <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-64 h-64 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v9m-8.25-4.51l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>

            <!-- Header ASFM IMPACT MAX (Extérieur au panel) -->
            <div class="relative z-10 text-center mb-8">
                <div class="inline-block px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 mb-4">
                    <span class="text-[8px] font-black text-amber-500 uppercase tracking-[0.3em] italic">Nouveau_Profil</span>
                </div>

                <h1 class="text-6xl font-black uppercase tracking-tighter text-amber-500 drop-shadow-[0_0_15px_rgba(245,158,11,0.5)] italic leading-none mb-2">
                    ASFM
                </h1>

                <h2 class="text-xl font-black text-white uppercase tracking-tighter mb-1 border-t border-white/10 pt-2 inline-block">
                    Enregistrement
                </h2>
                <p class="text-slate-500 text-[9px] font-bold uppercase tracking-widest italic block">Création d'accréditation_système</p>
            </div>

            <!-- Panel Flouté (Onyx) -->
            <div class="bg-white/5 backdrop-blur-2xl p-8 rounded-lg border border-white/10 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.8)] relative overflow-hidden transition-all duration-700">

                <form method="POST" action="{{ route('register') }}" class="space-y-4 relative z-10">
                    @csrf

                    <!-- Nom -->
                    <div class="group/input space-y-1.5">
                        <label class="text-[9px] font-black text-slate-500 uppercase ml-1 tracking-[0.1em] group-focus-within/input:text-amber-500 transition-colors">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="IDENT_NOM"
                            class="w-full px-4 py-3 rounded-md bg-slate-950/50 border border-white/5 text-white placeholder:text-slate-800 focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/5 transition-all outline-none font-bold text-xs">
                        @error('name') <span class="text-rose-500 text-[8px] font-black uppercase italic mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="group/input space-y-1.5">
                        <label class="text-[9px] font-black text-slate-500 uppercase ml-1 tracking-[0.1em] group-focus-within/input:text-amber-500 transition-colors">Canal Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="MAIL_REFERENCE"
                            class="w-full px-4 py-3 rounded-md bg-slate-950/50 border border-white/5 text-white placeholder:text-slate-800 focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/5 transition-all outline-none font-bold text-xs">
                        @error('email') <span class="text-rose-500 text-[8px] font-black uppercase italic mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Mots de passe -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="group/input space-y-1.5">
                            <label class="text-[9px] font-black text-slate-500 uppercase ml-1 tracking-[0.1em]">Cipher</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 rounded-md bg-slate-950/50 border border-white/5 text-white focus:border-amber-500/50 transition-all outline-none font-bold text-xs">
                        </div>
                        <div class="group/input space-y-1.5">
                            <label class="text-[9px] font-black text-slate-500 uppercase ml-1 tracking-[0.1em]">Verify</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-3 rounded-md bg-slate-950/50 border border-white/5 text-white focus:border-amber-500/50 transition-all outline-none font-bold text-xs">
                        </div>
                    </div>
                    @error('password') <span class="text-rose-500 text-[8px] font-black uppercase italic mt-1 block">{{ $message }}</span> @enderror

                    <!-- Consentement -->
                    <div class="group/check flex items-start space-x-3 px-1 py-2">
                        <div class="relative flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" required
                                class="peer w-4 h-4 rounded-sm bg-slate-950 border border-white/10 checked:bg-amber-500 checked:border-amber-500 transition-all cursor-pointer appearance-none">
                            <svg class="absolute w-3 h-3 text-slate-950 pointer-events-none hidden peer-checked:block left-0.5" xmlns="http://www.w3.org" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                        <label for="terms" class="text-[9px] font-bold text-slate-500 uppercase tracking-tighter cursor-pointer group-hover/check:text-slate-300 transition-colors leading-tight italic">
                            J'accepte les <span class="text-amber-500 underline decoration-amber-500/20 underline-offset-2">Protocoles ASFM</span>.
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full group/btn relative py-3.5 rounded-md bg-amber-500 hover:bg-amber-400 text-slate-950 font-black uppercase tracking-[0.2em] text-[10px] transition-all duration-500 shadow-lg shadow-amber-500/20 active:scale-95">
                        Déployer_Profil
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-white/5 text-center relative z-10">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 text-slate-500 hover:text-white transition-colors group/link">
                        <span class="text-[9px] font-black uppercase tracking-[0.1em]">Déjà accrédité ?</span>
                        <span class="text-[9px] font-black uppercase text-amber-500 underline decoration-amber-500/30 underline-offset-4 tracking-[0.1em]">Terminal_Login</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts::auth-app>
