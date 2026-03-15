<x-layouts::auth-app>
<div class="flex-1 flex items-center justify-center p-6 bg-[#050714]">
    <div class="w-full max-w-[440px] relative">

        <!-- EFFET DE LUEUR ARRIÈRE-PLAN -->
        <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-[100px] pointer-events-none"></div>

        <!-- Header Ace Berg -->
        <div class="relative z-10 mb-12 text-center">
            <p class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.5em] italic mb-3">Security Override</p>
            <h1 class="text-4xl font-black text-white italic uppercase tracking-tighter leading-none">Nouveau Code</h1>
            <p class="text-slate-500 mt-4 text-[11px] font-bold uppercase tracking-widest leading-relaxed px-10">
                Définissez vos nouvelles identifiantes d'accès au terminal.
            </p>
        </div>

        <!-- Card Ace Berg -->
        <div class="relative bg-[#0A0D2E]/40 backdrop-blur-xl rounded-[2.5rem] border border-white/5 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] overflow-hidden">

            <form method="POST" action="{{ route('password.update') }}" class="p-10 flex flex-col gap-6">
                @csrf

                <!-- Le Token (Caché) -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email (Readonly Style) -->
                <div class="space-y-3">
                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] italic ml-1">Cible Identification</label>
                    <input type="email" name="email" value="{{ old('email', $request->email) }}" required readonly
                        class="w-full py-4 px-6 bg-white/5 border border-white/5 rounded-2xl text-slate-400 text-xs font-bold tracking-wider cursor-not-allowed outline-none" />
                </div>

                <!-- Nouveau mot de passe -->
                <div class="space-y-3">
                    <label for="password" class="block text-[9px] font-black text-emerald-500 uppercase tracking-[0.3em] italic ml-1">Nouveau Password</label>
                    <input type="password" id="password" name="password" required autofocus placeholder="••••••••"
                        class="w-full py-4 px-6 bg-black/40 border-2 @error('password') border-red-500 @else border-white/5 @enderror rounded-2xl focus:border-emerald-500 outline-none transition-all text-white text-sm font-bold tracking-widest placeholder-white/5" />
                    @error('password') <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-tighter">{{ $message }}</p> @enderror
                </div>

                <!-- Confirmation -->
                <div class="space-y-3">
                    <label for="password_confirmation" class="block text-[9px] font-black text-emerald-500 uppercase tracking-[0.3em] italic ml-1">Confirmation</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••"
                        class="w-full py-4 px-6 bg-black/40 border-2 border-white/5 rounded-2xl focus:border-emerald-500 outline-none transition-all text-white text-sm font-bold tracking-widest placeholder-white/5" />
                </div>

                <!-- Submit Button Ace Berg -->
                <button type="submit"
                    class="group relative w-full bg-white hover:bg-emerald-500 text-[#050714] hover:text-white font-black py-5 rounded-2xl shadow-2xl transition-all duration-500 active:scale-[0.97] flex items-center justify-center overflow-hidden mt-4">
                    <span class="relative z-10 text-[11px] uppercase tracking-[0.4em] italic">Mettre à jour l'accès</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent w-full -translate-x-full group-hover:animate-[shimmer_2s_infinite]"></div>
                </button>
            </form>
        </div>

        <!-- Footer Branding -->
        <p class="mt-10 text-center text-[8px] font-black text-white/10 uppercase tracking-[0.8em]">Ace Berg Systems • Protocol 7-0-1</p>
    </div>
</div>

<style>
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(200%); }
}
</style>
</x-layouts::auth-app>
