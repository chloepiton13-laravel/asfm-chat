<x-layouts::auth-app>
<div class="flex-1 flex items-center justify-center p-6 bg-[#050714]">
    <div class="w-full max-w-[440px] relative">

        <!-- EFFET DE LUEUR ARRIÈRE-PLAN -->
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-[100px] pointer-events-none"></div>

        <!-- Header Ace Berg -->
        <div class="relative z-10 mb-12 text-center">
            <p class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.5em] italic mb-3">System Recovery</p>
            <h1 class="text-4xl font-black text-white italic uppercase tracking-tighter leading-none">Accès Perdu</h1>
            <p class="text-slate-500 mt-4 text-[11px] font-bold uppercase tracking-widest leading-relaxed px-10">
                Identification requise pour générer un lien de réinitialisation.
            </p>
        </div>

        <!-- Card Ace Berg -->
        <div class="relative bg-[#0A0D2E]/40 backdrop-blur-xl rounded-[2.5rem] border border-white/5 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] overflow-hidden">

            <!-- Message de succès (Session Status) -->
            @if (session('status'))
                <div class="bg-emerald-500/10 p-5 border-b border-emerald-500/20 text-[10px] text-emerald-400 font-black uppercase tracking-widest text-center italic">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="p-10 flex flex-col gap-8">
                @csrf

                <!-- Email Input -->
                <div class="space-y-4">
                    <label for="email" class="block text-[9px] font-black text-emerald-500 uppercase tracking-[0.3em] italic ml-1">
                        Adresse Email Terminal
                    </label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="USER@ACEBERG-SYSTEMS.COM"
                            class="w-full py-5 px-6 bg-black/40 border-2 @error('email') border-red-500 @else border-white/5 @enderror rounded-2xl focus:border-emerald-500 outline-none transition-all text-white text-sm font-bold tracking-wider placeholder-white/5 uppercase italic" />
                    </div>
                    @error('email') <p class="text-[10px] font-bold text-red-500 mt-2 text-center uppercase tracking-tighter">{{ $message }}</p> @enderror
                </div>

                <!-- Submit Button Ace Berg -->
                <button type="submit"
                    class="group relative w-full bg-white hover:bg-emerald-500 text-[#050714] hover:text-white font-black py-5 rounded-2xl shadow-2xl transition-all duration-500 active:scale-[0.97] flex items-center justify-center overflow-hidden">
                    <span class="relative z-10 text-[11px] uppercase tracking-[0.4em] italic">Envoyer le lien</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent w-full -translate-x-full group-hover:animate-[shimmer_2s_infinite]"></div>
                </button>
            </form>

            <!-- Back to Login -->
            <div class="px-10 py-6 bg-black/20 border-t border-white/5 text-center">
                <a href="{{ route('login') }}" class="text-[9px] text-slate-500 font-black uppercase tracking-widest hover:text-white transition-colors italic">
                    <span class="opacity-50 mr-2">←</span> Retour au terminal
                </a>
            </div>
        </div>

        <!-- Footer Branding -->
        <p class="mt-10 text-center text-[8px] font-black text-white/10 uppercase tracking-[0.8em]">Ace Berg Systems • Protocol 4-0-4</p>
    </div>
</div>

<style>
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(200%); }
}
</style>
</x-layouts::auth-app>
