<!-- FICHIER : resources/views/auth/login.blade.php -->
<x-layouts::auth-app>
    @slot('title', 'Accès Système | Ace Berg Onyx')

    <div class="min-h-screen w-full flex items-center justify-center bg-[#050505] p-6 selection:bg-amber-500/40">
        <div class="max-w-[440px] w-full relative">

            <!-- EFFET SCANLINE ACE BERG (Animation plus lente et technique) -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden z-20 rounded-3xl">
                <div class="w-full h-[2px] bg-amber-500/10 shadow-[0_0_20px_#f59e0b] animate-[scan_4s_linear_infinite] opacity-20"></div>
            </div>

            <!-- FILIGRANE RADAR (SVG Ace Berg Signature) -->
            <div class="absolute -top-20 -left-20 opacity-[0.03] pointer-events-none transform -rotate-12">
                <svg xmlns="http://www.w3.org" class="w-80 h-80 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.5">
                    <circle cx="12" cy="12" r="9" />
                    <circle cx="12" cy="12" r="5" />
                    <path d="M12 3v18M3 12h18" />
                </svg>
            </div>

            <!-- HEADER IMPACT MAX -->
            <div class="relative z-10 text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/5 border border-amber-500/10 mb-6">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-amber-500"></span>
                    </span>
                    <span class="text-[9px] font-black text-amber-500 uppercase tracking-[0.5em] italic">Encrypted Connection</span>
                </div>

                <h1 class="text-7xl font-black uppercase tracking-[-0.08em] text-white italic leading-none mb-4 group-hover:text-amber-500 transition-colors duration-700">
                    ASFM<span class="text-amber-500">.</span>
                </h1>

                <div class="flex items-center justify-center gap-4">
                    <span class="h-[1px] w-12 bg-white/10"></span>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.4em] italic">Auth Protocol v2.0</p>
                    <span class="h-[1px] w-12 bg-white/10"></span>
                </div>
            </div>

            <!-- PANEL ONYX (Style Ace Berg) -->
            <div class="bg-[#0A0A0A] backdrop-blur-3xl p-10 rounded-[2.8rem] border border-white/5 shadow-[0_50px_100px_-20px_rgba(0,0,0,1)] relative overflow-hidden group">

                <!-- Glow d'angle subtil -->
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-amber-500/5 rounded-full blur-[80px] group-hover:bg-amber-500/10 transition-all duration-1000"></div>

                <form method="POST" action="{{ route('login') }}" class="space-y-8 relative z-10">
                    @csrf

                    <!-- Identifiant -->
                    <div class="space-y-3">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] italic ml-1 group-focus-within:text-amber-500 transition-colors">
                            System_ID
                        </label>
                        <div class="relative">
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                placeholder="USER_@ASFM"
                                class="w-full px-6 py-5 rounded-2xl bg-black/40 border border-white/5 text-white placeholder:text-slate-800 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/5 transition-all outline-none font-black text-xs tracking-widest uppercase italic">
                        </div>
                        @error('email') <span class="text-rose-500 text-[8px] font-black uppercase italic mt-1 block tracking-tighter">{{ $message }}</span> @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div class="space-y-3">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] italic">Access_Key</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[8px] text-slate-700 hover:text-amber-500 transition-colors font-black uppercase italic tracking-tighter">Lost Key?</a>
                            @endif
                        </div>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="w-full px-6 py-5 rounded-2xl bg-black/40 border border-white/5 text-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/5 transition-all outline-none font-black text-xs tracking-[0.5em]">
                        @error('password') <span class="text-rose-500 text-[8px] font-black uppercase italic mt-1 block tracking-tighter">{{ $message }}</span> @enderror
                    </div>

                    <!-- Bouton Action Massive -->
                    <button type="submit"
                        class="group/btn relative w-full py-5 rounded-2xl bg-white hover:bg-amber-500 text-[#050505] font-black uppercase tracking-[0.4em] text-[11px] transition-all duration-500 shadow-2xl active:scale-95 overflow-hidden italic">
                        <span class="relative z-10">Initialiser Session</span>
                        <!-- Effet de balayage lumineux -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent w-full -translate-x-full group-hover/btn:animate-[shimmer_2s_infinite]"></div>
                    </button>
                </form>

                <!-- Footer Lien -->
                <div class="mt-12 pt-8 border-t border-white/5 text-center relative z-10">
                    <a href="{{ route('register') }}"
                       class="inline-flex flex-col items-center gap-2 group/link">
                        <span class="text-[8px] font-black uppercase tracking-[0.4em] text-slate-600 group-hover/link:text-slate-400 transition-colors">Unauthorized?</span>
                        <span class="text-[10px] font-black uppercase text-white group-hover/link:text-amber-500 transition-colors tracking-widest italic border-b-2 border-amber-500/20 group-hover/link:border-amber-500 pb-1">
                            Créer une accréditation
                        </span>
                    </a>
                </div>
            </div>

            <!-- Footer Ace Berg Systems -->
            <p class="mt-12 text-center text-[9px] font-black text-white/5 uppercase tracking-[1em] italic">Ace Berg Technologies</p>
        </div>
    </div>

    <style>
        @keyframes scan {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(500%); }
        }
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
    </style>
</x-layouts::auth-app>
