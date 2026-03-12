<x-layouts::auth-app>
    @slot('title', 'Authentification | Système Onyx')

    <div class="min-h-screen w-full flex items-center justify-center bg-[#050505] p-4 selection:bg-amber-500/30">
        <div class="max-w-md w-full relative">

            <!-- Effet Scanline Global -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden z-20 rounded-lg">
                <div class="w-full h-[1px] bg-amber-500/20 shadow-[0_0_15px_#f59e0b] animate-scan opacity-30"></div>
            </div>

            <!-- Filigrane SVG en arrière-plan -->
            <div class="absolute -top-12 -right-12 opacity-5 pointer-events-none transform rotate-12">
                <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-64 h-64 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6.119c-.035.505-.054 1.015-.054 1.531 0 3.158 1.134 6.041 3.028 8.282a14.993 14.993 0 0013.06 4.423c1.894-2.24 3.028-5.224 3.028-8.282 0-.516-.019-1.026-.054-1.531a11.959 11.959 0 01-7.848-4.647L12 2.664z" />
                </svg>
            </div>

            <!-- Header ASFM IMPACT MAX (Extérieur au panel) -->
            <div class="relative z-10 text-center mb-8">
                <div class="inline-block px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 mb-4">
                    <span class="text-[8px] font-black text-amber-500 uppercase tracking-[0.3em] italic">Identification</span>
                </div>

                <h1 class="text-6xl font-black uppercase tracking-tighter text-amber-500 drop-shadow-[0_0_15px_rgba(245,158,11,0.5)] italic leading-none mb-2">
                    ASFM
                </h1>

                <h2 class="text-xl font-black text-white uppercase tracking-tighter mb-1 border-t border-white/10 pt-2 inline-block">
                    Accès Système
                </h2>
                <p class="text-slate-500 text-[9px] font-bold uppercase tracking-widest italic block">Entrez vos codes d'accréditation</p>
            </div>

            <!-- Panel Flouté (Onyx) -->
            <div class="bg-white/5 backdrop-blur-2xl p-8 rounded-lg border border-white/10 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.8)] relative overflow-hidden transition-all duration-700">

                <form method="POST" action="{{ route('login') }}" class="space-y-5 relative z-10">
                    @csrf

                    <div class="group/input space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase ml-1 tracking-[0.1em] group-focus-within/input:text-amber-500 transition-colors">Identifiant</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="ID_ACCES"
                            class="w-full px-4 py-3.5 rounded-md bg-slate-950/50 border border-white/5 text-white placeholder:text-slate-800 focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/5 transition-all outline-none font-bold text-xs">
                        @error('email') <span class="text-rose-500 text-[8px] font-black uppercase italic mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="group/input space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.1em] group-focus-within/input:text-amber-500 transition-colors">Code d'accès</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[8px] text-slate-600 hover:text-amber-500 transition-colors font-bold uppercase italic tracking-tighter">Oubli ?</a>
                            @endif
                        </div>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3.5 rounded-md bg-slate-950/50 border border-white/5 text-white focus:border-amber-500/50 focus:ring-2 focus:ring-amber-500/5 transition-all outline-none font-bold text-xs">
                        @error('password') <span class="text-rose-500 text-[8px] font-black uppercase italic mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit"
                        class="w-full group/btn relative py-3.5 rounded-md bg-amber-500 hover:bg-amber-400 text-slate-950 font-black uppercase tracking-[0.2em] text-[10px] transition-all duration-500 shadow-lg shadow-amber-500/20 active:scale-95">
                        Initialiser la session
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-white/5 text-center relative z-10">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-2 text-slate-500 hover:text-white transition-colors group/link">
                        <span class="text-[9px] font-black uppercase tracking-[0.1em]">Nouveau profil ?</span>
                        <span class="text-[9px] font-black uppercase text-amber-500 underline decoration-amber-500/30 underline-offset-4 tracking-[0.1em]">S'inscrire</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts::auth-app>
