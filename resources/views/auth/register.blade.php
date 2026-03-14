<!-- FICHIER : resources/views/auth/register.blade.php -->
<x-layouts::auth-app>
    @slot('title', 'Enregistrement | Système Onyx')

    <div class="min-h-screen w-full flex items-center justify-center bg-[#050505] p-6 selection:bg-amber-500/30">
        <div class="max-w-[450px] w-full relative">

            <!-- Effet Scanline Ace Berg -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden z-20 rounded-3xl">
                <div class="w-full h-[2px] bg-amber-500/10 shadow-[0_0_20px_#f59e0b] animate-[scan_4s_linear_infinite] opacity-20"></div>
            </div>

            <!-- Header Impact Max -->
            <div class="relative z-10 text-center mb-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/5 border border-amber-500/10 mb-6">
                    <span class="text-[8px] font-black text-amber-500 uppercase tracking-[0.4em] italic underline underline-offset-4 decoration-amber-500/20">Recrutement_S04</span>
                </div>

                <h1 class="text-7xl font-black uppercase tracking-[-0.08em] text-white italic leading-none mb-4 group-hover:text-amber-500 transition-colors duration-700">
                    ASFM<span class="text-amber-500">.</span>
                </h1>
                <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.5em] italic block">Initialisation de l'accréditation</p>
            </div>

            <!-- Panel Onyx -->
            <div class="bg-[#0A0A0A] backdrop-blur-3xl p-8 rounded-[2.5rem] border border-white/5 shadow-[0_50px_100px_-20px_rgba(0,0,0,1)] relative overflow-hidden group">

                <form method="POST" action="{{ route('register') }}" class="space-y-5 relative z-10">
                    @csrf

                    <!-- Nom Complet -->
                    <div class="group/input space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase ml-1 tracking-[0.2em] group-focus-within/input:text-amber-500 transition-colors italic">Full_Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="NOM_PRENOM"
                            class="w-full px-5 py-4 rounded-2xl bg-black/40 border border-white/5 text-white placeholder:text-slate-800 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/5 transition-all outline-none font-black text-xs tracking-widest uppercase italic">
                        @error('name') <span class="text-rose-500 text-[8px] font-black uppercase italic mt-1 block tracking-tighter">{{ $message }}</span> @enderror
                    </div>

                    <!-- Username (CRUCIAL pour votre logique Ace Berg) -->
                    <div class="group/input space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase ml-1 tracking-[0.2em] group-focus-within/input:text-amber-500 transition-colors italic">System_Handle</label>
                        <input type="text" name="username" value="{{ old('username') }}" required placeholder="USER_UNIQUE_ID"
                            class="w-full px-5 py-4 rounded-2xl bg-black/40 border border-white/5 text-amber-500 placeholder:text-slate-800 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/5 transition-all outline-none font-black text-xs tracking-widest uppercase italic shadow-inner">
                        @error('username') <span class="text-rose-500 text-[8px] font-black uppercase italic mt-1 block tracking-tighter">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="group/input space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase ml-1 tracking-[0.2em] group-focus-within/input:text-amber-500 transition-colors italic">Node_Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="MAIL_REFERENCE"
                            class="w-full px-5 py-4 rounded-2xl bg-black/40 border border-white/5 text-white placeholder:text-slate-800 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/5 transition-all outline-none font-black text-xs tracking-widest uppercase italic">
                        @error('email') <span class="text-rose-500 text-[8px] font-black uppercase italic mt-1 block tracking-tighter">{{ $message }}</span> @enderror
                    </div>

                    <!-- Cipher & Verification -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="group/input space-y-2">
                            <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] italic">Cipher</label>
                            <input type="password" name="password" required
                                class="w-full px-5 py-4 rounded-2xl bg-black/40 border border-white/5 text-white focus:border-amber-500 outline-none font-black text-xs tracking-[0.5em]">
                        </div>
                        <div class="group/input space-y-2">
                            <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] italic">Verify</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-5 py-4 rounded-2xl bg-black/40 border border-white/5 text-white focus:border-amber-500 outline-none font-black text-xs tracking-[0.5em]">
                        </div>
                    </div>
                    @error('password') <span class="text-rose-500 text-[8px] font-black uppercase italic mt-1 block tracking-tighter">{{ $message }}</span> @enderror

                    <!-- Protocol Consent -->
                    <div class="flex items-center space-x-3 px-1 py-4">
                        <input id="terms" name="terms" type="checkbox" required
                            class="w-4 h-4 rounded-md bg-black border border-white/10 text-amber-500 focus:ring-0 focus:ring-offset-0 transition-all cursor-pointer">
                        <label for="terms" class="text-[9px] font-black text-slate-600 uppercase tracking-tighter leading-tight italic">
                            Accepter les <span class="text-amber-500 underline decoration-amber-500/20 underline-offset-2">Protocoles_D'Accès</span>.
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full group/btn relative py-5 rounded-2xl bg-white hover:bg-amber-500 text-[#050505] font-black uppercase tracking-[0.4em] text-[11px] transition-all duration-500 shadow-2xl active:scale-95 overflow-hidden italic">
                        <span class="relative z-10">Déployer_Profil</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent w-full -translate-x-full group-hover/btn:animate-[shimmer_2s_infinite]"></div>
                    </button>
                </form>

                <div class="mt-10 pt-6 border-t border-white/5 text-center relative z-10">
                    <a href="{{ route('login') }}" class="group/link flex flex-col items-center gap-2">
                        <span class="text-[8px] font-black uppercase tracking-[0.4em] text-slate-600">Identification_Prête?</span>
                        <span class="text-[9px] font-black uppercase text-amber-500 border-b border-amber-500/20 pb-1 group-hover/link:border-amber-500 transition-all">Terminal_Login</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes scan { 0% { transform: translateY(-100%); } 100% { transform: translateY(500%); } }
        @keyframes shimmer { 0% { transform: translateX(-100%); } 100% { transform: translateX(200%); } }
    </style>
</x-layouts::auth-app>
