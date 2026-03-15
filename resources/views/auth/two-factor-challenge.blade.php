<x-layouts::auth-app>
<div class="flex-1 flex items-center justify-center p-6 bg-[#050714]">
    <!-- x-data centralisé pour gérer le basculement entre les deux types de codes -->
    <div x-data="{ recovery: false }" class="w-full max-w-[440px] relative">

        <!-- EFFET DE LUEUR ARRIÈRE-PLAN -->
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-[100px] pointer-events-none"></div>

        <!-- Header Ace Berg -->
        <div class="relative z-10 mb-12 text-center">
            <p class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.5em] italic mb-3">Security Protocol</p>
            <h1 class="text-4xl font-black text-white italic uppercase tracking-tighter leading-none"
                x-text="recovery ? 'Recovery Mode' : 'Vérification'">Vérification</h1>
            <p class="text-slate-500 mt-4 text-[11px] font-bold uppercase tracking-widest leading-relaxed px-10"
               x-text="recovery ? 'Saisissez l\'un de vos codes de secours permanents.' : 'Saisissez le jeton généré par votre terminal de sécurité.'">
                Saisissez le jeton généré par votre terminal de sécurité.
            </p>
        </div>

        <!-- Card Ace Berg -->
        <div class="relative bg-[#0A0D2E]/40 backdrop-blur-xl rounded-[2.5rem] border border-white/5 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] overflow-hidden">

            <form method="POST" action="{{ route('two-factor.login') }}" class="p-10 flex flex-col gap-8">
                @csrf

                <!-- Code d'authentification (OTP) -->
                <div x-show="!recovery" class="space-y-4">
                    <label for="code" class="block text-[9px] font-black text-emerald-500 uppercase tracking-[0.3em] italic ml-1">
                        Code de sécurité
                    </label>
                    <div class="relative">
                        <input type="text" id="code" name="code" inputmode="numeric" autofocus autocomplete="one-time-code"
                            placeholder="000000"
                            class="w-full py-6 bg-black/40 border-2 @error('code') border-red-500 @else border-white/5 @enderror rounded-2xl focus:border-emerald-500 outline-none transition-all text-white tracking-[0.6em] text-center text-3xl font-black italic placeholder-white/5" />
                    </div>
                    @error('code') <p class="text-[10px] font-bold text-red-500 mt-2 text-center uppercase tracking-tighter">{{ $message }}</p> @enderror
                </div>

                <!-- Code de secours (Recovery) -->
                <div x-show="recovery" x-cloak class="space-y-4">
                    <label for="recovery_code" class="block text-[9px] font-black text-amber-500 uppercase tracking-[0.3em] italic ml-1">
                        Code de secours
                    </label>
                    <div class="relative">
                        <input type="text" id="recovery_code" name="recovery_code" placeholder="XXXX-XXXX-XXXX"
                            class="w-full py-6 bg-black/40 border-2 @error('recovery_code') border-red-500 @else border-white/5 @enderror rounded-2xl focus:border-amber-500 outline-none transition-all text-white font-mono text-center text-lg tracking-widest placeholder-white/5 uppercase" />
                    </div>
                    @error('recovery_code') <p class="text-[10px] font-bold text-red-500 mt-2 text-center uppercase tracking-tighter">{{ $message }}</p> @enderror
                </div>

                <!-- Toggle Switch -->
                <div class="text-center">
                    <button type="button" @click="recovery = !recovery"
                            class="text-[9px] text-slate-500 font-black uppercase tracking-widest hover:text-white transition-colors italic border-b border-slate-800 pb-1">
                        <span x-text="recovery ? 'Utiliser un code OTP' : 'Utiliser un code de secours ?'"></span>
                    </button>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="group relative w-full bg-white hover:bg-emerald-500 text-[#050714] hover:text-white font-black py-5 rounded-2xl shadow-2xl transition-all duration-500 active:scale-[0.97] flex items-center justify-center overflow-hidden">
                    <span class="relative z-10 text-[11px] uppercase tracking-[0.4em] italic">Valider l'accès</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent w-full -translate-x-full group-hover:animate-[shimmer_2s_infinite]"></div>
                </button>
            </form>
        </div>

        <!-- Footer Branding -->
        <p class="mt-10 text-center text-[8px] font-black text-white/10 uppercase tracking-[0.8em]">Ace Berg Systems</p>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(200%); }
}
</style>
</x-layouts::auth-app>
